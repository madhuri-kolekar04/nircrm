<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\user as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Sale extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'desgnation',
        'profile_photo_path',
        'contact_number',
        'email',
        'email_varified_at',
        'password',
        'role',
        'department',
        'group',
        'assign',
        'employeeID',
        'location',
        'remember_token',
     
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departmentgetname(){
    	return $this->belongsTo(Department::class,'department','id');
    }


    public function Groupname(){
    	return $this->belongsTo(Group::class,'group','id');
    }
}
