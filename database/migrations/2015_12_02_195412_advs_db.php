<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdvsDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template', function (Blueprint $table) {
				    $table->engine = 'InnoDB';
        		$table->increments('id');
        		$table->string('name', 40);
        		$table->string('class_name', 50);
        		$table->integer('duration');
            $table->boolean('deleted');
        	});

        Schema::create('page_data', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('heading', 20);
            $table->text('content');
            $table->text('image_path');
            $table->text('image_meta');
            $table->text('video_path');
            $table->text('video_meta');
            $table->boolean('deleted');
          });

        Schema::create('display_schedule', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->DateTime('start_date');
            $table->DateTime('end_date');
          });

        Schema::create('skin', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 30);
            $table->string('class_name', 30);
            $table->boolean('deleted');
          });

        Schema::create('privilage', function (Blueprint $table) {
			       $table->engine = 'InnoDB';
			       $table->increments('id');
			       $table->integer('level');
             $table->string('name', 20);
          });

        Schema::create('user', function (Blueprint $table) {
			       $table->engine = 'InnoDB';
             $table->increments('id');
             $table->string('username', 40)->unique();
             $table->string('password', 60);
             $table->boolean('is_super_user');
             $table->rememberToken();
             $table->boolean('deleted');
          });

        Schema::create('display_timing', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->time('display_time');
            $table->integer('display_schedule_id')->unsigned();
            $table->foreign('display_schedule_id')
                	->references('id')
                	->on('display_schedule')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('department', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
          	$table->string('name', 40);
            $table->boolean('deleted');
            $table->integer('skin_id')->unsigned();
            $table->foreign('skin_id')
                	->references('id')
                	->on('skin')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('location', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 40);
            $table->integer('department_id')->unsigned();
            $table->boolean('deleted');
            $table->foreign('department_id')
                	->references('id')
                	->on('department')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('advert', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 40);
            $table->integer('index');
            $table->boolean('deleted');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')
          	      ->references('id')
          			  ->on('department')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
          });

        Schema::create('playlist', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->boolean('isGlobal');
            $table->boolean('deleted');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')
          	      ->references('id')
          			  ->on('department')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
          });

        Schema::create('screen', function (Blueprint $table) {
			        $table->engine = 'InnoDB';
              $table->increments('id');
              $table->integer('location_id')->unsigned();
              $table->integer('playlist_id')->unsigned();
              $table->foreign('location_id')
                  	->references('id')
              			->on('location')
              	  	->onUpdate('cascade')
              	  	->onDelete('cascade');
              $table->foreign('playlist_id')
                  	->references('id')
              			->on('playlist')
              	  	->onUpdate('cascade')
              	  	->onDelete('cascade');
              $table->boolean('deleted');
          });

        Schema::create('advert_playlist', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
			      $table->integer('playlist_id')->unsigned();
			      $table->integer('advert_id')->unsigned();
            $table->primary(array('playlist_id','advert_id'));
          	$table->integer('display_schedule_id')->unsigned();
            $table->integer('advert_index');
            $table->foreign('playlist_id')
            	  	->references('id')
            			->on('playlist')
            	  	->onUpdate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('advert_id')
                	->references('id')
                	->on('advert')
                	->onUpdate('cascade')
                	->onDelete('cascade');
            $table->foreign('display_schedule_id')
                	->references('id')
                	->on('display_schedule')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('page', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
			      $table->increments('id');
			      $table->integer('page_data_id')->unsigned();
			      $table->integer('advert_id')->unsigned();
            $table->integer('template_id')->unsigned();
            $table->integer('page_index');
            $table->boolean('deleted');
            $table->foreign('page_data_id')
          	      ->references('id')
          			  ->on('page_data')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
            $table->foreign('advert_id')
                	->references('id')
                	->on('advert')
                	->onUpdate('cascade')
                	->onDelete('cascade');
            $table->foreign('template_id')
                	->references('id')
                	->on('template')
                	->onUpdate('cascade')
                	->onDelete('cascade');
        	});

        Schema::create('department_user', function (Blueprint $table) {
      			$table->engine = 'InnoDB';
      			$table->integer('user_id')->unsigned();
      			$table->integer('department_id')->unsigned();
      			$table->primary(array('user_id','department_id'));
      			$table->integer('privilage_id')->unsigned();
      			$table->foreign('department_id')
                  ->references('id')
                  ->on('department')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
      			$table->foreign('user_id')
          				->references('id')
          				->on('user')
          				->onUpdate('cascade')
          				->onDelete('cascade');
      			$table->foreign('privilage_id')
                  ->references('id')
                  ->on('privilage')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
          });

        Schema::create('password_resets', function(Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('password_resets', 'department_user',
                     'page', 'advert_playlist',
                     'screen', 'playlist',
                     'advert', 'location',
                     'department', 'display_timing',
                     'user', 'privilage',
                     'skin', 'display_schedule',
                     'page_data', 'template');
    }
}
