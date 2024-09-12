<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseOutput;
    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function authenticate(AuthRequest $request)
    {
        return $this->safeExecute(function () use ($request) {
            $result = $this->authRepository->apiAuthentication($request);
            if ($result['status']) {
                $token = $result['user']->createToken('API Token')->plainTextToken;
                return $this->responseSuccess([
                    "token" => $token,
                    "user" => new UserResource($result['user']->load('employee'))
                ]);
            }
            $errorMessages = [
                'not_employee' => __('You are not registered as employees'),
                'incorrect_credentials' => __('auth.failed'),
                'unknown_error' => __('Authentication failed due to an unknown error.')
            ];
            return $this->responseFailed($errorMessages[$result['message']] ?? $errorMessages['unknown_error']);
        });
    }
    

    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
