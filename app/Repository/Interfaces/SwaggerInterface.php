<?php

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;
use App\Models\SwaggerConfig;

interface SwaggerInterface
{
    public function getSwaggerDocuments(): Collection;
    public function getSwaggerDocument(int $id): SwaggerConfig;
}