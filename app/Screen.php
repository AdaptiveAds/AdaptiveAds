<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
  protected $table = 'screen';
  public $timestamps = false;

  public function Location() {
    return $this->belongsTo(Location::class, 'location_id');
  }
}
