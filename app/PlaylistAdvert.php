<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaylistAdvert extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'advert_playlist';
  public $timestamps = false;

  public function Playlist() {

  }

  public function Advert() {
    return $this->belongsTo(Advert::class, 'advert_id');
  }
}
