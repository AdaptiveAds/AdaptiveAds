<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the PageData model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class PageData extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
    protected $table = 'page_data';

    /**
      * Flag to determine if timestamps should be used
      * @var boolean
      */
    public $timestamps = false;

    /**
      * Gets the page associated with the pageData. Belongs to relationship
      * @return EloquentCollection
      */
    public function Page() {
      return $this->belongsTo(Page::class);
    }
}
