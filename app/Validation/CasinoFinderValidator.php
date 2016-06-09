<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 09/06/2016
 * Time: 20:15
 */

namespace CasinoFinder\Validation;


class CasinoFinderValidator extends AbstractValidator
{
    /**
     * @var array Laravel rules for form fields
     */
    public $rules = [
        'latitude' => ['required', 'numeric'],
        'longitude' => ['required', 'numeric'],
    ];
}