<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // After successful login


        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $userRole = auth()->user()->role;

        if ($userRole === 'ADMINISTRATION') {
            return '/dashboard';
        } elseif ($userRole === 'AGENT') {
            return '/dashboard';
        } else {
            return '/profile';
        }
    }
}
