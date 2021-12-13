<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SwaggerRepository;


class HomeController extends Controller
{
    private $swaggerRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SwaggerRepository $swaggerRepository)
    {
        $this->swaggerRepository = $swaggerRepository;
    }

    /**
     * Show the home route.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lists = $this->swaggerRepository->getSwaggerDocuments();

        return view('home', compact('lists'));
    }

     /**
     * Health
     *
     * @return response
     */
    public function healthz()
    {
        return response('OK', 200);
    }
}
