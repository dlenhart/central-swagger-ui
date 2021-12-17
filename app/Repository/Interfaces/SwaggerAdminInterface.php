<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use App\Models\SwaggerConfig;

interface SwaggerAdminInterface
{
    public function getResources(): Builder;
    public function storeResource($resource): SwaggerConfig;
    public function updateResource($resource): bool;
    public function deleteResource($resource): bool;
}