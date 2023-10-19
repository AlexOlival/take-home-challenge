<?php

namespace App\Providers;

use App\Services\Auth0\JWTServiceInterface;
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Illuminate\Auth\GenericUser;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register()
    {
        $this->app->singleton(Auth0::class, function () {
            $config = array_merge(config('auth0'), [
                'httpClient' => $this->app->make('httpClient'),
                'strategy' => 'api'
            ]);

            $configuration = new SdkConfiguration($config);

            return new Auth0($configuration);
        });
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(JWTServiceInterface $jwtService): void
    {
        $this->registerPolicies();

        $this->app['auth']->viaRequest('auth0-token', function (Request  $request) use ($jwtService) {
            if (!$request->headers->has('authorization')) {
                return null;
            }

            $bearerToken = $jwtService->extractBearerTokenFromRequest($request);
            $data = $jwtService->decodeBearerToken($bearerToken);

            // ugly hack to make it work
            $user = new GenericUser($data);
            $user->id = 1;

            return $user;
        });
    }
}
