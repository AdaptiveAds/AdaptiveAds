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
            $table->string('thumbnail_path', 255);
        	});

        Schema::create('page_data', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('heading');
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
            $table->string('name');
            $table->Time('start_time');
            $table->Time('end_time');
            $table->boolean('anyTime');
          });

        Schema::create('background', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 40);
            $table->string('image_path', 255);
            $table->string('hex_colour', 6);
          });

        Schema::create('user', function (Blueprint $table) {
			       $table->engine = 'InnoDB';
             $table->increments('id');
             $table->string('username', 40)->unique();
             $table->string('password', 60);
             $table->boolean('is_super_user');
             $table->rememberToken();
          });

        Schema::create('department', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
          	$table->string('name', 40);
          });

        Schema::create('location', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 40);
            $table->integer('department_id')->unsigned();
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
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')
          	      ->references('id')
          			  ->on('department')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
            $table->integer('background_id')->unsigned();
            $table->foreign('background_id')
                	->references('id')
                	->on('background')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('playlist', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->boolean('isGlobal');
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
          });

        Schema::create('advert_schedule', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->integer('playlist_id')->unsigned();
          $table->integer('advert_id')->unsigned();
          $table->primary(array('playlist_id','advert_id'));
          $table->integer('schedule_id')->unsigned();
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
          $table->foreign('schedule_id')
                ->references('id')
                ->on('display_schedule')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('advert_playlist', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
			      $table->integer('playlist_id')->unsigned();
			      $table->integer('advert_id')->unsigned();
            $table->primary(array('playlist_id','advert_id'));
            $table->integer('advert_index');
            $table->foreign('playlist_id')
            	  	->references('id')
            			->on('playlist')
            	  	->onUpdate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('advert_id')
                	->references('id')
                	->on('advert')
                	->onUpdate('cascade');
          });

        Schema::create('page', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
			      $table->increments('id');
			      $table->integer('page_data_id')->unsigned();
			      $table->integer('advert_id')->unsigned();
            $table->integer('template_id')->unsigned();
            $table->integer('page_index');
            $table->string('transition', 13);
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
      			$table->boolean('is_admin');
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
                     'user',
                     'background', 'display_schedule',
                     'page_data', 'template');
    }
}
