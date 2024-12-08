<?php

namespace App\Repositories\Lesson;

use App\DTO\Lesson\CreateFileLessonDTO;
use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\CreateNameLessonDTO;
use App\DTO\Lesson\UpdateEditNameLessonDTO;
use App\DTO\Lesson\UpdateFileLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\Module;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Traits\RepositoryTrait;

class LessonRepository implements LessonRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(
        protected Lesson $entity,
        protected Module $module,
        protected LessonFile $lessonFile
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $query = $this->entity;

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('name', $filter)
                      ->orWhere('name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->with('modules', 'files')->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function findById(string $id): ?object
    {
        return $this->entity->find($id);
    }

    public function getLessonByModuleId(string $moduleId): ?Collection
    {
        $module = $this->module->find($moduleId);

        if (!$module) {
            return null; // Módulo não encontrado
        }

        $course = $module->course;

        if (Gate::authorize('owner-course', $course)) {
            $lessons = $module->lessons()->with('files')->get();
        }

        if ($lessons->isEmpty()) {
            return null; // Sem lições
        }

        return $lessons; // Retorna uma coleção
    }

    public function new(CreateLessonDTO $dto): Lesson
    {
        return $this->entity->create((array) $dto);
    }

    public function update(UpdateLessonDTO $dto): ?Lesson
    {
        $lesson = $this->entity->find($dto->id);

        if ($lesson) {
            $lesson->update((array) $dto);
            return $lesson;
        }

        return null;
    }

    public function editNameLesson(UpdateEditNameLessonDTO $dto): ?Lesson
    {
        $lesson = $this->entity->find($dto->id);

        if ($lesson) {
            $lesson->update((array) $dto);
            return $lesson;
        }

        return null;
    }

    public function createNameLesson(CreateNameLessonDTO $dto): Lesson
    {
        return $this->entity->create((array) $dto);

    }

    public function findByIdFileLesson(string $lessonId): object|null
    {
        return $this->lessonFile->find($lessonId);
    }

    public function createFileLesson(CreateFileLessonDTO $dto): ?LessonFile
    {
        // Verifica se já existe um ficheiro de lição para esta lição
        $existingLessonFile = $this->lessonFile::where('lesson_id', $dto->lesson_id)->first();

        // Se já existir, elimina o ficheiro
        if ($existingLessonFile) {
            $existingLessonFile->delete();
        }

        // Caso contrário, cria um novo ficheiro de lição
        return $this->lessonFile->create((array) $dto);
    }

    public function updateFileLesson(UpdateFileLessonDTO $dto): ?LessonFile
    {
        $lessonFile = $this->lessonFile->find($dto->id);

        if ($lessonFile) {
            $lessonFile->update((array) $dto);
            return $lessonFile;
        }

        return null;
    }

    public function markLessonViewed(int $lessonId)
    {
        $user = $this->getUserAuth();

        $view = $user->views()->where('lesson_id', $lessonId)->first();

        if ($view) {
            return $view->update([
                'qty' => $view->qty,
            ]);
        }

        return $user->views()->create([
            'lesson_id' => $lessonId,
        ]);
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }
}
