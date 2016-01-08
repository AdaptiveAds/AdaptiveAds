<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'advert';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'deleted'];

  public function Page() {
    //return $this->belongsTo(Page::class, 'advert_id');
    return $this->hasMany(Page::class, 'advert_id', 'id');
  }

}
