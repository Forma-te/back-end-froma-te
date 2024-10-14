<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'user_id', 'name', 'url','description', 'image', 'file', 'code', 'total_hours', 'published', 'free',
        'price', 'acceptsMcxPayment', 'acceptsRefPayment', 'affiliationPercentage', 'discount', 'allow_download', 'product_type'
    ];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function modules()
    {
        //Metodo para retornar os modulos do curso relação de um para muitos
        return $this->hasMany(Module::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersCourse()
    {
        return $this->belongsToMany(User::class, 'sales', 'product_id', 'user_id')
                    ->select('sales.course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'sales', 'product_id', 'user_id')
                    ->where('sales.status', 'A');
    }

    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'sales', 'product_id', 'user_id')
                    ->where('sales.status', 'expired');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function getImageAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    protected function getFileAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    protected function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

}
