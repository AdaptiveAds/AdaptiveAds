<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorizontalTemplate extends Model
{
    protected $table = 'horizontal_template';
    public $timestamps = false;

    public function Template()
    {
        return $this->hasOne(Template::class, 'id', 'template_id');
    }
}
