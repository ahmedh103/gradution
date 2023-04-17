<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Instructor extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'First_name',
        'Last_name',
        'email',
        'password',
        'pin_code'
    ];

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }

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
}
