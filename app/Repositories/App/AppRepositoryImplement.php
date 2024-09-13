<?php

namespace App\Repositories\App;

use App\Models\App;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class AppRepositoryImplement extends Eloquent implements AppRepository
{


    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    // Write something awesome :)

    public function insertOneModel($model, array $data)
    {
        return $model->create($data);
    }
    public function insertOneModelWithFile($model, array $data, $fileKey = null, $filePath)
    {
        if ($fileKey && request()->hasFile($fileKey)) {
            $file = request()->file($fileKey);
            $fileName = $this->storeFile($file, $filePath);
            $data[$fileKey] = $fileName;
        }
        return $model->create($data);
    }
    public function insertOneModelWithFileArray($model, array $data, $column, $fileKey = null, $filePath)
    {
        $file = request()->file($fileKey);
        $fileName = $this->storeFile($file, $filePath);

        $data[$column] = $fileName;
        return $model->create($data);
    }
    protected function storeFile($file, $filePath)
    {
        return $file->store($filePath, 'public');
    }
    public function insertTwoDataInOneModel($model, $whereIn, array $array, array $data, $loopData)
    {

        $data1 = $model->whereIn($whereIn, $array)->get();
        foreach ($data1 as $d1) {
            $data[$loopData] = $d1->id;
        }
        return $model->insert($data);
    }
    public function updateOneModel($model, array $data)
    {
        return $model->where('id', $data['id'])->update($data);
    }
    public function updateOneModelWithFile($model, array $data, $key =  null, $filePath)
    {

        $oldData = $model;
        $file = request()->file($key);
        if ($file != null) {

            if ($oldData->$key) {
                $this->deleteFile($oldData->$key);
            }
            $data[$key] = $file->store($filePath, 'public');
        } else {
            $data[$key] = $oldData->$key;
        }
        return $oldData->update($data);
    }
    public function deleteOneModel($model)
    {

        return $model->delete();
    }
    public function forceDeleteOneModel($model)
    {
        $models = $model->get();
        $models->each(function ($data) {
            $data?->forceDelete();
        });
    }

    public function forceDeleteOneModelWithFile($model, $key)
    {
        $models = $model->get();
        $models->each(function ($data) use ($key) {
            $data?->forceDelete();
            if ($data->$key) {
                Storage::disk('public')->delete($data?->$key);
            }
        });
    }

    function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
    }

    public function restore($model)
    {
        return $model->restore();
    }
}
