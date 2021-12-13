<?php 

namespace App\Repository;

use App\Models\SwaggerConfig;
use Illuminate\Support\Facades\Auth;
use App\Repository\Interfaces\SwaggerAdminInterface;


class SwaggerAdminRepository implements SwaggerAdminInterface
{
    public function getResources()
    {
        return SwaggerConfig::orderBy('name', 'ASC');
    }

    public function storeResource($resource)
    {
        return SwaggerConfig::create([
            'url'       =>  $resource->url,
            'name'      =>  $resource->name,
            'active'    =>  boolval($resource->active),
            'author'    =>  Auth::user()->id
        ]);
    }

    public function updateResource($resource)
    {
        return SwaggerConfig::findOrFail($resource->id)
            ->update([
                'url'       =>  $resource->url,
                'name'      =>  $resource->name,
                'active'    =>  boolval($resource->active),
                'author'    =>  $resource->author
            ]);
    }

    public function deleteResource($id)
    {
        return SwaggerConfig::findOrFail($id)->delete();
    }
}