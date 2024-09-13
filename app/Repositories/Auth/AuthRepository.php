<?php

namespace App\Repositories\Auth;

use LaravelEasyRepository\Repository;

interface AuthRepository extends Repository{

    public function auth($request);
    public function apiAuthentication($request);
}
