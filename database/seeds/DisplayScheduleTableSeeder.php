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
        'name' => 'Any Time',
        'start_time' => '00:00:00',
        'end_time' => '00:00:00',
        'anyTime' => 1
      ]);

      $table->insert([
        'name' => '4am - 8am',
        'start_time' => '04:00:00',
        'end_time' => '08:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '8am - 12pm',
        'start_time' => '08:00:00',
        'end_time' => '12:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '10am - 12pm',
        'start_time' => '10:00:00',
        'end_time' => '12:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '10am - 2pm',
        'start_time' => '10:00:00',
        'end_time' => '14:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '2am - 4pm',
        'start_time' => '14:00:00',
        'end_time' => '16:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '4pm - 6pm',
        'start_time' => '16:00:00',
        'end_time' => '18:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '4pm - 8pm',
        'start_time' => '16:00:00',
        'end_time' => '20:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '6pm - 8pm',
        'start_time' => '18:00:00',
        'end_time' => '20:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '6pm - 10pm',
        'start_time' => '18:00:00',
        'end_time' => '22:00:00',
        'anyTime' => 0
      ]);

      $table->insert([
        'name' => '8pm - 10pm',
        'start_time' => '20:00:00',
        'end_time' => '22:00:00',
        'anyTime' => 0
      ]);
    }
}
