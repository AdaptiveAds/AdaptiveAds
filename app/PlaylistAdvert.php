<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the PlaylistAdvert model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class PlaylistAdvert extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'advert_playlist';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Gets the advert associated with the playlistAdvert collection. Belongs to relationship
    * @return EloquentCollection
    */
  public function Advert() {
    return $this->belongsTo(Advert::class, 'advert_id');
  }
}
