<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Page model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Page extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'page';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   * @var array
   */
  protected $fillable = ['page_data_id', 'page_index', 'advert_id', 'verticle_id', 'horizontal_id'];

  /**
    * Gets the pageData associated with the page. has one relationship
    * @return EloquentCollection
    */
  public function PageData() {
    return $this->hasOne(PageData::class, 'id', 'page_data_id');
  }

  /**
    * Gets the template associated with the page. Has one relationship
    * @return EloquentCollection
    */
  public function Template() {
    return $this->hasOne(Template::class, 'id', 'template_id');
  }
}
