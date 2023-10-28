<?php

namespace App\Providers;

use App\Models\User;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        Gate::define('admin', function(User $user) {
            return $user->isAdmin();
        });

        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken();

            if (!empty($token) && $data = $this->getPayload($token)) {
                return User::find($data->data->id);
            }

            return null;
        });
    }

    public function getPayload($token)
    {
        $key = env('APP_KEY');
        try {
            JWT::$leeway = 60;
            return  JWT::decode($token, new Key($key, 'HS256'));
        } catch (SignatureInvalidException|BeforeValidException|ExpiredException|Exception) {
            return null;
        }
    }
}
