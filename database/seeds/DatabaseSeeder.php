<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TemplateTableSeeder::class);
        $this->call(AdvertTableSeeder::class);
        $this->call(PageDataTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(DisplayScheduleTableSeeder::class);
        $this->call(PlaylistTableSeeder::class);
        $this->call(AdvertPlaylistTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(SkinTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(ScreenTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PrivilageTableSeeder::class);
        $this->call(DepartmentUserTableSeeder::class);

        Model::reguard();
    }
}
