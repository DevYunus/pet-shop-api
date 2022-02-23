<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'is_admin',
        'email',
        'email_verified_at',
        'password',
        'avatar',
        'address',
        'phone_number',
        'is_marketing',
        'last_login_at',
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
        'id' => 'integer',
        'is_admin' => 'boolean',
        'email_verified_at' => 'timestamp',
        'is_marketing' => 'boolean',
        'last_login_at' => 'timestamp'
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function scopeWithSort($query, $sorting)
    {
        if(empty($sorting)){
            return $query;
        }

        [$sortBy, $direction] = $sorting;

        if($sortBy){
            return  $query->orderBy($sortBy, $direction?'desc':'asc');
        }
        return  $query;
    }

    public function scopeWithFirstName($query, $firstName)
    {
        if(!$firstName){
            return $query;
        }
        return  $query->where('first_name','like', "%$firstName%");

    }

    public function scopeWithEmail($query, $email)
    {
        if(!$email){
            return $query;
        }

        return  $query->where('email','like', "%$email%");
    }

    public function scopeWithPhone($query, $phone)
    {
        if(!$phone){
            return $query;
        }

        return  $query->where('phone_number','like', "%$phone%");
    }

    public function scopeWithAddress($query, $address)
    {
        if(!$address){
            return $query;
        }

        return  $query->where('address','like', "%$address%");
    }

    public function scopeWithIsMarketing($query, $isMarketing)
    {
        if(!$isMarketing){
            return $query;
        }

        return  $query->where('is_marketing', $isMarketing);
    }
}
