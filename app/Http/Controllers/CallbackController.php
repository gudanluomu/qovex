<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function callback(Request $request)
    {
        $redirect_url = $request->get('redirect_url', route('index'));
        $errors= $request->get('errors');

        return redirect($redirect_url)->withErrors($errors);
    }
}
