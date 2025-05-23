<?php

namespace App\Support\Exchange\Currencies;

use DateTime;
use Illuminate\Support\Facades\Log;


class PYG{
    public static function convertFromDollar(DateTime $date, float $amount){
        //Check if float is zero:
        if($amount == 0){
            return 0;
        }

        try {
            \Brunoinds\ParaguayDolarLaravel\Exchange::useStore(\App\Support\Exchange\Adapters\PYGAdapter::getStore());
            return \Brunoinds\ParaguayDolarLaravel\Exchange::on($date)->convert(\Brunoinds\ParaguayDolarLaravel\Enums\Currency::USD, $amount)->to(\Brunoinds\ParaguayDolarLaravel\Enums\Currency::PYG);
        } catch (\Throwable $th) {
            Log::warning('Failed to convert USD to PYG', ['date' => $date, 'amount' => $amount, 'error' => $th->getMessage()]);
            return 0;
        }
    }
    public static function convertToDollar(DateTime $date, float $amount){
        //Check if float is zero:
        if($amount == 0){
            return 0;
        }

        try {
            \Brunoinds\ParaguayDolarLaravel\Exchange::useStore(\App\Support\Exchange\Adapters\PYGAdapter::getStore());
            return \Brunoinds\ParaguayDolarLaravel\Exchange::on($date)->convert(\Brunoinds\ParaguayDolarLaravel\Enums\Currency::PYG, $amount)->to(\Brunoinds\ParaguayDolarLaravel\Enums\Currency::USD);
        } catch (\Throwable $th) {
            Log::warning('Failed to convert PYG to USD', ['date' => $date, 'amount' => $amount, 'error' => $th->getMessage()]);
            return 0;
        }
    }
}
