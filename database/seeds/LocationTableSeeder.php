<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('location');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Park Library',
        'department_id' => 2
      ]);

      $table->insert([
        'name' => 'Park Reception',
        'department_id' => 3
      ]);
    }
}
