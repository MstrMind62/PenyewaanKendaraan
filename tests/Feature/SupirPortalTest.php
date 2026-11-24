<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SupirPortalTest extends TestCase
{
    public function test_supir_portal_routes_are_registered(): void
    {
        foreach ([
            'supir.login',
            'supir.login.store',
            'supir.logout',
            'supir.dashboard',
            'supir.tugas',
            'supir.tugas.detail',
            'supir.tugas.status',
        ] as $routeName) {
            $this->assertNotNull(Route::getRoutes()->getByName($routeName), $routeName);
        }
    }

    public function test_supir_login_page_resolves_the_view(): void
    {
        $this->get(route('supir.login'))
            ->assertOk()
            ->assertSee('Login Supir');
    }

    public function test_supir_dashboard_requires_a_driver_session(): void
    {
        $this->get(route('supir.dashboard'))->assertForbidden();
    }
}
