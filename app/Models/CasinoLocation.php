<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 15/05/2016
 * Time: 19:41
 */

namespace CasinoFinder\Models;


use Illuminate\Database\Eloquent\Model;

class CasinoLocation extends Model
{
    protected $fillable = [
        'address', 'city', 'postal_code', 'latitude', 'longitude'
    ];

    public function casino() {
        return $this->belongsTo(Casino::class);
    }
} 