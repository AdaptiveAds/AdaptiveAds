<?php

namespace App\Helpers;

/**
  * Holds generic functions related to media
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class Media extends Helper {

  /**
    * Takes an media upload, gives it a timestamp and moves it to an output path in the public folder
    * @param \Illuminate\Http\Request\Input $input File to process
    * @param string $outputPath Path to move file to in the public folder
    * @return string | null
    */
  public static function processMedia($input, $outputPath) {

    if ($input->isValid()) {
      $filename  = time() . '.' . $input->getClientOriginalExtension();

      $path = public_path($outputPath);

      $input->move($path, $filename); // uploading file to given path

      return $filename;
    }

    return null;
  }

}
