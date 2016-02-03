<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
  protected $table = 'location';
  public $timestamps = false;

  public function Departments() {
    return $this->belongsTo(Department::class);
  }
}
