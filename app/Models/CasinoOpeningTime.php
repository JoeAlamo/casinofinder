<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 15/05/2016
 * Time: 19:43
 */

namespace CasinoFinder\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CasinoOpeningTime extends Model
{

    protected $fillable = [
        'day', 'open_time', 'close_time'
    ];

    public function casino() {
        return $this->belongsTo(Casino::class);
    }

    public function getOpenTimeAttribute($value) {
        return Carbon::createFromFormat('H:i:s', $value);
    }

    public function getCloseTimeAttribute($value) {
        return Carbon::createFromFormat('H:i:s', $value);
    }

    public function getDayStringAttribute() {
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return $daysOfWeek[$this->attributes['day']];
    }

} 