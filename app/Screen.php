<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Screen model object
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class Screen extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'screen';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Gets the location associated with the screen. has one relationship
    * @return EloquentCollection
    */
  public function Location() {
    return $this->belongsTo(Location::class, 'location_id');
  }

  /**
    * Gets the playlist associated with the screen. has one relationship
    * @return EloquentCollection
    */
  public function Playlist() {
    return $this->belongsTo(Playlist::class, 'playlist_id');
  }
}
