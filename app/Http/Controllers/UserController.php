<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserRequest;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{
    use ResponseOutput;
    protected $userRepository;
    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    // Display a listing of the users.
    public function index()
    {
        $title = __("User");
        return view('pages.user.index', compact('title'));
    }

    // Show the form for creating a new user.
    public function create() {}

    // Store a newly created user in storage.
    public function store(UserRequest $request)
    {

        return $this->safeExecute(function () use ($request) {
            $data = $request->validated();
            if ($data['id']) {

                $this->userRepository->updateUser($data, 'photo', 'images/user');
                return $this->responseSuccess(['message' =>  __("Data Updated Successfully")]);
            } else {
                $this->userRepository->insertUser($data, 'photo', 'images/user');
                return $this->responseSuccess(['message' => __("Data Added Successfully")]);
            }
        });
    }

    // Display the specified user.
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    // Show the form for editing the specified user.
    public function edit(User $user)
    {
        return $this->safeExecute(function () use ($user) {
            return $this->responseSuccess($user->load('employee'));
        });
    }

    // Update the specified user in storage.
    public function update(Request $request, User $user)
    {
    }

    // Remove the specified user from storage.
    public function destroy(User $user)
    {
        return $this->safeExecute(function () use ($user) {
            $this->userRepository->deleteUser($user);
            return $this->responseSuccess(['message' => __('Data Deleted Successfully')]);
        });
    }
}
