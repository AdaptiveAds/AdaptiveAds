<?php

namespace App\Helpers;

use Validator;

/**
  * Main helper class that holds repeated code can be extended from
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Helper {

  public static function getValidationErrors($validator) {

    if ($validator->errors()->count() > 0) {
      foreach ($validator->errors()->all() as $valMessage) {
        $message = $valMessage;
      }
    }

    return $message;
  }
}
