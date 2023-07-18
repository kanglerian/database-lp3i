<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

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
            'email' => ['required', 'email', 'max:255'],
            'role' => ['string'],
            'status' => ['string'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $numbers_unique = mt_rand(1, 1000000000);

        $data = [
            'identity' => $numbers_unique,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
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
            'status' => '1',
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

        // event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
