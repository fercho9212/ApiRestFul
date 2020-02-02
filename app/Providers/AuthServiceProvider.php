<?php

namespace App\Providers;

use App\User;
use App\Buyer;
use App\Seller;
use App\Product;
use Carbon\Carbon;
use App\Transaction;
use App\Policies\UserPolicy;
use App\Policies\BuyerPolicy;
use App\Policies\SellerPolicy;
use Laravel\Passport\Passport;
use App\Policies\ProductPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
       
        Gate::define('admin-action',function($user){
            return $user->esAdministrador();
        });
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //Passport::enableImplicitGrant();
        //eS RECOMENDADO MANTENERDO DESAHBILITADO YA QUE
        //POR SEGURIDAD ES IMPORTANTO HABILITARLO SI EL CLIENTE NO CUENTA
        //CON SISMTEA DE REFRESH TOKEN Passport::enableImplicitGrant();

        //scopes
        Passport::tokensCan([
            'purchase-product' => 'Crear Transacciones para comprar productos determinados',
            'manage-products'  => 'Crear, ver, actualizar y eliminar productos',
            'manage-account'   => 'Obtener la informacion de la cuenta,nombre, email, estado
                                    (Sin contraseña),modificar los datos como email.nombre y contraseña . NO se puede eliminar la cuenta',
            'read-general'     => 'Obtener la infromacion general, categorias donde se compra y se vende, productos vendidos
                                   o comprados,transacciones,compreas y ventas',
        ]);
    }
}
