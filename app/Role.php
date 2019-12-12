<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'uuid',
    ];

    /**
     * Method that automatically updates the uuid field on model created event
     *
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
