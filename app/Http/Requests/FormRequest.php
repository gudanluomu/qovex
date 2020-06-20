<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class FormRequest extends Request
{
    public function authorize()
    {
        return true;
    }
}
