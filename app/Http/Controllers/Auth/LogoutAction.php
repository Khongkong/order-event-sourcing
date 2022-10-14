<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutAction extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response([
            'message' => 'Logged Out!',
        ]);
    }
}
