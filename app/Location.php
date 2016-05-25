<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Location model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Location extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'location';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Gets the department associated with the location. Belongs to relationship
    * @return EloquentCollection
    */
  public function Departments() {
    return $this->belongsTo(Department::class);
  }

  /**
    * Returns the screens assigned to this location
    * @returns EloquentCollection
    */
  public function Screens() {
    return $this->hasMany(Screen::class);
  }
}
