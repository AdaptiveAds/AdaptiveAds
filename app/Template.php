<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the Template model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class Template extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
    protected $table = 'template';

    /**
      * Flag to determine if timestamps should be used
      * @var boolean
      */
    public $timestamps = false;

    public function Pages() {
      return $this->hasMany(Page::class);
    }
}
