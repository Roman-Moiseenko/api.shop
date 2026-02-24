<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{

    public function login(Request $request)
    {
       // \Log::info(json_encode($request->all()));
      //  \Log::info(json_encode($request->header('X-XSRF-TOKEN')));

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
     //   \Log::info("Валидация");
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember', true))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        $token = $request->user()->createToken('web'); //$request->token_name
    //    \Log::info("Залогинились");
        // Важно: Sanctum автоматически выполняет необходимые действия при успешной аутентификации.
        // Если вы хотите явно сгенерировать токен, это будет выглядеть так:
        // $token = $request->user()->createToken('auth_token')->plainTextToken;
        // Но для SPA аутентификации с куки, это не всегда нужно, так как сессия уже установлена.
        return response()->json(['message' => __('Welcome!'), 'token' => $token->plainTextToken]);//->noContent(); // Sanctum отправит cookie
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->noContent();
    }
}
