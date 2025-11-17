<?php

/**
 * API v1 Health controller
 *
 * @package    App
 * @category   Controllers
 * @license    MIT
 * @link       https://github.com/mauijay/ci4-bs5
 */

namespace App\Controllers\Api\V1;

use App\Controllers\Api\ApiBaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Health extends ApiBaseController
{
    public function index(): ResponseInterface
    {
        $payload = [
            'status'    => 'ok',
            'timestamp' => date('c'),
        ];

        return $this->respond($payload, 200);
    }
}
