<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from', 'to', 'attachment', 'uuid', 'message',
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

    public function getAttachmentAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public static function lastNDaysMessage($noOfDays = 0)
    {
        $end_date = today()->endOfDay();
        $start_date = today()->subDays($noOfDays)->startOfDay();

        return self::whereBetween(
            'created_at', [
            $start_date,
            $end_date
        ])->count();
    }
}
