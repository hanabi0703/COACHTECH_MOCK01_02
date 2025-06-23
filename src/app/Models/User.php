<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'email',
        'password',
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Product::class,'likes')->withTimestamps();;
    }

    public function comments()
    {
        return $this->belongsToMany(Product::class,'comments')->withTimestamps();;
    }

    public function purchase()
    {
        return $this->belongsToMany(Product::class,'purchase')->withTimestamps();;
    }
}
