<?php

namespace App\Models;

use App\Helpers\Enums\MoneyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryProduct;
use App\Models\InventoryWarehouse;
use App\Helpers\Enums\InventoryProductItemStatus;

class InventoryProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'batch',
        'amount',
        'currency',
        'status',
        'buy_amount',
        'sell_amount',
        'buy_currency',
        'sell_currency',
        'inventory_product_id',
        'inventory_warehouse_id',
        'inventory_warehouse_income_id',
        'inventory_warehouse_outcome_id'
    ];

    protected $casts = [
        'currency' => MoneyType::class,
        'status' => InventoryProductItemStatus::class
    ];

    public function product()
    {
        return $this->belongsTo(InventoryProduct::class, 'inventory_product_id', 'id');
    }

    public function unit()
    {
        return $this->product->unit;
    }

    public function warehouse()
    {
        return $this->belongsTo(InventoryWarehouse::class, 'inventory_warehouse_id', 'id');
    }

    public function income()
    {
        return $this->belongsTo(InventoryWarehouse::class, 'inventory_warehouse_income_id');
    }

    public function outcome()
    {
        return $this->belongsTo(InventoryWarehouse::class, 'inventory_warehouse_outcome_id');
    }
}
