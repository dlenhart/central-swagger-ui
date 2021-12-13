<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SwaggerRepository;
use App\Services\SwaggerService;
use GuzzleHttp\Client;


class SwaggerController extends Controller
{
    private $swaggerRepository;
    private $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SwaggerRepository $swaggerRepository)
    {
        $this->swaggerRepository = $swaggerRepository;
        $this->service = new SwaggerService($this->swaggerRepository);
    }

    /**
     * All Swagger documents
     *
     * @return json
     */

    /**
     * @OA\Get(
     *      path="/api/config",
     *      tags={"Swagger"},
     *      summary="All Swagger documents",
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *    ) 
     * )
     */
    public function getSwaggerDocuments()
    {
        return $this->service->swaggerDocuments();
    }

    /**
     * Single Swagger document
     *
     * @return json
     */
    public function getSwaggerDocument(Request $request)
    {
        return $this->service->swaggerDocument($request->id);
    }

    /**
     * Proxy Swagger link if needed
     * -- If CORS is an issue.
     *
     * @return void
     */
    public function proxySwaggerDocument(Request $request, Client $client)
    {
        return $this->service->proxySwaggerLink($request, $client);
    }
}
