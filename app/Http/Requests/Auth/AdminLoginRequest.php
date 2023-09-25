<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ];
    }

    public function AdminLogin()
    {
        $credentials = $this->only('email', 'password');
        
        try {
            $auth = auth()->attempt($credentials);

            if (!$auth) throw new \Exception('Invalid credentials');
            if (auth()->user()->roles!=="admin") throw new \Exception('Invalid admin user');
            $data = [
                'token' => auth()->user()->createToken('auth_token')->plainTextToken,
                'name' => auth()->user()->name,
                'roles' => auth()->user()->roles,
            ];
            return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            "errors"=>null,
            'data' => $data,
        ], 200);
         
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                "errors"=>$e->getMessage(),
                'data' => null,
            ], 401);
        }
    }
}
