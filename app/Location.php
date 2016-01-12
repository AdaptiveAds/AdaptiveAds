<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
  protected $table = 'location';
  public $timestamps = false;

  public function Playlist() {
    return $this->belongsTo(Playlist::class, 'playlist_id');
  }
}
