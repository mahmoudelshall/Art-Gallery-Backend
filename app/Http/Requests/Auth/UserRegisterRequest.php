<?php

namespace App\Http\Requests\Auth;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|regex:/^\+?\d{1,3}[-.\s]?\(?\d{1,3}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}$/',
            'address' => 'required|string',

        ];
    }
    public function userRegister(): Customer
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $customer = Customer::create(
            [
                'name' => $this->name,
                'user_id' =>$user['id'],
                'email' => $this->email,
                'phone' => $this->phone,
                'address' =>$this->address,
            ]
        );

        return $customer->makeHidden('created_at', 'updated_at');
    }
}
