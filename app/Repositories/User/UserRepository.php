<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{

   public function insertUser($data,$fileKey = null, $filePath);
   public function updateUser($data, $fileKey = null, $filePath);
   public function deleteUser($user);
}
