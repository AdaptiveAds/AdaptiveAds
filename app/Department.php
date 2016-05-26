<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Department model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Department extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'department';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Flag to determine if a user is an admin for this department
    * @var boolean
    */
  protected $admin = false;

  /**
    * Sets $admin property
    * @param boolean $value true if user is department admin
    */
  public function setAdmin($value) {
    $this->admin = $value;
  }

  /**
    * Gets $admin property
    * @return boolean
    */
  public function getAdmin() {
    return $this->admin;
  }

  /**
    * Get all playlists associated with the deaprtment. Has many relationship
    * @return EloquentCollection
    */
  public function Playlists() {
    return $this->hasMany(Playlist::class, 'department_id', 'id');
  }

  /**
    * Get all playlists associated with the department. Has many relationship
    * @return EloquentCollection
    */
  public function Location() {
    return $this->hasMany(Location::class, 'department_id', 'id');
  }

  /**
    * Gets the background assigned to the department. Has one relationship
    * @return EloquentCollection
    */
  public function Background() {
    return $this->hasOne(Background::class, 'id', 'background_id');
  }

  /**
    * Gets all the users associated with the department. Belongs to many relationship uses pivot table
    * @return EloquentCollection
    */
  public function Users() {
    return $this->belongsToMany(User::class)->withPivot('user_id', 'department_id', 'is_admin');
  }

  /**
    * Gets all the adverts associated with the department. Has many relationship
    * @return EloquentCollection
    */
  public function Adverts() {
    //return $this->belongsToMany(Advert::class)->withPivot('department_id', 'advert_id');
    return $this->hasMany(Playlist::class, 'department_id', 'id');
  }

  /**
    * Gets all screens associated with the department. Has many through relationship
    * @return EloquentCollection
    */
  public function Screens() {
    return $this->hasManyThrough(Screen::class, Location::class);
  }

  /**
    * Overrides default newPivot method to provide extra logic....
    * REVIEW???
    * @param Model $parent Parent object of pivot table
    * @param array $attributes Custom defined columns for pivot table
    * @param string $table Table name to give to the pivot
    * @param boolean $exists
    */
  public function newPivot(Model $parent, array $attributes, $table, $exists) {
      if ($parent instanceof User) {
          return new DepartmentUser($parent, $attributes, $table, $exists);
      }
      return parent::newPivot($parent, $attributes, $table, $exists);
  }
}
