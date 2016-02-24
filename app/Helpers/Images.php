<?php

namespace App\Helpers;

/**
  * Holds generic functions related to images
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Images extends Helper {

  /**
    * Takes an image upload, gives it a timestamp and moves it to an output path in the public folder
    * @param \Illuminate\Http\Request\Input $input File to process
    * @param string $outputPath Path to move file to in the public folder
    * @return string | null
    */
  public static function processImage($input, $outputPath) {

    if ($input->isValid()) {
      $filename  = time() . '.' . $input->getClientOriginalExtension();

      $path = public_path($outputPath);

      $input->move($path, $filename); // uploading file to given path

      return $filename;
    }

    return null;
  }

}
