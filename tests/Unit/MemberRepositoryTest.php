<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Course;
use App\Repositories\Member\MemberRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;

class MemberRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_course_member()
    {
        // Cria dados fictícios
        $course = Course::factory()->create();

        // Repositório
        $repository = new MemberRepository(new Course());

        // Obter cursos
        $courses = $repository->getAllCourseMember();

        // Verificações
        $this->assertNotEmpty($courses);
        $this->assertEquals($course->id, $courses->first()->id);
    }

    public function test_get_all_course_member_logs_error_on_failure()
    {
        // Mock do modelo Course para lançar uma exceção
        $courseMock = Mockery::mock('alias:App\Models\Course');
        $courseMock->shouldReceive('with->get')->andThrow(new \Exception('Erro simulado'));

        // Repositório
        $repository = new MemberRepository(new Course());

        // Verificar logs
        Log::shouldReceive('error')->once()->with('Erro ao obter cursos: Erro simulado');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao obter cursos');

        // Tenta obter cursos (deverá lançar uma exceção)
        $repository->getAllCourseMember();
    }
}
