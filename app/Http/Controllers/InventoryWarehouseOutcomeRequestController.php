<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryWarehouseOutcomeRequestRequest;
use App\Http\Requests\UpdateInventoryWarehouseOutcomeRequestRequest;
use App\Models\InventoryWarehouseOutcomeRequest;
use App\Helpers\Enums\InventoryWarehouseOutcomeRequestStatus;
use Illuminate\Support\Str;
use App\Helpers\Toolbox;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use OneSignal;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use App\Models\InventoryWarehouse;

use App\Support\Creators\Inventory\WarehouseOutcomeRequestRequestedProducts\WarehouseOutcomeRequestRequestedProductsPdfCreator;
use App\Support\Creators\Inventory\WarehouseOutcomeRequestDispatchedProducts\WarehouseOutcomeRequestDispatchedProductsPdfCreator;
use App\Support\Creators\Inventory\WarehouseOutcomeRequestReceivedProducts\WarehouseOutcomeRequestReceivedProductsPdfCreator;



class InventoryWarehouseOutcomeRequestController extends Controller
{
    public function index()
    {
        //
    }

    public function listMeOutcomeRequests()
    {
        $meUser = auth()->id();
        $outcomeRequests = InventoryWarehouseOutcomeRequest::where('user_id', $meUser)->get();
        return response()->json($outcomeRequests->toArray());
    }

    public function listLoans(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $loans = $warehouseOutcomeRequest->loans;
        $loans->each(function ($loan) {
            $loan->productItem;
            $loan->productItem?->product;
            $loan->loanedBy;
            $loan->loanedTo;
        });

        return response()->json($loans->toArray());
    }


    public function listChatMessages(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $meUser = auth()->id();
        $warehouseOutcomeRequest->messages = array_map(function($observation) use ($meUser){
            if ($observation['user_id'] !== $meUser) {
                $observation['read_at'] = now();
                if ($observation['received_at'] === null) {
                    $observation['received_at'] = now();
                }
            }
            return $observation;
        }, $warehouseOutcomeRequest->messages);
        $warehouseOutcomeRequest->save();

        return response()->json($warehouseOutcomeRequest->messages);
    }

