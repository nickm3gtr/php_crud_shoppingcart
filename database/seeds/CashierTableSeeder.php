<?php

use Illuminate\Database\Seeder;

class CashierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Cashier::class, 5)->create();
    }
}
