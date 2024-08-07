<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Executa as migrações
        Artisan::call('migrate');
    }

    public function test_get_all_course_member()
    {
        // Cria um utilizador e cursos fictícios
        $user = User::factory()->create();
        $course = Course::factory()->create();

        // Autentica o utilizador
        $this->actingAs($user, 'api');

        // Faz uma requisição à rota
        $response = $this->getJson('/api/courses/member');

        // Verificações
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['category_id', 'user_id', 'name', 'url','description', 'image', 'code', 'total_hours', 'published', 'free',
        'price']
            ],
            'message'
        ]);
        $this->assertEquals($course->id, $response->json('data')[0]['id']);
    }

    public function test_get_all_course_member_unauthorized()
    {
        // Faz uma requisição sem autenticação
        $response = $this->getJson('/api/courses/member');

        // Verificações
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }
}
