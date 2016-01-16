<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template';
    public $timestamps = false;

    public function Transition()
    {
        return $this->belongsTo(Transition::class, 'transition_id', 'id');
    }

    public function Duration()
    {
        return $this->belongsTo(Duration::class, 'duration_id', 'id');
    }
}
