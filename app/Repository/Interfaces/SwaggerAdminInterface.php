<?php

namespace App\Repository\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;


interface SwaggerAdminInterface
{
    public function getResources();
    public function storeResource($resource);
    //public function updateResource();
    //public function deleteResource();
}