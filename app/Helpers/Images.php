<?php

namespace App\Helpers;

class Images extends Helper {

  /**
    * Takes an image upload, gives it a timestamp and moves it to advert_images in the public folder
    * @param \Illuminate\Http\Request\Input $input
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
