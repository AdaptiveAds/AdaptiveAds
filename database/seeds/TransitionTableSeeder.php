<?php

use Illuminate\Database\Seeder;

class TransitionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('Transition');

        //Empty table
        $table->delete();

        //Populate table
        $table->insert([
          'Transition_Name' => 'fade'
        ]);
    }
}
