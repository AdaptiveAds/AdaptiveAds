<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageData extends Model
{
    protected $table = 'page_data';

    public function Page() {
      return $this->belongsTo(Page::class);
    }
}
