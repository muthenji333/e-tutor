<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*
    * Checks if this user has the supplied role.
    * Returns true when user has the role else false.
    */
    public function hasRole($role)
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->name == $role;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tutees()
    {
        return $this->hasMany(TutorUser::class, 'tutor_id', 'id')->with('user');
    }

    public function tutors()
    {
        return $this->hasMany(TutorUser::class, 'user_id', 'id')->with('tutor');
    }

    public function createTutor(User $user, $addedBy)
    {
        return $this->tutors()->create(['tutor_id' => $user->id, 'added_by' => $addedBy]);
    }

    /**
     * @return mixed
     */
    public function messages()
    {
        return Chat::with(['fromUser', 'toUser'])
            ->where('to', $this->id)
            ->orWhere('from', $this->id)
            ->latest()
            ->get();
    }

    /**
     * @param User $to
     * @param null $attachment
     * @return
     */
    public function sendMessage(User $to, $message, $attachment = null)
    {
        return Chat::create([
            'from' => $this->id,
            'to' => $to->id,
            'attachment' => $attachment,
            'message' => $message
        ]);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function createLog($task)
    {
        return $this->logs()->create([
            'task' => $task
        ]);
    }

    public static function averageMessagesPerTutor()
    {
        $tutors = User::where('role_id', 3)->get();

        $stats = array();

        foreach ($tutors as $tutor) {
            $messages = $tutor->messages()->count();
            $tutees = $tutor->tutees()->count();
            $avg = $tutees ? $messages / $tutees : 0;

            array_push($stats, [
                'name' => $tutor->name,
                'messages' => $messages,
                'tutees' => $tutees,
                'avg' => $avg
            ]);
        }

        return $stats;
    }

    public static function studentsWithNoPersonalTutor()
    {
        return User::where('role_id', 4)->withCount('tutors')->get()->where('tutors_count', 0)->count();
    }

    public static function studentsWithNoInteractionInNDays($noOfDays = 1)
    {
        $end_date = today()->endOfDay();
        $start_date = today()->subDays($noOfDays)->startOfDay();

        $tutees = User::where('role_id', 4)->get();

        $count = 0;

        foreach ($tutees as $tutee) {
            $messages = $tutee->messages()->whereBetween(
                'created_at', [
                $start_date,
                $end_date
            ])->count();

            if ($messages == 0) {
                $count ++;
            }
        }
        return $count;
    }
}
