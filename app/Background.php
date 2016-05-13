<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Background model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Background extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'background';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  public function Adverts() {
    return $this->hasMany(Advert::class);
  }
}
