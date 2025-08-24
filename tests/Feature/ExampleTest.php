<?php

use App\Models\User;

/**
 * @mixin Tests\TestCase
 */
describe('tenant domain', function () {

    beforeEach(function () {

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->withoutExceptionHandling();

    });

    it('get tenants', function () {
        expect(true)->toBeTrue();

    });

    it('get landing with status 200', function () {

        $this->get('/')->assertStatus(200);
    });

});
