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

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Health extends BaseController
{
    use ResponseTrait;

    public function index(): ResponseInterface
    {
        $payload = [
            'status'    => 'ok',
            'timestamp' => date('c'),
        ];

        return $this->respond($payload, 200);
    }
}
