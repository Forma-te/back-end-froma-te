<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_course extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function commentCoursesAnswers()
    {
        return $this->hasOne(Comment_course_answer::class)
            ->join('users', 'users.id', '=', 'comment_course_answers.user_id')
            ->select(
                'comment_course_answers.description',
                'users.name',
                'users.image',
                'comment_course_answers.hour',
                'comment_course_answers.date'
            );
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('instrutor_id', auth()->user()->id);
    }

    public function course()
    {
        return $this->belongsto(Course::class);
    }

    public function rulesAnswerComment()
    {
        return ['description' => 'required|min:2|max:5000'];
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|min:3|max:100',
            'description' => 'required|min:3|max:5000',
        ];
    }

    public function newCommentCourse($dataForma)
    {
        $this->user_id = (auth()->check()) ? auth()->user()->id : 1;
        $this->instrutor_id = $dataForma['instrutor_id'];
        $this->course_id = $dataForma['course'];
        $this->name = $dataForma['name'];
        $this->email = $dataForma['email'];
        $this->description = $dataForma['description'];
        $this->date = date('Y-m-d');
        $this->hour = date('H:i:s');
        $this->status = 'R';

        return $this->save();
    }
}
