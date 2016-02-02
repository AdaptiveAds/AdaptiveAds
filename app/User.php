<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{

  use Authenticatable, Authorizable, CanResetPassword;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'user';
  public $timestamps = false;

  // If true this user is an admin in at least one deapartment
  protected $admin = false;

  public function setAdmin($value) {
    $this->admin = $value;
  }

  public function getAdmin() {
    return $this->admin;
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['username', 'password'];

  /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
  protected $hidden = ['password', 'remember_token'];

  public function Departments() {
    return $this->belongsToMany(Department::class)->withPivot('privilage_id');
  }

  // Checks to see if the user is an admin in a department
  public function isAdmin($departmendID) {
    $privilage = $this->belongsToMany(Department::class)->withPivot('privilage_id')
                      ->where('id', $departmendID)
                      ->first()
                      ->pivot
                      ->privilage;

    if ($privilage->level == 0) {
      return true;
    }

    return false;
  }

  public function newPivot(Model $parent, array $attributes, $table, $exists) {
      if ($parent instanceof Department) {
          return new DepartmentUser($parent, $attributes, $table, $exists);
      }
      return parent::newPivot($parent, $attributes, $table, $exists);
  }
}
