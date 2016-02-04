<?php

use Illuminate\Database\Seeder;

class DepartmentUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('department_user');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'user_id' => 1, // Dev
        'department_id' => 2, // Library
        'privilage_id' => 1
      ]);

      $table->insert([
        'user_id' => 3, // Admin
        'department_id' => 2, // Library
        'privilage_id' => 1
      ]);

      $table->insert([
        'user_id' => 3, // Admin
        'department_id' => 3, // DegreePlus
        'privilage_id' => 1
      ]);

      $table->insert([
        'user_id' => 4, // User
        'department_id' => 2, // Library
        'privilage_id' => 2
      ]);

      $table->insert([
        'user_id' => 4,
        'department_id' => 3, // DegreePlus
        'privilage_id' => 2
      ]);
    }
}
