<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilage extends Model
{
  protected $table = 'privilage';
  public $timestamps = false;

  public function newPivot(Model $parent, array $attributes, $table, $exists) {
      if ($parent instanceof Department) {
          return new DepartmentUser($parent, $attributes, $table, $exists);
      }
      return parent::newPivot($parent, $attributes, $table, $exists);
  }
}
