<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Providers\RouteServiceProvider;
use App\Rules\PhoneValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => [
                'required',
                'string',
                new PhoneValidation,
                Rule::unique('users')->where(function ($query) {
                    $formattedPhone = '62' . substr(request()->input('phone'), 1);
                    return $query->where('phone', $formattedPhone);
                })
            ],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $numbers_unique = mt_rand(1, 1000000000);
        $phone = strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone');

        $data = [
            'identity' => $numbers_unique,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'role' => 'S',
            'status' => '0',
        ];

        $data_applicant = [
            'identity' => $numbers_unique,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
            'source' => '1',
            'status' => '3',
            'isread' => '0',
        ];

        $data_father = [
            'identity_user' => $numbers_unique,
            'gender' => 1,
        ];
        $data_mother = [
            'identity_user' => $numbers_unique,
            'gender' => 0,
        ];

        $user = User::create($data);
        Applicant::create($data_applicant);
        ApplicantFamily::create($data_father);
        ApplicantFamily::create($data_mother);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}