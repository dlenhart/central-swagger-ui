<?php 

namespace App\Repository;

use App\Models\SwaggerConfig;
use Illuminate\Support\Facades\Auth;
use App\Repository\Interfaces\SwaggerAdminInterface;
use Illuminate\Database\Eloquent\Builder;


class SwaggerAdminRepository implements SwaggerAdminInterface
{
    public function getResources(): Builder
    {
        return SwaggerConfig::orderBy('name', 'ASC');
    }

    public function storeResource($resource): SwaggerConfig
    {
        return SwaggerConfig::create([
            'url'       =>  $resource->url,
            'name'      =>  $resource->name,
            'active'    =>  boolval($resource->active),
            'author'    =>  Auth::user()->id
        ]);
    }

    public function updateResource($resource): bool
    {
        return SwaggerConfig::findOrFail($resource->id)
            ->update([
                'url'       =>  $resource->url,
                'name'      =>  $resource->name,
                'active'    =>  boolval($resource->active),
                'author'    =>  $resource->author
            ]);
    }

    public function deleteResource($id): bool
    {
        return SwaggerConfig::findOrFail($id)->delete();
    }
}