<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 28/05/2016
 * Time: 17:44
 */

namespace CasinoFinder\Providers;

/**
 * Class HtmlServiceProvider
 * @package CasinoFinder\Providers
 * @desc This service provider allows us to extend the base HtmlServiceProvider.
 * Particularly, we can add things such as Form Macros and such, all in one place.
 */
class HtmlServiceProvider extends \Collective\Html\HtmlServiceProvider
{
    public function register() {
        parent::register();

        \Form::macro('selectTime', function ($name = 'time', $value = null, $attributes = []) {
            // We want a select box with 00:00 to 23:59, with intervals of 30 minutes

            $startTimeString = '00:00:00';
            $time = new \DateTime($startTimeString);
            $timeInterval = new \DateInterval("PT30M");
            // KEY = H:i:s, VAL = H:i
            $optionList = [];
            $tempTime = $time->format('H:i:s');

            // Build option list from 00:00:00 until 23:45:00
            do {
                $optionList[$tempTime] = $time->format('H:i a');
                $time->add($timeInterval);
                $tempTime = $time->format('H:i:s');
            } while ($tempTime !== $startTimeString);
            // Add 23:59:59
            $optionList['23:59:59'] = '23:59 pm';

            return \Form::select($name, $optionList, $value, $attributes);
        });
    }
}