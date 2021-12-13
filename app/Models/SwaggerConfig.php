<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwaggerConfig extends Model
{
    use HasFactory;

    protected $table = 'swagger_config';

    protected $fillable = ['name', 'url', 'active', 'author'];
}
