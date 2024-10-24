<?php

namespace App\DTO\Course;

class GetCourseByUrlDTO
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}
