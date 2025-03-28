<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'zone',
        'state',
        'country',
        'location',
    ];

    protected $casts = [
    ];



    public static function sanitizeCode(string|null $code): string|null
    {
        if (is_null($code)) {
            return null;
        }

        //First remove anyng inside [], including []:
        $code = preg_replace('/\[[^\]]*\]/', '', $code);

        if (str_contains($code, '-')) {
            $code = explode('-', $code)[0];
            $code = trim($code);
        }
        return strtoupper($code);
    }
}
