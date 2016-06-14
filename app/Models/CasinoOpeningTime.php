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

    protected $appends = [
        'day_string',
    ];

    public function casino() {
        return $this->belongsTo(Casino::class);
    }

    public function getDayStringAttribute() {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return $daysOfWeek[$this->attributes['day']];
    }

} 