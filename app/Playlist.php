<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Playlist model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Playlist extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'playlist';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Get all the adverts associated with the playlist. Belongs to many relationship.
    * Pivot table and ordered by advert index
    * @return EloquentCollection
    */
  public function Adverts() {
    return $this->belongsToMany(Advert::class)->withPivot('playlist_id', 'advert_id', 'advert_index')
                ->orderBy('advert_index', 'ASC');
  }

  /**
    * Returns all screens that have this playlist assigned
    * @returns EloquentCollection
    */
  public function Screens() {
    return $this->hasMany(Screen::class);
  }

}
