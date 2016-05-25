<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
  * Defines the AdvertSchedule model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class AdvertSchedule extends Model
{
  /**
   * The database table used by the model.
   * @var string
   */
  protected $table = 'advert_schedule';

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Returns the advert schedule
    * @returns EloquentCollection
    */
  public function Schedule() {
    return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
  }
}
