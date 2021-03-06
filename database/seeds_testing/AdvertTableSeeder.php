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
        'department_id' => 1, // Global
        'background_id' => 1
      ]);

      $table->insert([
        'name' => 'Library Generic',
        'department_id' => 2, // Library
        'background_id' => 1
      ]);

      $table->insert([
        'name' => 'DegreePlus Generic',
        'department_id' => 3, // DegreePlus
        'background_id' => 1
      ]);

      $table->insert([
        'name' => 'Library Advert Two',
        'department_id' => 2, // Library
        'background_id' => 1
      ]);
    }
}
