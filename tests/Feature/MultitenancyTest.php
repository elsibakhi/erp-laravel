<?php

use App\Domains\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class)
    ->in('Feature');

beforeEach(function () {
    // Migrate landlord and tenant databases
    Artisan::call('migrate', ['--database' => 'landlord', '--path' => 'database/migrations/landlord', '--force' => true]);
    Tenant::create(['name' => 'Test Tenant', 'domain' => 'test.localhost', 'database' => 'testDb']);
    Artisan::call('tenants:artisan', [
        'artisanCommand' => 'migrate --database=tenant',  // The actual command you want to run
    ]);
});

describe('Multitenancy User Creation', function () {
    it('creates a landlord user', function () {
        $response = $this->postJson('/api/v1/base/register', [
            'name' => 'Landlord Test',
            'email' => 'landlord@test.com',
            'password' => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => 'landlord@test.com',
        ], 'landlord');
    });

    it('creates a tenant user', function () {
        $response = $this->withServerVariables([
            'HTTP_HOST' => 'baraa.localhost', // Set the desired subdomain
        ])->postJson('/api/v1/register', [
            'name' => 'Tenant Test',
            'email' => 'tenant@test.com',
            'password' => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => 'tenant@test.com',
        ], 'tenant');
    });
});
