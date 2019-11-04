<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
/*         \DB::statement('truncate table category_product');
        \DB::table('category_product')->truncate();
        Category::truncate();
        Product::truncate();
        User::truncate();
        Transaction::truncate(); */
        // $this->call(UsersTableSeeder::class);
        $cantidadUsuarios       = 500;
        $cantidadCategories     = 50;
        $cantidadProducts       = 1000;
        $cantidadTransacciones  = 1000;

        factory(User::class,$cantidadUsuarios)->create();
        factory(Category::class,$cantidadCategories)->create();

        factory(Product::class,$cantidadTransacciones)->create()->each(
            function ($producto){
                $categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
                $producto->categories()->attach($categorias);
            }
        );
        factory(Transaction::class,$cantidadTransacciones)->create();
        Schema::enableForeignKeyConstraints();
    }
}
