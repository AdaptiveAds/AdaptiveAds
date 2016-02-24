<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Skin model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Skin extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'skin';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  public function Departments() {
    return $this->belongsTo(Department::class);
  }
}
