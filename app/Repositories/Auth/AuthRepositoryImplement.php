<?php

namespace App\Repositories\Auth;

use Illuminate\Support\Facades\Auth;
use LaravelEasyRepository\Implementations\Eloquent;


class AuthRepositoryImplement extends Eloquent implements AuthRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    public function auth($request)
    {
        try {
            $credentials = $request->validated();
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $user = Auth::user();
                if ($user->role === 'admin') {
                    $request->session()->regenerate();
                    return true;
                } else {
                    Auth::logout();
                    $request->session()->flash('auth_error', 'not_admin');
                    return false;
                }
            }

            $request->session()->flash('auth_error', 'incorrect_credentials');
            return false;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public function apiAuthentication($request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role !== 'employee') {
                Auth::logout();
                return [
                    'status' => false,
                    'message' => 'not_employee'
                ];
            }
            return [
                'status' => true,
                'user' => $user
            ];
        }
        return [
            'status' => false,
            'message' => 'incorrect_credentials'
        ];
    }
}
