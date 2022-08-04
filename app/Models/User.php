<?php

namespace App\Models;

use App\Models\Example\Image;
use App\Models\Example\Person;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable, HasRoles;

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

    /**
     * this data can't be accessed directly.
     * 
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];

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


    public function addPermission($permissionName)
    {
        return $this->givePermissionTo($permissionName);
    }

    public function addAllPermission()
    {
        return $this->givePermissionTo(Permission::all());
    }

    public function hasPermission($permissionName)
    {
        return $this->hasPermissionTo($permissionName);
    }
    public function proofUserCan($permissionName){

        return $this->hasPermissionTo($permissionName);
    }

    public function removePermission($permissionName)
    {
        return $this->revokePermissionTo($permissionName);
    }

    // Bereits integriert
    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class);
    // }

    /**
     * Relationship: get person associated with user
     */
    public function person()
    {
        return $this->hasOne(Person::class);
    }

    /** Relationship: get Images through person */
    public function image()
    {
        return $this->hasManyThrough(Image::class, Person::class);
    }
}
