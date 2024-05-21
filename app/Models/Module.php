<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'name', 'published',
    ];

    public function authorize()
    {
        $course = course::find($this->get('course_id'));

        return Gate::allows('owner-course', $course);
    }

    public function rules()
    {
        return [

            'course_id' => 'required',
            'name' => 'required|min:2|max:150',

        ];
    }

    public function course()
    {
        return $this->belongsto(Course::class);
    }

    public function modulesUser()
    {
        return $this->join('courses', 'courses.id', '=', 'modules.course_id')
            ->where('courses.user_id', auth()->user()->id)
            ->pluck('modules.name', 'modules.id');
    }

    public function lessons()
    {
        //Metodo para retornar os modulos dos cursos relação de um para muitos
        return $this->hasMany(Lesson::class);
    }
}
