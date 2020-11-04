<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['address', 'cep', 'reference'];

    public static function getId($address)
    {
        $id = Location::firstOrCreate(['address' => $address])->id;

        return $id;
    }
}
