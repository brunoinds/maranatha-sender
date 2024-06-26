<?php

namespace App\Helpers\Enums;


enum InventoryProductItemStatus: string
{
    case InStock = 'InStock';
    case Sold = 'Sold';

    public static function toArray():array
    {
        $items = [];
        foreach (self::cases() as $case) {
            $items[] = $case->value;
        }

        return $items;
    }
}
