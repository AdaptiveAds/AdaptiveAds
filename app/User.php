<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
  * Defines the User model object
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
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

  /**
    * Flag to determine if timestamps should be used
    * @var boolean
    */
  public $timestamps = false;

  /**
    * Flag to determine if a user is an admin for this department
    * @var boolean
    */
  protected $admin = false;

  /**
    * Sets $admin property
    * @param boolean $value true if user is department admin
    */
  public function setAdmin($value) {
    $this->admin = $value;
  }

  /**
    * Gets $admin property
    * @return boolean
    */
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

  /**
    * Get all departments associated with the user. Belongs to relationship
    * Pivot table
    * @return EloquentCollection
    */
  public function Departments() {
    return $this->belongsToMany(Department::class)->withPivot('is_admin');
  }

  /**
    * Checks if the user is an admin of a department
    * @param int $departmentID ID of the department to check
    * @return boolean True if user is admin of department
    */
  public function isAdmin($departmentID) {
    $department = $this->belongsToMany(Department::class)->withPivot('is_admin')
                      ->where('id', $departmentID)
                      ->first();

    if ($department != null) { // Have we found a department with this user?
      if ($department->pivot->is_admin)
        return true;
    }

    return false;
  }

  /**
    * Sets the user as an admin of a department
    * @param int $departmentID ID of the department to assign
    * @return boolean True if user is admin of department
    */
  public function makeAdmin($departmentID) {
    $department = $this->belongsToMany(Department::class)->withPivot('is_admin')
                      ->where('id', $departmentID)
                      ->first();

    if ($department != null) { // Have we found a department with this user?
      $department->pivot->is_admin = 1;
    }
  }

  /**
    * Overrides default newPivot method to provide extra logic....
    * REVIEW???
    * @param Model $parent Parent object of pivot table
    * @param array $attributes Custom defined columns for pivot table
    * @param string $table Table name to give to the pivot
    * @param boolean $exists
    */
  public function newPivot(Model $parent, array $attributes, $table, $exists) {
      if ($parent instanceof Department) {
          return new DepartmentUser($parent, $attributes, $table, $exists);
      }
      return parent::newPivot($parent, $attributes, $table, $exists);
  }
}
