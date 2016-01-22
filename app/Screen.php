<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
  protected $table = 'screen';
  public $timestamps = false;

  public function Department() {
    return $this->belongsTo(Department::class, 'department_id');
  }
}
