<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Api\Traits\ApiResponseTraits;

class ApiController extends BaseController
{
    use ApiResponseTraits;
}
