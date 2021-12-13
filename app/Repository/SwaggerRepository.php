<?php

namespace App\Repository;

use App\Models\SwaggerConfig;
use Illuminate\Support\Collection;
use App\Repository\Interfaces\SwaggerInterface;

class SwaggerRepository implements SwaggerInterface
{
    public function getSwaggerDocuments(): Collection
    {
        return SwaggerConfig::where('active', true)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getSwaggerDocument(int $id): SwaggerConfig
    {
        return SwaggerConfig::findOrFail($id);
    }
}
