<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'playlist';
  public $timestamps = false;

  public function Adverts() {
    return $this->belongsToMany(Advert::class)->withPivot('playlist_id', 'advert_id', 'advert_index', 'display_schedule_id')
                ->orderBy('advert_index', 'ASC');
  }

}
