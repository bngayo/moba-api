<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\Glide\Server;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes, Authenticatable, Authorizable, HasFactory, HasApiTokens;

    protected $casts = [
        'member' => 'boolean',
        'prefect' => 'boolean'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->subscriptions()->active()->first()->get();
    }

    public function setPasswordAttribute($password)
    {
        if (!$password) {
            return;
        }

        $this->attributes['password'] = Hash::make($password);
    }

    public function setPrefectAttribute($prefect)
    {
        if (!$prefect) {
            return;
        }

        $this->attributes['prefect'] = ($prefect === 'true' ? 1 : 0) ;
    }

    public function setPhotoAttribute($photo)
    {
        if (!$photo) {
            return;
        }

        $this->attributes['photo_path'] = $photo instanceof UploadedFile ? $photo->store('users') : $photo;
    }

    public function getPhotoAttribute()
    {
        return $this->photoUrl(['w' => 40, 'h' => 40, 'fit' => 'crop']);
    }

    public function photoUrl(array $attributes)
    {
        if ($this->photo_path) {
            return URL::to(App::make(Server::class)->fromPath($this->photo_path, $attributes));
        }
    }

    public function isSystemAdmin()
    {
        return $this->email === 'admin@moba.or.ke';
    }

    public function isMember()
    {
        return $this->member === true;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name')->orderBy('created_at');
    }

    public function scopeWhereRole($query, $role)
    {
        switch ($role) {
            case 'user': return $query->where('member', false);
            case 'member': return $query->where('member', true);
        }
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereRole($role);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
