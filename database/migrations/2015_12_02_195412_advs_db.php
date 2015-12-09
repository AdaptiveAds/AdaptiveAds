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
        //
        Schema::create('Transition', function (Blueprint $table) {
        		$table->increment('Transition_ID');
        		$table->string('Transition_Name', 20);
        	});
        Schema::create('Duration', function (Blueprint $table) {
        		$table->increment('Duration_ID');
        		$table->integer('Duration_Time');
        	});
        Schema::create('Template', function (Blueprint $table) {
        		$table->increment('Template_ID');
        		$table->string('Template_Name', 20);
        		$table->boolean('Template_Overrides_Skin');
        		$table->integer('Duration_ID')->unsigned();
        		$table->integer('Transition_ID')->unsigned();
            $table->boolean('Is_Vertical');
        		$table->foreign('Duration_ID')
        			  	->reference('Duration_ID')
        				  ->on('Duration')
        			  	->onUpdeate('cascade')
        			  	->onDelete('cascade');
        		$table->foreign('Transition_ID')
        		  		->reference('Transition_ID')
        		  		->on('Transition')
        			  	->onUpdeate('cascade')
        			  	->onDelete('cascade');
        	});
        Schema::create('Horizontal_Template', function (Blueprint $table) {
            $table->increment('Horizontal_ID');
            $table->integer('Template_ID')->unsigned();
            $table->foreign('Template_ID')
        		  		->reference('Template_ID')
        		  		->on('Template')
        			  	->onUpdeate('cascade')
        			  	->onDelete('cascade');
          });
        Schema::create('Vertical_Template', function (Blueprint $table) {
            $table->increment('Vertical_ID');
            $table->integer('Template_ID')->unsigned();
            $table->foreign('Template_ID')
          	  		->reference('Template_ID')
          	  		->on('Template')
          		  	->onUpdeate('cascade')
          		  	->onDelete('cascade');
          });
        Schema::create('Advert', function (Blueprint $table) {
            $table->increment('Advert_ID');
            $table->string('Advert_Name', 20);
            $table->boolean('Advert_Deleted');
          });
        Schema::create('Page_Data', function (Blueprint $table) {
            $table->increment('Page_Data_ID');
            $table->string('Page_Data_Name', 20);
            $table->string('Page_Image');
            $table->string('Page_Video');
            $table->string('Page_Content');
          });
        Schema::create('Page', function (Blueprint $table) {
        	  $table->increment('Page_ID');
        	  $table->integer('Page_Data_ID')->unsigned();
        		$table->integer('Page_Index');
        		$table->integer('Advert_ID')->unsigned();
            $table->integer('Vertical_ID')->unsigned();
            $table->integer('Horizontal_ID')->unsigned();
          	$table->boolean('Deleted');
            $table->foreign('Page_Data_ID')
          	  		->reference('Page_Data_ID')
          	  		->on('Page_Data')
          		  	->onUpdeate('cascade')
          		  	->onDelete('cascade');
            $table->foreign('Advert_ID')
                	->reference('Advert_ID')
                	->on('Advert')
                	->onUpdeate('cascade')
                	->onDelete('cascade');
            $table->foreign('Vertical_ID')
                  ->reference('Vertical_ID')
                  ->on('Vertical_Template')
                  ->onUpdeate('cascade')
                  ->onDelete('cascade');
            $table->foreign('Horizontal_ID')
                	->reference('Horizontal_ID')
                	->on('Horizontal_Template')
                	->onUpdeate('cascade')
                	->onDelete('cascade');
        	});
        Schema::create('Display_Timing', function (Blueprint $table) {
            $table->increment('Display_Timing_ID');
            $table->DateTime('Start_Date');
            $table->DateTime('End_Date');
          });
        Schema::create('Playlist', function (Blueprint $table) {
            $table->increment('Playlist_ID');
            $table->DateTime('Playlist_Name');
            $table->DateTime('Deleted');
          });
        Schema::create('Playlist_Advert', function (Blueprint $table) {
            $table->primary('Playlist_ID')->unsigned();
          	$table->primary('Advert_ID')->unsigned();
          	$table->integer('Advert_Index');
          	$table->integer('Display_Timing_ID')->unsigned();
            $table->foreign('Playlist_ID')
            	  	->reference('Playlist_ID')
            			->on('Playlist')
            	  	->onUpdeate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('Advert_ID')
                	->reference('Advert_ID')
                	->on('Advert')
                	->onUpdeate('cascade')
                	->onDelete('cascade');
            $table->foreign('Display_Timing_ID')
                	->reference('Display_Timing_ID')
                	->on('Display_Timing')
                	->onUpdeate('cascade')
                	->onDelete('cascade');
          });
        Schema::create('Skin', function (Blueprint $table) {
            $table->increment('Skin_ID');
            $table->string('Skin_Name', 20);
          });
        Schema::create('Location', function (Blueprint $table) {
            $table->increment('Location_ID');
          	$table->string('Location_Name', 20);
          	$table->integer('Parent_Location');
          	$table->integer('Skin_ID')->unsigned();
            $table->integer('Playlist_ID')->unsigned();
            $table->foreign('Playlist_ID')
                	->reference('Playlist_ID')
            			->on('Playlist')
            	  	->onUpdeate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('Skin_ID')
                	->reference('Skin_ID')
                	->on('Skin')
                	->onUpdeate('cascade')
                	->onDelete('cascade');
          });
        Schema::create('Screen', function (Blueprint $table) {
              $table->increment('Screen_ID');
              $table->boolean('Is_Vertical');
              $table->integer('Location_ID')->unsigned();
              $table->foreign('Location_ID')
                  	->reference('Location_ID')
              			->on('Location')
              	  	->onUpdeate('cascade')
              	  	->onDelete('cascade');
          });
        Schema::create('User', function (Blueprint $table) {
             $table->increment('User_ID');
             $table->string('Username', 20);
             $table->string('Password', 20);
          });
        Schema::create('Privilage', function (Blueprint $table) {
             $table->increment('Privilage_ID');
             $table->string('Privilage_Level', 20);
          });
        Schema::create('User_Location', function (Blueprint $table) {
              $table->primary('User_ID')->unsigned();
              $table->primary('Location_ID')->unsigned();
              $table->integer('Privilage_ID')->unsigned();
              $table->foreign('Location_ID')
                  	->reference('Location_ID')
                		->on('Location')
                  	->onUpdeate('cascade')
              	  	->onDelete('cascade');
              $table->foreign('User_ID')
                    ->reference('User_ID')
                    ->on('User')
                    ->onUpdeate('cascade')
                    ->onDelete('cascade');
              $table->foreign('Privilage_ID')
                  	->reference('Privilage_ID')
                		->on('Privilage')
                  	->onUpdeate('cascade')
              	  	->onDelete('cascade');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Transition', 'Duration', 'Template',
                     'Horizontal_Template', 'Vertical_Template',
                     'Advert', 'Page_Data', 'Page', 'Display_Timing',
                     'Playlist', 'Playlist_Advert', 'Skin', 'Location',
                     'Screen', 'User', 'Privilage', 'User_Location');
    }
}
