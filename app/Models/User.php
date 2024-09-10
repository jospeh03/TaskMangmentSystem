<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
//using carbon for date formating
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //user_id is the primary key name 
    protected $primary_key="user_id";
    //he is auto_increment
    public $incrementing = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
    protected $guarded=[
        'id',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'=>'datetime',
        'updated_at'=>'datetime',

    ];
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['email_verified_at'] = Carbon::createFromFormat('d-m-Y H:i', $value)->toDateTimeString();
        $this->attributes['created_at'] = Carbon::createFromFormat('d-m-Y H:i', $value)->toDateTimeString();
        $this->attributes['updated_at'] = Carbon::createFromFormat('d-m-Y H:i', $value)->toDateTimeString();
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,  // Ensure role is included in the token
        ];
    }
    //definig the task relationshipw
    public function tasksAssigned()
    {
        return $this->hasMany(Task::class, 'assigned_by');
    }

    /**
     * Get the tasks assigned to this user.
     */
    public function tasksAssignedTo()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
