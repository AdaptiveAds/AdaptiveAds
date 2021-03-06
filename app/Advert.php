<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Advert model object
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class Advert extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'advert';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   * @var array
   */
  protected $fillable = ['name', 'deleted'];

  /**
    * Get all pages accociated with the advert (Ordered by page_index)
    * @return EloquentCollection
    */
  public function Pages() {
    return $this->hasMany(Page::class, 'advert_id', 'id')->orderBy('page_index', 'ASC');
  }

  /**
    * Get the department that owns the advert
    * @returns EloquentCollection
    */
  public function Department() {
    return $this->hasOne(Department::class, 'id', 'department_id');
  }

  /**
    * Gets the display schedule of the advert
    * @returns EloquentCollection
    */
  public function AdvertSchedule() {
    return $this->belongsTo(AdvertSchedule::class, 'id', 'advert_id');
  }

  /**
    * Gets the background assigned to the advert
    * @returns EloquentCollection
    */
  public function background() {
    return $this->hasOne(Background::class, 'id', 'background_id');
  }

  /**
    * Gets the playlists this advert is assigned to
    * @returns EloquentCollection
    */
  public function Playlists() {
    return $this->belongsToMany(Playlist::class)->withPivot('playlist_id', 'advert_id', 'advert_index');
  }

}
