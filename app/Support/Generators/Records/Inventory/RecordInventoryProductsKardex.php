<?php

namespace App\Support\Generators\Records\Inventory;

use Illuminate\Support\Collection;
use DateTime;
use Carbon\Carbon;
use App\Models\InventoryWarehouseIncome;
use App\Models\InventoryProduct;
use App\Models\InventoryWarehouseOutcome;
use App\Helpers\Enums\InventoryProductItemStatus;
use App\Helpers\Toolbox;


class RecordInventoryProductsKardex
{

    private DateTime|null $startDate = null;
    private DateTime|null $endDate = null;
    private string|null $moneyType = null;
    private string|null $warehouseId = null;
    private string|null $expenseCode = null;
    private string|null $jobCode = null;
    private string|null $productId = null;


    /**
        * RecordInventoryProductsKardex constructor.

        * @param array $options
        * @param DateTime|null $options['startDate']
        * @param DateTime|null $options['endDate']
        * @param string|null $options['moneyType']
        * @param string|null $options['warehouseId']
        * @param string|null $options['expenseCode']
        * @param string|null $options['jobCode']
        * @param string|null $options['productId']
     */

    public function __construct(array $options){
        $this->startDate = $options['startDate'] ?? null;
        $this->endDate = $options['endDate'] ?? null;
        $this->moneyType = $options['moneyType'] ?? null;
        $this->warehouseId = $options['warehouseId'] ?? null;
        $this->expenseCode = $options['expenseCode'] ?? null;
        $this->jobCode = $options['jobCode'] ?? null;
        $this->productId = $options['productId'] ?? null;
    }

    private function getKardex():Collection
    {
        $options = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'moneyType' => $this->moneyType,
            'warehouseId' => $this->warehouseId,
            'expenseCode' => $this->expenseCode,
            'jobCode' => $this->jobCode,
            'productId' => $this->productId
        ];

        $list = [];

        $incomes = (function() use ($options){
            $query = InventoryWarehouseIncome::query();

            if ($options['startDate'] !== null){
                $query = $query->where('date', '>=', $options['startDate']);
            }
            if ($options['endDate'] !== null){
                $query = $query->where('date', '<=', $options['endDate']);
            }
            if ($options['moneyType'] !== null){
                $query = $query->where('currency', $options['moneyType']);
            }
            if ($options['warehouseId'] !== null){
                $query = $query->where('inventory_warehouse_id', $options['warehouseId']);
            }
            if ($options['expenseCode'] !== null){
                $query = $query->where('expense_code', $options['expenseCode']);
            }
            if ($options['jobCode'] !== null){
                $query = $query->where('job_code', $options['jobCode']);
            }

            return $query->orderBy('date');
        })();



