<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('user');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'username' => 'dev',
        'password' => '$2y$10$IHB0vBYdK99TJWtSDasqEecVYr.hX7Od4WZeUFwSH6i.O0Hucqnzm',
        'is_super_user' => 1
      ]);

      $table->insert([
        'username' => 'paul',
        'password' => '$2y$10$IHB0vBYdK99TJWtSDasqEecVYr.hX7Od4WZeUFwSH6i.O0Hucqnzm',
        'is_super_user' => 1
      ]);

      $table->insert([
        'username' => 'admin',
        'password' => '$2y$10$IHB0vBYdK99TJWtSDasqEecVYr.hX7Od4WZeUFwSH6i.O0Hucqnzm',
        'is_super_user' => 0
      ]);

      $table->insert([
        'username' => 'user',
        'password' => '$2y$10$IHB0vBYdK99TJWtSDasqEecVYr.hX7Od4WZeUFwSH6i.O0Hucqnzm',
        'is_super_user' => 0
      ]);
    }
}
