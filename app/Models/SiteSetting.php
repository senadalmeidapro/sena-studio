<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['availability', 'booking_url'];

    public static function current(): self
    {
        return self::query()->firstOrCreate(['id' => 1], ['availability' => 'available']);
    }
}