    public function storeChatMessage(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $validated = request()->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|array',
            'image.data' => 'nullable|string',
            'image.size' => 'integer',

            'document' => 'nullable|array',
            'document.data' => 'nullable|string',
            'document.size' => 'integer',
            'document.type' => 'string',
            'document.name' => 'string',

            'video' => 'nullable|array',
            'video.data' => 'nullable|string',
            'video.size' => 'integer',
            'video.type' => 'string',
            'video.duration' => 'integer',

            'audio' => 'nullable|array',
            'audio.data' => 'nullable|string',
            'audio.size' => 'integer',
            'audio.type' => 'string',
            'audio.duration' => 'integer',

            'location' => 'nullable|string',
            'reply_to' => 'nullable|string',
            'react_to' => 'nullable|string',

            'written_at' => 'required|date',
            'sent_at' => 'nullable|date',
            'received_at' => 'nullable|date',
            'read_at' => 'nullable|date',
        ]);

        $validated['id'] = Str::uuid();
        $validated['sent_at'] = now();
        $validated['user_id'] = auth()->id();

        if (isset($validated['image'])){
            $imageValidation = Toolbox::validateImageBase64($validated['image']['data']);
            if ($imageValidation->isImage){
                if (!$imageValidation->isValid){
                    return response()->json([
                        'error' => [
                            'message' => $imageValidation->message,
                        ]
                    ], 400);
                }

                $imageResource = Image::make($validated['image']['data']);
                $imageEncoded = $imageResource->encode('png')->getEncoded();

                $imageId = Str::uuid();
                $path = 'warehouse-chat/' . $imageId;

                Storage::disk('public')->put($path, $imageEncoded);

                $validated['image'] = [
                    'data' => $imageId,
                    'size' => strlen($imageEncoded),
                ];
            }
        }
        if (isset($validated['document'])){
            $documentDecoded = base64_decode($validated['document']['data']);
            $documentId = Str::uuid();
            $path = 'warehouse-chat/' . $documentId;
            Storage::disk('public')->put($path, $documentDecoded);
            $validated['document'] = [
                'data' => $documentId,
                'size' => $validated['document']['size'],
                'type' => $validated['document']['type'],
                'name' => $validated['document']['name'],
            ];
        }
        if (isset($validated['video'])){
            $documentDecoded = base64_decode($validated['video']['data']);
            $documentId = Str::uuid();
            $path = 'warehouse-chat/' . $documentId;
            Storage::disk('public')->put($path, $documentDecoded);
            $validated['video'] = [
                'data' => $documentId,
                'size' => $validated['video']['size'],
                'duration' => $validated['video']['duration'],
                'type' => $validated['video']['type'],
            ];
        }
        if (isset($validated['audio'])){
            $documentDecoded = base64_decode($validated['audio']['data']);
            $documentId = Str::uuid();
            $path = 'warehouse-chat/' . $documentId;
            Storage::disk('public')->put($path, $documentDecoded);
            $validated['audio'] = [
                'data' => $documentId,
                'size' => $validated['audio']['size'],
                'duration' => $validated['audio']['duration'],
                'type' => $validated['audio']['type'],
            ];
        }


        $warehouseOutcomeRequest->messages = array_merge($warehouseOutcomeRequest->messages, [$validated]);

        //Now, we need to mark all the other from user_id that is not me messages as read:
        $warehouseOutcomeRequest->messages = array_map(function($observation) use ($validated) {
            if ($observation['user_id'] !== $validated['user_id']) {
                $observation['read_at'] = now();
                if ($observation['received_at'] === null) {
                    $observation['received_at'] = now();
                }
            }
            return $observation;
        }, $warehouseOutcomeRequest->messages);

        $warehouseOutcomeRequest->save();


        $notificationUrlOnUserReports = env('APP_WEB_URL') . '/inventory/outcome-requests/' . $warehouseOutcomeRequest->id. '/chat';
        $notifications = [];

        $user = auth()->user();
        $notifications[] = [
            'headings' => '💬 Chat Pedido #00' . $warehouseOutcomeRequest->id,
            'message' => (function() use ($user, $validated){
                if (isset($validated['image']) && $validated['text'] !== null){
                    return $user->name . ' envió una imagen 🌅: "' . $validated['text'] . '"';
                }elseif (isset($validated['image'])){
                    return $user->name . ' envió una imagen 🌅.';
                }elseif (isset($validated['document']) && $validated['text'] !== null){
                    return $user->name . ' envió un documento 📄: "' . $validated['text'] . '"';
                }elseif (isset($validated['document'])){
                    return $user->name . ' envió un documento 📄.';
                }elseif (isset($validated['react_to']) && $validated['text'] !== null){
                    return $user->name . ' reaccionó a un mensaje: "' . $validated['text'] . '"';
                }elseif (isset($validated['reply_to']) && $validated['text'] !== null){
                    return $user->name . ' respondió a un mensaje: "' . $validated['text'] . '"';
                }elseif ($validated['text'] !== null){
                    return $user->name . ' envió: "' . $validated['text'] . '"';
                }
            })(),
            'users_ids' => (function() use ($user, $warehouseOutcomeRequest){
                if ($warehouseOutcomeRequest->user_id === $user->id){
                    return $warehouseOutcomeRequest->warehouse->owners;
                }else{
                    return [$warehouseOutcomeRequest->user_id];
                }
            })(),
            'data' => [
                'deepLink' => $notificationUrlOnUserReports
            ]
        ];

        if (env('APP_ENV') !== 'local'){
            foreach ($notifications as $notification) {
                foreach ($notification['users_ids'] as $userId) {
                    OneSignal::sendNotificationToExternalUser(
                        headings: $notification['headings'],
                        message: $notification['message'],
                        userId: Toolbox::getOneSignalUserId($userId),
                        data: $notification['data']
                    );
                }
            }
        }



        $warehouseOutcomeRequest = InventoryWarehouseOutcomeRequest::find($warehouseOutcomeRequest->id);

        //Now we need to mark the message as received:
        $warehouseOutcomeRequest->messages = array_map(function($observation) use ($validated) {
            if ($observation['id'] == $validated['id']) {
                $observation['received_at'] = now();
            }
            return $observation;
        }, $warehouseOutcomeRequest->messages);

        $warehouseOutcomeRequest->save();

        return response()->json($warehouseOutcomeRequest->messages);
    }

    public function store(StoreInventoryWarehouseOutcomeRequestRequest $request)
    {
        $validated = $request->validated();

        $data = array_merge($validated, [
            'user_id' => auth()->id(),
            'status' =>  InventoryWarehouseOutcomeRequestStatus::Draft,
            'messages' => []
        ]);
        $inventoryWarehouseOutcomeRequest = InventoryWarehouseOutcomeRequest::create($data);

        $inventoryWarehouseOutcomeRequest->requested_products = [];
        foreach ($validated['requested_products'] as $requestedProduct) {
            $inventoryWarehouseOutcomeRequest->addRequestedProduct($requestedProduct['product_id'], $requestedProduct['quantity']);
        }

        $inventoryWarehouseOutcomeRequest->save();

        $inventoryWarehouseOutcomeRequest->changeStatus(InventoryWarehouseOutcomeRequestStatus::Requested);

        return response()->json(['message' => 'Warehouse outcome request created', 'warehouse_outcome_request' => $inventoryWarehouseOutcomeRequest->toArray()]);
    }

    public function showChatAttachment(string $chatAttachmentId)
    {
        $attachmentId = $chatAttachmentId;
        if (!$attachmentId){
            return response()->json([
                'error' => [
                    'message' => 'Attachment not uploaded yet',
                ]
            ], 400);
        }

        $path = 'warehouse-chat/' . $attachmentId;
        $attachmentExists = Storage::disk('public')->exists($path);
        if (!$attachmentExists){
            return response()->json([
                'error' => [
                    'message' => 'Attachment missing',
                ]
            ], 400);
        }

        $attachment = Storage::disk('public')->get($path);
        return response()->json(['attachment' => base64_encode($attachment)]);
    }

    public function show(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        return response()->json($warehouseOutcomeRequest->toArray());
    }

    public function update(UpdateInventoryWarehouseOutcomeRequestRequest $request, InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $validated = $request->validated();

        $status = $validated['status'];

        unset($validated['status']);


        if (isset($validated['requested_products']) && !is_null($validated['requested_products'])){
            foreach ($validated['requested_products'] as &$requestedProduct) {
                $requestedProduct['quantity'] = (float) $requestedProduct['quantity'];
                $requestedProduct['product_id'] = (int) $requestedProduct['product_id'];
            }
        }

        if (isset($validated['received_products']) && !is_null($validated['received_products'])){
            foreach ($validated['received_products'] as &$receivedProduct) {
                $receivedProduct['quantity'] = (float) $receivedProduct['quantity'];
                $receivedProduct['product_id'] = (int) $receivedProduct['product_id'];
            }
        }


        $warehouseOutcomeRequest->update($validated);

        $warehouseOutcomeRequest->changeStatus(InventoryWarehouseOutcomeRequestStatus::from($status));

        return response()->json(['message' => 'Warehouse outcome request updated', 'warehouse_outcome_request' => $warehouseOutcomeRequest->toArray()]);
    }

    public function destroy(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        //Check if the request is in a deletable status:
        if ($warehouseOutcomeRequest->status !== InventoryWarehouseOutcomeRequestStatus::Draft){
            return response()->json([
                'error' => [
                    'message' => 'The request is not in a deletable status',
                ]
            ], 400);
        }

        $warehouseOutcomeRequest->delete();
        return response()->json(['message' => 'Warehouse outcome request deleted']);
    }

    public function downloadRequestedPDF(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $pdf = WarehouseOutcomeRequestRequestedProductsPdfCreator::new($warehouseOutcomeRequest);

        $withImages = request()->query('withImages') === 'true' ? true : false;

        $content = $pdf->create(['withImages' => $withImages])->output();

        $documentName = Str::slug($warehouseOutcomeRequest->id, '-') . '.pdf';

        $temporaryDirectory = (new TemporaryDirectory())->create();
        $tempPath = $temporaryDirectory->path($documentName);

        file_put_contents($tempPath, $content);

        return response()
            ->download($tempPath, $documentName, [
                'Content-Encoding' => 'base64',
                'Content-Length' => filesize($tempPath),
            ])->deleteFileAfterSend(true);
    }


    public function downloadDispatchedPDF(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $pdf = WarehouseOutcomeRequestDispatchedProductsPdfCreator::new($warehouseOutcomeRequest);

        $withImages = request()->query('withImages') === 'true' ? true : false;

        $content = $pdf->create(['withImages' => $withImages])->output();

        $documentName = Str::slug($warehouseOutcomeRequest->id, '-') . '.pdf';

        $temporaryDirectory = (new TemporaryDirectory())->create();
        $tempPath = $temporaryDirectory->path($documentName);

        file_put_contents($tempPath, $content);

        return response()
            ->download($tempPath, $documentName, [
                'Content-Encoding' => 'base64',
                'Content-Length' => filesize($tempPath),
            ])->deleteFileAfterSend(true);
    }

    public function downloadReceivedPDF(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $pdf = WarehouseOutcomeRequestReceivedProductsPdfCreator::new($warehouseOutcomeRequest);

        $withImages = request()->query('withImages') === 'true' ? true : false;

        $content = $pdf->create(['withImages' => $withImages])->output();

        $documentName = Str::slug($warehouseOutcomeRequest->id, '-') . '.pdf';

        $temporaryDirectory = (new TemporaryDirectory())->create();
        $tempPath = $temporaryDirectory->path($documentName);

        file_put_contents($tempPath, $content);

        return response()
            ->download($tempPath, $documentName, [
                'Content-Encoding' => 'base64',
                'Content-Length' => filesize($tempPath),
            ])->deleteFileAfterSend(true);
    }

    public function importProductsAsIncome(InventoryWarehouseOutcomeRequest $warehouseOutcomeRequest)
    {
        $validated = request()->validate([
            'warehouse_id' => 'required|integer|exists:inventory_warehouses,id',
        ]);

        if (!$warehouseOutcomeRequest->outcome){
            return response()->json([
                'error' => [
                    'message' => 'The outcome is not yet created',
                ]
            ], 400);
        }

        $warehouse = InventoryWarehouse::find($validated['warehouse_id']);


        $warehouseOutcomeRequest->outcome->transferItemsAsIncomesToWarehouse($warehouse);

        return response()->json(['message' => 'Products imported as income successfully']);
    }
}
