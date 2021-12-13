<?php 

namespace App\Mappers;

use Illuminate\Support\Collection;

class Mappers
{   
    public static function mapSwaggerResults(object $documents): Collection
    {
        return collect($documents)->map(function ($item) {
            return [
                'id'        => $item->id,
                'name'      => $item->name,
                'url'       => $item->url,
                'active'    => $item->active ? true : false,
            ];
        });
    }
}