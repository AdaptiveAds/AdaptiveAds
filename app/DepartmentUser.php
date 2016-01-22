<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DepartmentUser extends Pivot
{

  // Source https://laracasts.com/discuss/channels/eloquent/eloquent-model-many-to-manypivot-with-additional-attributes-as-foreign-key

  public function User() {
    return $this->belongsTo(User::class);
  }

  public function Privilage() {
    return $this->belongsTo(Privilage::class);
  }

  public function Department() {
    return $this->belongsTo(Department::class);
  }
}
