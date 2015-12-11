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

  public function PageData() {
    return $this->hasOne(PageData::class, 'id');
  }
}
