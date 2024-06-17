<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\Member\MemberRepository;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function __construct(
        protected MemberRepository $repository
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/courses-member",
     *     summary="Get all courses associated with the current member",
     *     description="Fetches a list of all courses associated with the current member.",
     *     operationId="getAllCourseMember",
     *     tags={"Member"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of courses",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Vue 3 Laravel"),
     *                 @OA\Property(property="description", type="string", example="VUE 3 Laravel"),
     *                 @OA\Property(property="image", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/courses/F987737.jpg"),
     *                 @OA\Property(
     *                     property="modules",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Modulo 1"),
     *                         @OA\Property(
     *                             property="lessons",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="Lesson 1"),
     *                                 @OA\Property(property="description", type="string", example="CNN PRIME TIME"),
     *                                 @OA\Property(property="video", type="string", example="https://www.youtube.com/watch?v=a1HjPcJbB3c"),
     *                                 @OA\Property(property="file", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/lessonPdf/lesson-1.pdf"),
     *                                 @OA\Property(property="views", type="array", @OA\Items(
     *                                     @OA\Property(property="id", type="integer", example=1),
     *                                     @OA\Property(property="user_id", type="integer", example=2),
     *                                     @OA\Property(property="lesson_id", type="integer", example=1),
     *                                     @OA\Property(property="qty", type="integer", example=1)
     *                                 ))
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve the courses",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Failed to retrieve courses: Database connection error"
     *             )
     *         )
     *     )
     * )
     */
    public function getAllCourseMember()
    {
        try {
            // Obter todos os cursos associados ao membro atual
            $courses = $this->repository->getAllCourseMember();
            return response()->json([
                'data' => CourseResource::collection($courses),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Tratar erros e retornar uma resposta adequada
            return response()->json([
                'message' => 'Failed to retrieve courses: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/course/{id}/member",
     *     summary="Get course by ID for a specific member",
     *     description="Fetches a specific course by its ID for a particular member.",
     *     operationId="getCourseByIdMember",
     *     tags={"Member"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the course",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the course",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Vue 3 Laravel"),
     *             @OA\Property(property="description", type="string", example="VUE 3 Laravel"),
     *             @OA\Property(property="image", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/courses/F987737.jpg"),
     *             @OA\Property(
     *                 property="modules",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Modulo 1"),
     *                     @OA\Property(
     *                         property="lessons",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Lesson 1"),
     *                             @OA\Property(property="description", type="string", example="CNN PRIME TIME"),
     *                             @OA\Property(property="video", type="string", example="https://www.youtube.com/watch?v=a1HjPcJbB3c"),
     *                             @OA\Property(property="file", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/lessonPdf/lesson-1.pdf")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             type="object",
     *
     *         )
     *     )
     * )
     */


    public function getCourseByIdMember($id)
    {
        // Tenta encontrar o curso pelo ID usando o repositório
        $course = $this->repository->getCourseByIdMember($id);

        // Verifica se o curso foi encontrado
        if (!$course) {
            return response()->json([
                'data' => []
            ], Response::HTTP_NOT_FOUND);
        }

        // Retorna o curso usando um recurso
        return new CourseResource($course);
    }

}
