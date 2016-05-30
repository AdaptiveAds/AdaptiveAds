<?php

namespace App\Helpers;

use Validator;

/**
  * Main helper class that holds repeated code can be extended from
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class Helper {

  /**
    * Outputs error messages from a message bag into a string
    * @param  $validator  Illuminate\Support\MessageBag
    * @return string message with error
    */
  public static function getValidationErrors($validator) {

    if ($validator->errors()->count() > 0) {
      foreach ($validator->errors()->all() as $valMessage) {
        $message = $valMessage;
      }
    }

    return $message;
  }

  /**
    * Validates input before processing user requests
    * @param  Array   $data array of fields to validate
    * @param  Array   $rules array of rules to apply
    * @return \Illuminate\Http\Response response if validation fails
    */
  public static function validator(Array $data, Array $rules, $redirectRoute) {

    // Validate
    $validator = Validator::make($data, $rules);

    // If validator fails get the errors and warn the user
    // this redirects to prevent further execution
    if ($validator->fails()) {
      $message = Helper::getValidationErrors($validator);

      return redirect()->route($redirectRoute)
      ->with('message', $message);
    }

  }
}
