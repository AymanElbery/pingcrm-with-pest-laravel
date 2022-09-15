<?php

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBePhoneNumber', function () {
    expect($this->value)->toBeString()->not->toBeEmpty()->toStartWith('+');

    if(strlen($this->value) < 6){
        throw new ExceptionFailedException("Phone number must be at least 6 characters.");
    }

    if(!is_numeric(Str::of($this->value)->after('+')->remove([' ', '-'])->__toString())){
        throw new ExceptionFailedException("Phone number must be numeric.");
    }
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function new_user()
{
    return User::factory()->create([
        'account_id' => Account::create(['name' => 'Acme Corporation'])->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'johndoe@example.com',
        'owner' => true,
    ]);
}

function login($user = null)
{
    return test()->actingAs($user ?? new_user());
}
