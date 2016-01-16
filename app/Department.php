<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  protected $table = 'department';
  public $timestamps = false;

  public function Playlists() {
    return $this->belongsToMany(Playlist::class)->withPivot('playlist_id', 'department_id');
  }

  public function Location() {
    return $this->belongsTo(Location::class, 'location_id');
  }

  public function Screen() {
    return $this->hasMany(Screen::class);
  }

  public function Skin() {
    return $this->hasOne(Skin::class, 'id', 'skin_id');
  }

  public function Users() {
    return $this->belongsToMany(User::class)->withPivot('user_id', 'department_id', 'privilage_id');
  }

  public function Adverts() {
    return $this->belongsToMany(Advert::class)->withPivot('department_id', 'advert_id');
  }

  public function newPivot(Model $parent, array $attributes, $table, $exists) {
      if ($parent instanceof User) {
          return new DepartmentUser($parent, $attributes, $table, $exists);
      }
      return parent::newPivot($parent, $attributes, $table, $exists);
  }
}
