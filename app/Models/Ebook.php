<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'user_id', 'name', 'short_name', 'url', 'description', 'type', 'file', 'code', 'published', 'free',
        'price',
    ];

    public function rules($id = '')
    {
        return [

            'category_id' => 'required',
            'name' => 'required|min:5|max:150',
            'description' => 'required',
            'short_name' => 'required|max:150',
            'file' => 'nullable|image|mimes:png,jpg|max:5120||dimensions:max_width=600,max_height=450',
            'code' => "nullable|unique:courses,code,{$id},id",
            'price' => 'required',
            'type' => 'nullable',

        ];
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'sales', 'course_id', 'user_id')
            ->where('sales.status', 'approved');
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
                'users.profile_photo_path',
                'comment_courses.hour',
                'comment_courses.date'
            );
    }
}
