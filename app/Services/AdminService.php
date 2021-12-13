<?php

namespace App\Services;

use App\Repository\SwaggerAdminRepository;
use App\Constants;


class AdminService
{
    private $swaggerAdminRepository;


    public function __construct(SwaggerAdminRepository $swaggerAdminRepository)
    {
        $this->swaggerAdminRepository = $swaggerAdminRepository;
    }

    public function list()
    {
        $results = $this->swaggerAdminRepository->getResources();

        return response()->json($results->paginate(25), 200);
    }

    public function store($request)
    {
        $create = $this->swaggerAdminRepository->storeResource($request);

        if (!$create) {
            return responder()
                ->error('error', Constants::NO_SAVE_ERROR)
                ->respond();
        }

        return responder()->success()->respond();
    }

    public function update(object $request)
    {
        $update = $this->swaggerAdminRepository->updateResource($request);

        if (!$update) {
            return responder()
                ->error('error', Constants::NO_UPDATE_ERROR)
                ->respond();
        }

        return responder()->success()->respond();
    }

    public function delete(int $id)
    {
        $delete = $this->swaggerAdminRepository->deleteResource($id);

        if (!$delete) {
            return responder()
                ->error('error', Constants::NO_DELETE_ERROR)
                ->respond();
        }

        return responder()->success()->respond();
    }
}
