<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * Test that the public registration route is accessible.
     *
     * @return void
     */
    public function test_public_registration_page_is_accessible()
    {
        $response = $this->get('/registrar-solicitud');

        $response->assertStatus(200);
        $response->assertSeeLivewire('solicitud-registro');
    }
}
