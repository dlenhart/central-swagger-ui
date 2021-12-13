<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SwaggerConfig;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        $urls = SwaggerConfig::orderBy('name', 'ASC')->get();

        return view('admin', compact('urls'));
    }
}
