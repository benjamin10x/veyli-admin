<?php

namespace Tests\Feature;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use App\Services\AuthApiService;
use App\Services\DashboardApiService;
use App\Services\RolesApiService;
use App\Services\UsersApiService;
use Mockery;
use Tests\TestCase;

class AuthAndAccessTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_dashboard_requires_authenticated_session(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error', 'Debes iniciar sesión.');
    }

    public function test_admin_route_blocks_non_admin_role(): void
    {
        $this->bindUsersPageServices();

        $response = $this
            ->withSession([
                'api_token' => 'jwt-token',
                'api_user' => ['role' => 'operador'],
            ])
            ->get('/usuarios');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'No tienes permisos para acceder a este módulo.');
    }

    public function test_admin_route_is_available_for_admin(): void
    {
        $this->bindUsersPageServices();

        $response = $this
            ->withSession([
                'api_token' => 'jwt-token',
                'api_user' => ['role' => 'admin', 'name' => 'Admin', 'email' => 'admin@example.com'],
            ])
            ->get('/usuarios');

        $response->assertOk();
    }

    public function test_login_stores_tokens_and_redirects_to_dashboard(): void
    {
        $mock = Mockery::mock(AuthApiService::class);
        $mock->shouldReceive('login')
            ->once()
            ->with('admin@veyli.local', 'Password123!')
            ->andReturn([
                'data' => [
                    'tokens' => [
                        'access_token' => 'access-token',
                        'refresh_token' => 'refresh-token',
                    ],
                    'user' => [
                        'id' => 1,
                        'name' => 'Administrador VEYLI',
                        'email' => 'admin@veyli.local',
                        'role' => 'admin',
                    ],
                ],
            ]);

        $this->app->instance(AuthApiService::class, $mock);

        $response = $this->post('/login', [
            'email' => 'admin@veyli.local',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('api_token', 'access-token');
        $response->assertSessionHas('api_refresh_token', 'refresh-token');
        $response->assertSessionHas('api_user.email', 'admin@veyli.local');
    }

    public function test_login_maps_validation_errors_from_api(): void
    {
        $mock = Mockery::mock(AuthApiService::class);
        $mock->shouldReceive('login')
            ->once()
            ->andThrow(new ApiValidationException('Validation failed.', 422, [
                'errors' => ['email' => ['El correo no es valido.']],
            ]));

        $this->app->instance(AuthApiService::class, $mock);

        $response = $this->from('/login')->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
    }

    public function test_middleware_resolves_user_with_auth_me_when_session_user_is_missing(): void
    {
        $this->app->instance(DashboardApiService::class, new class
        {
            public function summary(): array
            {
                return ['data' => ['totals' => [], 'recent_packages' => []]];
            }
        });

        $mock = Mockery::mock(AuthApiService::class);
        $mock->shouldReceive('me')
            ->once()
            ->andReturn([
                'data' => [
                    'user' => [
                        'id' => 1,
                        'name' => 'Operador VEYLI',
                        'email' => 'operador@veyli.local',
                        'role' => 'operador',
                    ],
                ],
            ]);

        $this->app->instance(AuthApiService::class, $mock);

        $response = $this
            ->withSession(['api_token' => 'valid-token'])
            ->get('/dashboard');

        $response->assertOk();
        $response->assertSessionHas('api_user.email', 'operador@veyli.local');
    }

    public function test_expired_api_session_redirects_back_to_login(): void
    {
        $this->app->instance(DashboardApiService::class, new class
        {
            public function summary(): array
            {
                return ['data' => ['totals' => [], 'recent_packages' => []]];
            }
        });

        $mock = Mockery::mock(AuthApiService::class);
        $mock->shouldReceive('me')
            ->once()
            ->andThrow(new ApiException('Expired token.', 401));

        $this->app->instance(AuthApiService::class, $mock);

        $response = $this
            ->withSession(['api_token' => 'expired-token'])
            ->get('/dashboard');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error', 'Tu sesión expiró. Inicia sesión nuevamente.');
        $response->assertSessionMissing('api_token');
    }

    protected function bindUsersPageServices(): void
    {
        $this->app->instance(UsersApiService::class, new class
        {
            public function list(array $query = []): array
            {
                return [
                    'data' => [
                        'items' => [],
                        'pagination' => [
                            'page' => $query['page'] ?? 1,
                            'page_size' => $query['page_size'] ?? 10,
                            'total_items' => 0,
                            'total_pages' => 1,
                        ],
                    ],
                ];
            }
        });

        $this->app->instance(RolesApiService::class, new class
        {
            public function list(array $query = []): array
            {
                return [
                    'data' => [
                        'items' => [
                            ['id' => 1, 'name' => 'admin'],
                            ['id' => 2, 'name' => 'operador'],
                        ],
                        'pagination' => [
                            'page' => $query['page'] ?? 1,
                            'page_size' => $query['page_size'] ?? 100,
                            'total_items' => 2,
                            'total_pages' => 1,
                        ],
                    ],
                ];
            }
        });
    }
}
