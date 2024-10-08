<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * @OA\Property(
     *     format="int32",
     *     title="User status",
     * )
     *
     * @var int
     */


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
        'phone_number',
        'bi'
    ];

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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
        return $this->hasMany(Sale::class, 'instrutor_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('id', Auth::user()->id);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function coursesProducer()
    {
        return $this->hasMany(Product::class);
    }

    public function student()
    {
        return $this->belongsToMany(User::class, 'sales', 'instrutor_id')
                ->where('sales.status', 'A');
    }

    public function checkAccess($idCourse)
    {
        if (! Auth::check()) {
            return false;
        }

        $permission = $this->join('sales', 'sales.user_id', '=', 'users.id')
            ->where('sales.user_id', Auth::user()->id)
            ->where('sales.product_id', $idCourse)
            ->where('sales.status', 'A')
            ->count();
        if ($permission > 0) {
            return true;
        }

        return false;
    }

    public function hasProfile($profile)
    {
        if (is_string($profile)) {
            return $this->profiles->contains('name', $profile);
        }

        return (bool) $profile->intersect($this->profiles)->count();
    }
}
