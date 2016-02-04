<?php

use Illuminate\Database\Seeder;

class AdvertTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('advert');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Global',
        'deleted' => 0,
        'department_id' => 1 // Global
      ]);

      $table->insert([
        'name' => 'Library Generic',
        'deleted' => 0,
        'department_id' => 2 // Library
      ]);

      $table->insert([
        'name' => 'DegreePlus Generic',
        'deleted' => 0,
        'department_id' => 3 // DegreePlus
      ]);

      $table->insert([
        'name' => 'Library Advert Two',
        'deleted' => 0,
        'department_id' => 2 // Library
      ]);
    }
}
