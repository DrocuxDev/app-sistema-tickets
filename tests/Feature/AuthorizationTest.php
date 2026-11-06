<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    public function test_protected_sections_require_a_session(): void
    {
        foreach ([
            '/cliente/dashboard',
            '/admin/dashboard',
            '/tecnico/dashboard',
            '/usuario/dashboard',
        ] as $route) {
            $this->get($route)->assertRedirect('/');
        }
    }

    public function test_a_client_cannot_access_the_admin_section(): void
    {
        $this->withSession(['id' => 1, 'tipo' => 'cliente'])
            ->get('/admin/dashboard')
            ->assertRedirect('/');
    }

    public function test_a_technician_cannot_access_the_client_section(): void
    {
        $this->withSession(['id' => 1, 'tipo' => 'tecnico'])
            ->get('/cliente/dashboard')
            ->assertRedirect('/');
    }

    public function test_the_home_page_remains_public(): void
    {
        $this->get('/')->assertOk();
    }
}
