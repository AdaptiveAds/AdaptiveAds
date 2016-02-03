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

  public function Playlist() {
    return $this->belongsTo(Playlist::class, 'playlist_id');
  }
}
