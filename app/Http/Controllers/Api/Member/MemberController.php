<?php

namespace App\Http\Controllers\Api\Member;

use App\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\Member\MemberRepository;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    public function __construct(
        protected MemberRepository $repository
    ) {
    }

    public function getAllCourseMember()
    {
        try {
            // Obter todos os cursos associados ao membro atual
            $courses = $this->repository->getAllCourseMember();

            return response()->json([
                'success' => true,
                'data' => CourseResource::collection($courses),
                'message' => 'Courses retrieved successfully',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Tratar erros e retornar uma resposta adequada
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve courses: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCourseByIdMember($id)
    {
        $course = $this->repository->getCourseByIdMember($id);

        if (!$course) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new CourseResource($course);
    }


}
