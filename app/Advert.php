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

  public function Pages() {
    //return $this->belongsTo(Page::class, 'advert_id');
    return $this->hasMany(Page::class, 'advert_id', 'id')->orderBy('page_index', 'ASC');
  }

  public function Department() {
    return $this->belongsToOne(Department::class)->withPivot('advert_id', 'department_id');
  }

}
