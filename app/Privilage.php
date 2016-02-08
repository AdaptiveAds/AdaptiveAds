<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Privilege model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Privilage extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'privilage';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Overrides default newPivot method to provide extra logic....
    * REVIEW???
    * @param Model $parent Parent object of pivot table
    * @param array $attributes Custom defined columns for pivot table
    * @param string $table Table name to give to the pivot
    * @param boolean $exists
    */
  public function newPivot(Model $parent, array $attributes, $table, $exists) {
      if ($parent instanceof Department) {
          return new DepartmentUser($parent, $attributes, $table, $exists);
      }
      return parent::newPivot($parent, $attributes, $table, $exists);
  }
}
