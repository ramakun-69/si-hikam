<?php

namespace App\Repositories\App;

use LaravelEasyRepository\Repository;
use Illuminate\Database\Eloquent\Model;

interface AppRepository extends Repository{

    public function insertOneModel(Model $model, array $data);
    public function insertOneModelWithFile(Model $model, array $data, $fileKey =  null, $filePath);
    public function insertOneModelWithFileArray(Model $model, array $data,$column, $fileKey =  null, $filePath);
    public function updateOneModel(Model $model, array $data);
    public function deleteOneModel(Model $model);
    public function insertTwoDataInOneModel($model, $whereIn, array $array, array $data, $loopData);
    public function updateOneModelWithFile($model, array $data, $key =  null, $filePath);
    public function restore($model);
    public function forceDeleteOneModel($model);
    public function forceDeleteOneModelWithFile($model, $key);
}
