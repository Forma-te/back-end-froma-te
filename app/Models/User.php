<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User.
 *
 * @author  Moises Bumba <moises@gmail.com>
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 * )
 */

class User extends Authenticatable
{
    /**
     * @OA\Property(
     *     format="int32",
     *     title="User status",
     * )
     *
     * @var int
     */

    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * @OA\Property(
     *     title="name",
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     format="email",
     *     title="Email",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     format="int64",
     *     title="Password",
     *     maximum=255
     * )
     *
     * @var string
     */
    private $password;

    /**
     * @OA\Property(
     *     format="msisdn",
     *     title="Phone",
     * )
     *
     * @var string
     */
    private $phone;

    /**
     * @OA\Property(
     *     format="int64",
     *     title="url",
     *     maximum=255
     * )
     *
     * @var string
     */
    private $url;

    /**
     * @OA\Property(
     *     format="int64",
     *     title="image",
     *     maximum=255
     * )
     *
     * @var string
     */
    private $image;


    /**
     * @OA\Property(
     *     format="int64",
     *     title="Bibliografia",
     *     maximum=255
     * )
     *
     * @var string
     */
    private $bibliography;


    /**
     * @OA\Property(
     *     format="int64",
     *     title="addresses",
     *     maximum=255
     * )
     *
     * @var string
     */
    private $addresses;

    /**
         * @OA\Property(
         *     format="int64",
         *     description="type",
         *     title="type",
         *     maximum=255
         * )
         *
         * @var string
         */
    private $type;

    protected $fillable = [
        'name',
        'email',
        'password',
        'url',
        'image',
        'bibliography',
        'phone',
        'bi'
    ];

    public function rules($id = '')
    {
        return [
            'name' => 'required',
            'email' => "required|unique:users,email,{$id},id",
            'bibliography' => 'nullable',
            'phone' => 'nullable',
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

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : null,
        );
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'sales');
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('id', auth()->user()->id);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->withPivot('plan_id')->withTimestamps();
    }

    public function hasProfile($profile)
    {
        if (is_string($profile)) {
            return $this->profiles->contains('name', $profile);
        }

        return (bool) $profile->intersect($this->profiles)->count();
    }

}
