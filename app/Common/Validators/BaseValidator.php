<?php

namespace App\Common\Validators;

use Illuminate\Support\Collection;
use Validator;

/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/18/2017
 * Time: 10:37 AM
 */
abstract class BaseValidator
{
    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * Validate data with defined ruleset
     *
     * @param $data
     * @param string $ruleset
     * @return mixed
     */
    public function validate($data, $ruleset = 'create')
    {
        // We allow collections, so transform to array.
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        // Load the correct ruleset.
        $rules = $this->rules[$ruleset];

        // Load the correct messageset.
        $messages = $this->messages ?: [];

        // Create the validator instance and validate.
        $validator = Validator::make($data, $rules, $messages);
        if (!$result = $validator->passes()) {
            $this->errors = $validator->messages();
        }

        // Return the validation result.
        return $result;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}