<?php

namespace App\DTO\Product;

class CourseDTO
{
    public function __construct(
        public int $id,
        public string $Course,
        public string $product_type,
        public int $viewsLessons,
        public int $totalLessons,
        public ?string $image
    ) {
    }

    public static function fromModel($product): self
    {
        return new self(
            $product->id,
            $product->name,
            $product->product_type,

            // Aqui somamos as visualizações de todas as lições de todos os módulos
            $product->modules->sum(fn ($module) => $module->lessons->sum(fn ($lesson) => $lesson->views->count())),
            // Aqui somamos o total de lições de todos os módulos
            $product->modules->sum(fn ($module) => $module->lessons->count()),
            $product->files->pluck('image')->filter()->first()
        );
    }
}
