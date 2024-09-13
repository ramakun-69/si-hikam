<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\QrCode;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */


    public function insertUser($data, $fileKey = null, $filePath)
    {
        return DB::transaction(function () use ($data, $fileKey, $filePath) {
            $fileName = $fileKey && request()->hasFile($fileKey)
                ? request()->file($fileKey)->store($filePath, 'public')
                : null;
            $user = User::create([
                'username' => $data['username'],
                'password' => 'sihikam123#',
                'photo' => $fileName,
                'role' => 'employee',
            ]);
            Employee::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'nip' => $data['nip'],
                'address' => $data['address'],
                'phone' => $data['phone'],
            ]);
            QrCode::create([
                'nip' => $data['nip'],
                'data' => Str::random(10),
            ]);
        });
    }
    public function updateUser($data, $fileKey = null, $filePath)
    {
        return DB::transaction(function () use ($data, $fileKey, $filePath) {
            $user = User::find($data['id']);
            $fileName = $user->photo;
            if ($fileKey && request()->hasFile($fileKey)) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $fileName = request()->file($fileKey)->store($filePath, 'public');
            }
            $user->update(['username' => $data['username'], 'photo' => $fileName]);
            $user->employee->update($data);
            // Update or create QR code
            $user->employee->qrCode()->update(
                ['nip' => $data['nip']],
            );
        });
    }

    public function deleteUser($user)
    {
        return DB::transaction(function () use ($user) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->employee->qrCode()->delete();
            $user->employee()->delete();
            $user->delete();
        });
    }
}
