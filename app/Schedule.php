<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Schedule model object
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class Schedule extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'display_schedule';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;
}
