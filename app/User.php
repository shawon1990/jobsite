<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'email', 'password','user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function userDetailsByUserId(){
       return $this->hasOne('App\Model\UserDetailsModel','user_id','id');
    }

    public function userImageByUserId(){
        return $this->hasOne('App\Model\UserImageModel','user_id','id');
    }
    public function employeeResume(){
        return $this->hasOne('App\Model\EmployeeResumeModel','user_id','id');
    }
}
