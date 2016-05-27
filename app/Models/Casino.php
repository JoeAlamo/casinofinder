<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 15/05/2016
 * Time: 19:40
 */

namespace CasinoFinder\Models;


use Illuminate\Database\Eloquent\Model;

class Casino extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function casinoLocation() {
        return $this->hasOne(CasinoLocation::class);
    }

    public function casinoOpeningTimes() {
        return $this->hasMany(CasinoOpeningTime::class);
    }
} 