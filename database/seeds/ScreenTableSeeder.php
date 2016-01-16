<?php

use Illuminate\Database\Seeder;

class ScreenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('screen');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'department_id' => 1
      ]);
    }
}
