<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Log extends Model
{
    protected $fillable = [
        'user_id', 'task', 'uuid',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
