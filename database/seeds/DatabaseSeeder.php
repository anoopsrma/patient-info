<?php

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
        // $this->call(UsersTableSeeder::class);
        // $user = factory(App\User::class)->create();
        for ($i=0; $i < 10; $i++) {
            // $stock = factory(App\Stock::class)->create();
            $patient = factory(App\Patient::class)->create();
        }
    }
}
