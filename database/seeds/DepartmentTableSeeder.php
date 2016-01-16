<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('department');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Library',
        'location_id' => 1,
        'skin_id' => 1
      ]);
    }
}
