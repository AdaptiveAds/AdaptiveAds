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
      $table = DB::table('Duration');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'Duration_Time' => 1,
      ]);
    }
}
