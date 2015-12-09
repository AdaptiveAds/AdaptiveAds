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

  public function pageData() {
    return $this->hasOne('App\PageData');
  }
}
