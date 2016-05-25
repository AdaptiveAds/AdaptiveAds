<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
  * Defines the DepartmentUser model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class DepartmentUser extends Pivot
{
  /**
    * Get the user associated to the parent. Belongs to replationship
    * @return EloquentCollection
    */
  public function User() {
    return $this->belongsTo(User::class);
  }

  /**
    * Get the Privilege associated to the parent. Belongs to replationship
    * @return EloquentCollection
    */
  public function Privilage() {
    return $this->belongsTo(Privilage::class);
  }

  /**
    * Get the department associated to the parent. Belongs to replationship
    * @return EloquentCollection
    */
  public function Department() {
    return $this->belongsTo(Department::class);
  }
}
