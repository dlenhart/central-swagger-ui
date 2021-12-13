<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\AdminService;
use App\Repository\SwaggerAdminRepository;


class AdminApiController extends Controller
{
    private $service;
    private $adminRepository;

    public function __construct(SwaggerAdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->service = new AdminService($this->adminRepository);
    }

    /**
     * Get a listing of all active documents.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return $this->service->list();
    }

    /**
     * Store a new resource.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validateRequiredFields();
        return $this->service->store($request);
    }

    /**
     * Delete a resource.
     *
     * @return void
     */
    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id'   => 'required|numeric',
            ]
        );

        if ($validator->errors()->any()) {
            return responder()
                ->error('validation', $validator->errors())
                ->respond(400);
        }

        return $this->service->delete($request->id);
    }

    /**
     * Update a resource.
     *
     * @return void
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'url'   => 'required|url'
            ]
        );

        if ($validator->errors()->any()) {
            return responder()
                ->error('validation', $validator->errors())
                ->respond(400);
        }

        return $this->service->update($request);
    }

    /**
     * Validate request parameters
     *
     * @return 
     */
    public function validateRequiredFields()
    {
        return request()->validate([
            'name'  => 'required',
            'url'   => 'required|url'
        ]);
    }
}
