<?php

namespace App\Helpers;

class Helpers
{
    /**
     * Validate request parameters
     *
     * @return 
     */
    public static function validateRequiredFields()
    {
        return request()->validate([
            'name' => 'required',
            'url' => 'required|url'
        ]);
    }
}