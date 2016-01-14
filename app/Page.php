<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'page';
  public $timestamps = false;

  protected $fillable = ['page_data_id', 'page_index', 'advert_id', 'verticle_id', 'horizontal_id'];

  public function PageData() {
    return $this->hasOne(PageData::class, 'id', 'page_data_id');
  }

  public function HorizontalTemplate() {
    return $this->hasOne(HorizontalTemplate::class, 'id', 'horizontal_id');
  }

  public function Template() {
    return $this->hasOne(Template::class, 'id', 'template_id');
  }
}
