<?php

use Illuminate\Database\Seeder;

class DurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('duration');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'low' => 1,
        'medium' => 1,
        'high' => 1
      ]);
    }
}
