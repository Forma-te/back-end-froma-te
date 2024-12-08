<?php

namespace App\DTO\Product;

class CourseByIdDTO
{
    public function __construct(
        public int $id,
        public string $Course,
        public string $producer,
        public string $product_type,
        public array $modules,
        public int $viewsLessons,
        public int $totalLessons,
        public ?string $image,
        public ?string $LessonFile
    ) {
    }

    public static function fromModel($product): self
    {
        return new self(
            $product->id,
            $product->name,
            $product->user->name,
            $product->product_type,
            $product->modules->map(fn ($module) => [
                'id' => $module->id,
                'name' => $module->name,
                'lessons' => $module->lessons->map(fn ($lesson) => [
                    'id' => $lesson->id,
                    'title' => $lesson->name,
                    'views' => $lesson->views->count()
                ]),
            ])->toArray(),
            $product->modules->sum(fn ($module) => $module->lessons->sum(fn ($lesson) => $lesson->views->count())),
            // Aqui somamos o total de lições de todos os módulos
            $product->modules->sum(fn ($module) => $module->lessons->count()),
            $product->files->pluck('image')->filter()->first(),
            $product->modules->flatMap(fn ($module) => $module->lessons->flatMap(fn ($lesson) => $lesson->files->pluck('file')))
                            ->filter()->first()
        );
    }
}
