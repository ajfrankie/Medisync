<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Rules\NICValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function index(Request $request)
    {
        $roles = Role::all();

        return view('backend.auth.register', [
            'roles' => $roles,
            'request' => $request
        ]);
    }

    /**
     * Validate incoming registration request
     */
    protected function validator(array $data)
    {
        $dob = $data['dob'] ?? null;
        $age = $dob ? \Carbon\Carbon::parse($dob)->age : 0;

        return Validator::make($data, [
            'role_id' => ['required', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'dob' => ['required', 'date', 'before:today'],
            'nic' => array_filter([
                $age >= 18 ? 'required' : 'nullable',   // required only if age >= 18
                'string',
                'max:12',
                'unique:users,nic',
                !empty($data['nic']) ? new NICValidationRule($dob, $data['gender'] ?? null) : null, // apply NIC validation only if value exists
            ]),
            'gender' => ['required', 'in:male,female'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
    }

    /**
     * Create user
     */
    protected function create(array $data)
    {
        $imagePath = null;

        if (isset($data['image_path'])) {
            $imagePath = $data['image_path']->store('uploads/users', 'public');
        }

        return User::create([
            'role_id' => $data['role_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'dob' => $data['dob'],
            'nic' => $data['nic'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'image_path' => $imagePath,
        ]);
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Auto-login after register
        $this->guard()->login($user);

        return redirect($this->redirectPath())->with('success', 'Registration successful!');
    }

    /**
     * Get the guard to be used during registration
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Redirect after successful registration
     */
    protected function redirectPath()
    {
        return route('admin.login'); // Change to your actual dashboard route
    }
}
