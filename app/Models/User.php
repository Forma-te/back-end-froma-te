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

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'url',
        'profile_photo_path',
        'bibliography',
        'phone_number',
        'bi',
        'titular',
        'account_number',
        'whatsapp',
        'iban',
        'foreign_iban',
        'wise',
        'paypal',
        'user_facebook',
        'user_whatsapp',
        'proof_path'
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

    // Relacionamento com os links de afiliação
    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    // Relacionamento com as afiliações
    public function affiliates()
    {
        return $this->hasMany(Affiliate::class);
    }

    public function trackingPixels()
    {
        return $this->hasMany(TrackingPixel::class, 'producer_id');
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    protected function getProfilePhotoPathAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    protected function getProofPathAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'instrutor_id');
    }

    public function product()
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
