<?php

use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function(){
    $this->user = new_user();

    $this->user->account->organizations()->createMany([
        [
            'name' => 'Apple',
            'email' => 'info@apple.com',
            'phone' => '647-943-4400',
            'address' => '1600-120 Bremner Blvd',
            'city' => 'Toronto',
            'region' => 'ON',
            'country' => 'CA',
            'postal_code' => 'M5J 0A8',
        ], [
            'name' => 'Microsoft',
            'email' => 'info@microsoft.com',
            'phone' => '877-568-2495',
            'address' => 'One Microsoft Way',
            'city' => 'Redmond',
            'region' => 'WA',
            'country' => 'US',
            'postal_code' => '98052',
        ],
    ]);
});

test('can view organizations', function () {
    login($this->user)
    ->get('/organizations')
    ->assertInertia(fn (Assert $assert) => $assert
        ->component('Organizations/Index')
        ->has('organizations.data', 2)
        ->has('organizations.data.0', fn (Assert $assert) => $assert
            ->where('id', 1)
            ->where('name', 'Apple')
            ->where('phone', '647-943-4400')
            ->where('city', 'Toronto')
            ->where('deleted_at', null)
        )
        ->has('organizations.data.1', fn (Assert $assert) => $assert
            ->where('id', 2)
            ->where('name', 'Microsoft')
            ->where('phone', '877-568-2495')
            ->where('city', 'Redmond')
            ->where('deleted_at', null)
        )
    );
});

test('can search for organizations', function(){
    login($this->user)
    ->get('/organizations?search=Apple')
    ->assertInertia(fn (Assert $assert) => $assert
        ->component('Organizations/Index')
        ->where('filters.search', 'Apple')
        ->has('organizations.data', 1)
        ->has('organizations.data.0', fn (Assert $assert) => $assert
            ->where('id', 1)
            ->where('name', 'Apple')
            ->where('phone', '647-943-4400')
            ->where('city', 'Toronto')
            ->where('deleted_at', null)
        )
    );
});

test('cannot view deleted organizations', function(){
    $this->user->account->organizations()->firstWhere('name', 'Microsoft')->delete();

    login($this->user)
    ->get('/organizations')
    ->assertInertia(fn (Assert $assert) => $assert
        ->component('Organizations/Index')
        ->has('organizations.data', 1)
        ->where('organizations.data.0.name', 'Apple')
    );
});

test('can filter to view deleted organizations', function(){
    $this->user->account->organizations()->firstWhere('name', 'Microsoft')->delete();

    login($this->user)
    ->get('/organizations?trashed=with')
    ->assertInertia(fn (Assert $assert) => $assert
        ->component('Organizations/Index')
        ->has('organizations.data', 2)
        ->where('organizations.data.0.name', 'Apple')
        ->where('organizations.data.1.name', 'Microsoft')
    );
});
