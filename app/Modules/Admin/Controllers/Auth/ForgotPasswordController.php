<?php

namespace App\Modules\Admin\Controllers\Auth;

use App\Modules\Auth\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
}