        $incomes->each((function($income) use (&$list, $options){
            $productsIdsInIncome = $income->items()
                ->groupBy('inventory_product_id')
                ->select('inventory_product_id')
                ->pluck('inventory_product_id')
                ->unique();

            $productsIdsInIncome->each((function($productId) use ($income, &$list, $options){
                if ($options['productId'] !== null && $options['productId'] != $productId){
                    return;
                }

                $productItems = $income->items()->where('inventory_product_id', $productId);

                $product = InventoryProduct::find($productId);

                $balance = [
                    'quantity' => (clone $productItems)->count(),
                    'amount' => (clone $productItems)->first()?->buy_amount ?? 0,
                    'total' => (clone $productItems)->count() * ((clone $productItems)->first()?->buy_amount ?? 0),
                ];

                if (count($list) > 0){
                    //Add empty list item:
                    $list[] = [
                        'order' => null,
                        'product' => null,
                        'date' => null,
                        'currency' => null,
                        'job' => null,
                        'expense' => null,
                        'ticket_type' => null,
                        'ticket_number' => null,
                        'user' => null,
                        'commerce_number' => null,
                        'warehouse' => null,
                        'income' => null,
                        'outcome' => null,
                        'in_quantity' => null,
                        'in_amount' => null,
                        'in_total' => null,
                        'out_quantity' => null,
                        'out_amount' => null,
                        'out_total' => null,
                        'balance_quantity' => null,
                        'balance_amount' => null,
                        'balance_total' => null
                    ];
                }

                $internalListIndex = 1;
                $list[] = [
                    'order' => $internalListIndex,
                    'product' => $product,
                    'date' => $income->date,
                    'currency' => $income->currency,
                    'job' => $income->job,
                    'expense' => $income->expense,
                    'ticket_type' => $income->ticket_type,
                    'ticket_number' => $income->ticket_number,
                    'user' => $income->user,
                    'commerce_number' => $income->commerce_number,
                    'warehouse' => $income->warehouse,
                    'income' => $income,
                    'outcome' => null,
                    'in_quantity' => $balance['quantity'],
                    'in_amount' => $balance['amount'],
                    'in_total' => $balance['total'],
                    'out_quantity' => null,
                    'out_amount' => null,
                    'out_total' => null,
                    'balance_quantity' => $balance['quantity'],
                    'balance_amount' => $balance['amount'],
                    'balance_total' => $balance['total']
                ];

                $outcomes = (function() use ($income, $product, $options){
                    $query = InventoryWarehouseOutcome::query();
                    if ($options['startDate'] !== null){
                        $query = $query->where('date', '>=', $options['startDate']);
                    }
                    if ($options['endDate'] !== null){
                        $query = $query->where('date', '<=', $options['endDate']);
                    }

                    return $query->orderBy('date')->get();
                })();

                $outcomes->each((function($outcome) use ($income, &$list, &$balance, $product, &$internalListIndex){
                    $itemsSold = $outcome->items()->where('inventory_warehouse_income_id', $income->id)
                                                ->where('status', InventoryProductItemStatus::Sold)
                                                ->where('inventory_product_id', $product->id);

                    if ($itemsSold->count() === 0){
                        return;
                    }

                    //Balance:
                    $balance['quantity'] -= $itemsSold->count();
                    $balance['amount'] = $itemsSold->first()->sell_amount;
                    $balance['total'] -= $itemsSold->count() * $itemsSold->first()->sell_amount;

                    ++$internalListIndex;

                    $list[] = [
                        'order' => $internalListIndex,
                        'product' => $product,
                        'date' => $outcome->date,
                        'currency' => $income->currency,
                        'job' => $outcome->job,
                        'expense' => $outcome->expense,
                        'ticket_type' => $outcome->ticket_type,
                        'ticket_number' => $outcome->ticket_number,
                        'user' => $outcome->user,
                        'commerce_number' => $outcome->commerce_number,
                        'warehouse' => $outcome->warehouse,
                        'income' => null,
                        'outcome' => $outcome,
                        'in_quantity' => null,
                        'in_amount' => null,
                        'in_total' => null,
                        'out_quantity' => $itemsSold->count(),
                        'out_amount' => $itemsSold->first()->sell_amount,
                        'out_total' => $itemsSold->count() * $itemsSold->first()->sell_amount,
                        'balance_quantity' => $balance['quantity'],
                        'balance_amount' => $balance['amount'],
                        'balance_total' => $balance['total']
                    ];
                }));
            }));
        }));

