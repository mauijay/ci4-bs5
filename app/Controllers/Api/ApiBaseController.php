<?php

/**
 * Base API controller
 */

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiBaseController extends BaseController
{
    use ResponseTrait;

    protected string $format = 'json';
}
