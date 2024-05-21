<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'user_id', 'name', 'short_name', 'url', 'description', 'image', 'file', 'type', 'code', 'total_hours', 'published', 'free',
        'price', 'available',
    ];

    public function rules($id = '')
    {
        return [
            'category_id' => 'required',
            'name' => 'required|min:5|max:255',
            'description' => 'nullable',
            'short_name' => 'required|max:255',
            'image' => 'nullable|image|mimes:png,jpg|max:5120||dimensions:max_width=600,max_height=450',
            'file' => 'nullable|file|mimes:pdf',
            'type' => 'nullable',
            'code' => "nullable|unique:courses,code,{$id},id",
            'total_hours' => 'nullable',
            'price' => 'nullable',
        ];
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class); // Definindo o relacionamento "has many" com o modelo Sale
    }

    public function modules()
    {
        //Metodo para retornar os modulos dos cursos relação de um para muitos
        return $this->hasMany(Module::class);
    }

    public function requirements()
    {
        //Metodo para retornar os cursos relação de um para muitos
        return $this->hasMany(Requirement::class);
    }

    public function learns()
    {
        //Metodo para retornar os cursos relação de um para muitos
        return $this->hasMany(Learn::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersCourse()
    {
        return $this->belongsToMany(User::class)
            ->join('sales.course_id', '=', 'courses.id')
            ->select('sales.course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'sales', 'course_id', 'user_id')
            ->where('sales.status', 'approved');
    }

    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'sales', 'course_id', 'user_id')
            ->where('sales.status', 'expired');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function commentCourses()
    {
        return $this->hasMany(Comment_course::class)
            ->join('users', 'users.id', '=', 'comment_courses.user_id')
            ->select(
                'comment_courses.id',
                'comment_courses.description',
                'comment_courses.name',
                'users.image',
                'comment_courses.hour',
                'comment_courses.date'
            );
    }

    protected function getImageAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
