<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 01/06/2016
 * Time: 16:15
 */

namespace CasinoFinder\Validation;


class CasinoFormValidator extends AbstractValidator
{
    /**
     * @var array Laravel rules for form fields
     */
    public $rules = [
        'name' => ['required', 'min:2', 'max:255'],
        'description' => ['max:255'],
        'address' => ['required', 'max:255'],
        'city' => ['required', 'max:255'],
        'postal_code' => ['required', 'max:255'],
        'google_maps_place_id' => ['required'],
        'latitude' => ['required', 'numeric'],
        'longitude' => ['required', 'numeric'],
        'opening_time.*.day' => ['required', 'in:0,1,2,3,4,5,6'],
        'opening_time.*.open_time' => ['required', 'date_format:H:i:s'],
        'opening_time.*.close_time' => ['required', 'date_format:H:i:s', 'after:opening_time.*.open_time']
    ];
}