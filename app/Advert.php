<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Advert model object
  * @author Josh Preece
  * @license REVIEW
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
    return $this->belongsToOne(Department::class)->withPivot('advert_id', 'department_id');
  }

}
