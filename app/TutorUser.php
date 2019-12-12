<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class TutorUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'tutor_id', 'user_id', 'added_by'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id', 'id');
    }

    /**
     * @param User $tutor
     * @param User $tutee
     * @param $addedBy
     * @return mixed
     */
    public static function assignTutee(User $tutor, User $tutee, $addedBy)
    {
        return self::create([
            'tutor_id' => $tutor->id,
            'user_id' => $tutee->id,
            'added_by' => $addedBy,
        ]);

    }
}
