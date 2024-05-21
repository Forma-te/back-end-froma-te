<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'url',
        'image',
        'bibliography',
        'phone_number',
        'addresses',
        'type',
    ];

    public function rules($id = '')
    {
        return [
            'name' => 'required',
            'email' => "required|unique:users,email,{$id},id",
            'bibliography' => 'nullable',
            'phone_number' => 'nullable',
            'image' => 'nullable',
            'addresses' => 'nullable',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
        'profile_photo_url',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : null,
        );
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('id', auth()->user()->id);
    }

    public function CoursesTutor()
    {
        return $this->hasMany(Course::class);
    }

    public function student()
    {
        return $this->belongsToMany(User::class, 'sales', 'instrutor_id')
                ->where('sales.status', 'approved');
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function checkAccess($idCourse)
    {
        if (! auth()->check()) {
            return false;
        }

        $permission = $this->join('sales', 'sales.user_id', '=', 'users.id')
            ->where('sales.user_id', auth()->user()->id)
            ->where('sales.course_id', $idCourse)
            ->where('sales.status', 'approved')
            ->count();
        if ($permission > 0) {
            return true;
        }

        return false;
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function hasPermission(Permission $Permission)
    {
        return $this->hasProfile($Permission->profiles);
    }

    public function hasProfile($profile)
    {
        if (is_string($profile)) {
            return $this->profiles->contains('name', $profile);
        }

        return (bool) $profile->intersect($this->profiles)->count();
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }
}
