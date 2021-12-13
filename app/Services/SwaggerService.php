<?php

namespace App\Services;

use App\Repository\SwaggerRepository;
use App\Mappers\Mappers;
use Illuminate\Http\Response;

class SwaggerService
{
    private $swaggerRepository;

    public function __construct(SwaggerRepository $swaggerRepository)
    {
        $this->swaggerRepository = $swaggerRepository;
    }

    public function swaggerDocuments()
    {
        $results = $this->swaggerRepository->getSwaggerDocuments();
        $mappedResults = Mappers::mapSwaggerResults($results);

        return response()->json($mappedResults, 200);
    }

    public function swaggerDocument(int $id)
    {
        $result = $this->swaggerRepository->getSwaggerDocument($id);
        return response()->json($result, 200);
    }

    public function proxySwaggerLink($request, $client)
    {
        $id = $this->swaggerDocument($request->id);

        $response = $client->get($id->url);

        return new Response(
            $response->getBody(),
            $response->getStatusCode(),
            [
                'Content-Type' => $response->getHeaderLine('Content-Type')
            ]
        );
    }
}
