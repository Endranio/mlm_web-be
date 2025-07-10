<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CorsController extends ResourceController
{
    public function preflight()
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->setStatusCode(200);
    }
}
