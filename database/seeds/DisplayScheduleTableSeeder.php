<?php

use Illuminate\Database\Seeder;

class DisplayScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('display_schedule');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'start_date' => \Carbon\Carbon::now()->toDateTimeString(),
        'end_date' => \Carbon\Carbon::now()->toDateTimeString()
      ]);
    }
}
