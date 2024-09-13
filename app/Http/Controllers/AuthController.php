<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\AuthRequest;
use App\Repositories\Auth\AuthRepository;
use App\Traits\RedirectUser;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ResponseOutput, RedirectUser;
    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function index()
    {
        $title = __("Login");
        return view('auth/login', compact('title'));
    }
    public function auth(AuthRequest $request)
    {
      return $this->safeExecute(function() use($request){
        $auth = $this->authRepository->auth($request);

        if ($auth) {
            return $request->wantsJson()
                ? $this->responseSuccess([
                    "message" => __('Authentication Success, Wait a Moment'),
                    "redirect" => $this->redirectPath()
                ], 200)
                : redirect()->intended($this->redirectPath());
        }
        $error = $request->session()->get('auth_error', 'unknown_error');
        $errorMessages = [
            'not_admin' => __('You do not have admin access.'),
            'incorrect_credentials' => __('auth.failed'),
            'unknown_error' => __('Authentication failed due to an unknown error.')
        ];

        return $this->responseFailed($errorMessages[$error] ?? $errorMessages['unknown_error']);
       
      });
   
        
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
