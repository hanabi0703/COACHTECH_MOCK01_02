<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Log;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Log::debug($input);
        // try {
        $validated = app(RegisterRequest::class)->merge($input)->validated();
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     Log::error($e->errors()); // エラーメッセージをログに出力
        // }

        // app(RegisterRequest::class);
        // Log::debug($request->rules());
        // Log::debug($request->validated());
        // Log::debug($input);

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