        return collect($list);
    }

    private function createTable():array{
        $items = $this->getKardex();

        $body = collect($items)->map(function($item){
            return [
                'order' => $item['order'] ?? '',
                'product' => $item['product']?->name ?? '',
                'category' => $item['product']?->category ?? '',
                'date' => ($item['date'] !== null) ? Carbon::parse($item['date'])->format('d/m/Y') : '',
                'currency' => $item['currency'] ?? '',
                'job' => $item['job']?->code ?? '',
                'expense' => $item['expense']?->code ?? '',
                'ticket_type' => $item['ticket_type'] ?? '',
                'ticket_number' => $item['ticket_number'] ?? '',
                'user' => $item['user']?->name ?? '',
                'commerce_number' => $item['commerce_number'] ?? '',
                'warehouse' => $item['warehouse']?->name ?? '',
                'operation_type' => (function() use ($item){
                    if ($item['income'] !== null){
                        return 'Entrada';
                    }elseif ($item['outcome'] !== null){
                        return 'Salida';
                    }else{
                        return '';
                    }
                })(),
                'operation_id' => (function() use ($item){
                    if ($item['income'] !== null){
                        return 'ENT-#00' . $item['income']->id;
                    }elseif ($item['outcome'] !== null){
                        return 'SAL-#00' . $item['outcome']->id;
                    }else{
                        return '';
                    }
                })(),
                'income' => $item['income']?->id ?? '',
                'outcome' => $item['outcome']?->id ?? '',
                'in_quantity' => ($item['in_quantity'] !== null) ? $item['in_quantity'] : '',
                'in_amount' => ($item['in_amount'] !== null) ? Toolbox::moneyPrefix($item['currency']->value) . ' ' . number_format($item['in_amount'], 2) : '',
                'in_total' => ($item['in_total'] !== null) ? Toolbox::moneyPrefix($item['currency']->value) . ' ' . number_format($item['in_total'], 2) : '',
                'out_quantity' => ($item['out_quantity'] !== null) ? $item['out_quantity'] : '',
                'out_amount' => ($item['out_amount'] !== null) ? Toolbox::moneyPrefix($item['currency']->value) . ' ' . number_format($item['out_amount'], 2) : '',
                'out_total' => ($item['out_total'] !== null) ? Toolbox::moneyPrefix($item['currency']->value) . ' ' . number_format($item['out_total'], 2) : '',
                'balance_quantity' => $item['balance_quantity'] ?? '',
                'balance_amount' => ($item['balance_amount'] !== null) ? Toolbox::moneyPrefix($item['currency']->value) . ' ' . number_format($item['balance_amount'], 2) : '',
                'balance_total' => ($item['balance_total'] !== null) ? Toolbox::moneyPrefix($item['currency']->value) . ' ' . number_format($item['balance_total'], 2) : '',
            ];
        });

        $body = array_column($body->toArray(), null);

        return [
            'headers' => [
                [
                    'title' => 'N°',
                    'key' => 'order'
                ],
                [
                    'title' => 'Producto',
                    'key' => 'product'
                ],
                [
                    'title' => 'Categoría',
                    'key' => 'category'
                ],
                [
                    'title' => 'Operación',
                    'key' => 'operation_type'
                ],
                [
                    'title' => 'Fecha',
                    'key' => 'date'
                ],
                [
                    'title' => 'Moneda',
                    'key' => 'currency'
                ],
                [
                    'title' => 'Cód. Operación',
                    'key' => 'operation_id'
                ],
                [
                    'title' => 'Job',
                    'key' => 'job'
                ],
                [
                    'title' => 'Expense',
                    'key' => 'expense'
                ],
                [
                    'title' => 'Tipo de Ticket',
                    'key' => 'ticket_type'
                ],
                [
                    'title' => 'N° Ticket',
                    'key' => 'ticket_number'
                ],
                [
                    'title' => 'Usuario',
                    'key' => 'user'
                ],
                [
                    'title' => 'N° Comercio',
                    'key' => 'commerce_number'
                ],
                [
                    'title' => 'Almacén',
                    'key' => 'warehouse'
                ],
                [
                    'title' => 'Cantidad Ingreso',
                    'key' => 'in_quantity'
                ],
                [
                    'title' => 'Precio Ingreso',
                    'key' => 'in_amount'
                ],
                [
                    'title' => 'Total Ingreso',
                    'key' => 'in_total'
                ],
                [
                    'title' => 'Cantidad Salida',
                    'key' => 'out_quantity'
                ],
                [
                    'title' => 'Precio Salida',
                    'key' => 'out_amount'
                ],
                [
                    'title' => 'Total Salida',
                    'key' => 'out_total'
                ],
                [
                    'title' => 'Cantidad Saldo',
                    'key' => 'balance_quantity'
                ],
                [
                    'title' => 'Precio Saldo',
                    'key' => 'balance_amount'
                ],
                [
                    'title' => 'Total Saldo',
                    'key' => 'balance_total'
                ]
            ],
            'body' => $body,
        ];
    }


    public function generate():array{
        return [
            'data' => $this->createTable(),
            'query' => [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'moneyType' => $this->moneyType,
                'warehouseId' => $this->warehouseId,
                'expenseCode' => $this->expenseCode,
                'jobCode' => $this->jobCode,
                'productId' => $this->productId
            ],
        ];
    }
}
