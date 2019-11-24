<?php

use App\User;
use App\Seller;
use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    return [
        'name'                  => $faker->name,
        'email'                 => $faker->unique()->safeEmail,
        'email_verified_at'     => now(),
        'password'              => $password ?: $password = bcrypt('secret'),
        'remember_token'        => Str::random(10),
        'verified'              => $verificado = $faker->randomElement([User::USUARIO_VERIFICADO,USER::USUARIO_NO_VERIFICADO]),
        'verification_token'    => $verificado == User::USUARIO_VERIFICADO ? null : User::generarVerificationToken(),
        'admin'                 => $faker->randomElement([USER::USUARIO_ADMINISTRADOR,USER::USUARIO_REGULAR])
    ];
});
$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' =>$faker->paragraph(1),
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name'        =>    $faker->word,
        'description' =>    $faker->paragraph(1),
        'quantity'    =>    $faker->numberBetween(1,10),
        'status'      =>    $faker->randomElement([Product::PRODUCTO_DISPONIBLE,Product::PRODUCTO_NO_DISPONIBLE]),
        'seller_id'   =>    User::all()->random()->id,
        'image'       =>    '1'
    ];
});

$factory->define(App\Transaction::class, function (Faker $faker) {
    $vendedor   =Seller::has('products')->get()->random();
    $comprador  =User::all()->except($vendedor->id)->random();
    return [
        //'name'        =>    $faker->word,
        'quantity'    =>    $faker->numberBetween(1,3),
        //'status'      =>    $faker->randomElement([Product::PRODUCTO_DISPONIBLE,Product::PRODUCTO_NO_DISPONIBLE]), 
        'buyer_id'    =>    $comprador->id,
        'product_id'  =>    $vendedor->products->random()->id,
    ];
});

