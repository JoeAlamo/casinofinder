<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 01/06/2016
 * Time: 16:05
 */

namespace CasinoFinder\Validation;


use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;


/**
 * @desc Base validator - extend per each validation need.
 * @see https://www.sitepoint.com/data-validation-laravel-right-way/
 */
abstract class AbstractValidator
{

    /**
     * @var \Illuminate\Validation\Factory
     */
    protected $_validatorFactory;

    public function __construct(Factory $validator) {
        $this->_validatorFactory = $validator;
    }

    /**
     * @param array $data
     * @param array $rules
     * @param array $custom_errors
     * @return bool
     * @throws ValidationException
     */
    public function validate(array $data, array $rules = array(), array $custom_errors = array()) {
        if (empty($rules) && !empty($this->rules) && is_array($this->rules)) {
            //no rules passed to function, use the default rules defined in sub-class
            $rules = $this->rules;
        }

        //use Laravel's Validator and validate the data
        $validation = $this->_validatorFactory->make($data, $rules, $custom_errors);

        if ($validation->fails()) {
            //validation failed, throw an exception
            throw new ValidationException($validation);
        }

        //all good and shiny
        return true;
    }

}