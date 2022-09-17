<?php

use App\Models\Contact;
use function Pest\Faker\faker;

it('can store a contact', function ($email) {
    login()->post('/contacts',[
        'first_name'    => faker()->firstName,
        'last_name'     => faker()->lastName,
        'email'         => $email,
        'phone'         => faker()->e164PhoneNumber,
        'address'       => '1 Test Street',
        'city'          => 'Test City',
        'region'        => 'Test Region',
        'country'       => faker()->randomElement(['US', 'KSA']),
        'postal_code'   => faker()->postcode,
    ])
        ->assertRedirect('/contacts')
        ->assertSessionHas('success', 'Contact created.');

    expect(Contact::latest()->first())
        ->first_name->toBeString()->not->toBeEmpty()
        ->last_name->toBeString()->not->toBeEmpty()
        ->email->toBeString()->not->toBeEmpty()->toContain('@')
        ->phone->toBePhoneNumber()
        ->address->toBe('1 Test Street')
        ->city->toBe('Test City')
        ->region->toBe('Test Region')
        ->country->toBeIn(['US', 'KSA']);

})->with([
    'ayman.bery@gmail.com'
]);
