<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }


    public function messages()
    {
        return [
            'required.*' => 'Không được để trống trường này',
            'string.*' => 'Kiểu dữ liệu phải là chuỗi',
            'max.*' => 'Tối đa 255 ký tự',
            'max.*' => 'Tối thiểu 8 ký tự',
            'email.*' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'username.unique' => 'Username đã tồn tại',
        ];
    }
}
