// MODULE PATTERN - http://www.adequatelygood.com/JavaScript-Module-Pattern-In-Depth.html

// Page master class (inherit from this 'class' for every page)
var Page = (function() {

  /**
    * Called first, used to call the register_eventhandlers method
    */
  function init() {
    register_eventhandlers();
    AppDebug.print("Page init...");
  }

  /**
    * Disposes the page, stopping all intervals on the page
    */
  function dispose() {
    IntervalManager.stop_all();
    AppDebug.print("Page disposed...");
  }

  // Register any event handlers for the page here!
  function register_eventhandlers() {
    window.onbeforeunload = dispose;
    AppDebug.print("Page events registered...");
  }

  return {
    init: init,
    dispose: dispose,
    register_eventhandlers: register_eventhandlers
  };

} (Page || {}));

/**
  * Defines the serve page
  */
var Serve = (function(Page) {

  // Properties
  var durationIntervalHandle;
  var errorIntervalHandle;

  var syncAction = "";
  var syncToken = "";
  var syncScreen = 1;

  // Override init
  Page.init = function () {
    Page.register_eventhandlers(); // register required handlers

    // $('video').on('ended', function() {
    //   updateDurationInterval(2);
    // });

    sync_with_server(); // Sync!
  }

  //  Make AJAX request to server
  function sync_with_server() {
    // Source : http://learninglaravel.net/using-ajax-in-laravel/link

    // Stop the durtaion inverval before proceeding
    // this can cause duplicates if we sync after a run
    IntervalManager.stop(this.durationIntervalHandle);
    IntervalManager.stop(this.errorIntervalHandle);

    // Headers source: https://laravel.com/docs/master/routing#csrf-x-csrf-token
    // Required to prevent server 500 error
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': Serve.syncToken
      }
    });

    $.ajax({
      type: "POST",
      url : Serve.syncAction,
      data : {id: Serve.syncScreen},
      success : function(data){
        process_data(data);
      },
      error : function(xhr, textStatus, errorThrown) {
        //console.log(textStatus + " ------ " + errorThrown);
        startErrorWatch();
      }
    },"JSON");
  }

  // Data recieved process it
  function process_data(data) {
    AppDebug.print("Processing data...");

    if (data.playlist === undefined) {
      startErrorWatch();
      return;
    }


    // Shorten vars for easy coding
    var playlist = data.playlist;
    var adverts = data.adverts;
    var globalPlaylist = data.global;

    var current_advert_index = 0;// data[0].adverts[0].pivot.advert_index;
    var current_page_index = 0;// data[0].adverts[0].page[0].page_index;
    var max_advert_index = adverts.length - 1;
    var duration = 10;

    if (playlist !== undefined && playlist !== null)
    {
      if (max_advert_index >= 0) {
        duration = adverts[0].pages[0].template.duration; // Update per advert

        // Clear data
        localStorage.clear();

        // Save data to session
        localStorage.setItem('playlist', JSON.stringify(playlist));
        localStorage.setItem('adverts', JSON.stringify(adverts));
        localStorage.setItem('globalPlaylist', JSON.stringify(globalPlaylist));
        localStorage.setItem('current_advert_index', current_advert_index);
        localStorage.setItem('current_page_index', current_page_index);
        localStorage.setItem('showGlobal', 0);

        // Update the page after processing
        //update_page();
      } else {
        localStorage.setItem('globalPlaylist', JSON.stringify(globalPlaylist));
        localStorage.setItem('showGlobal', 1);
        localStorage.setItem('current_advert_index', 0);
        localStorage.setItem('current_page_index', 0);
        //update_page();
      }

    }

    updateDurationInterval(duration);

  }

  /**
    * If an error occurs attempt to recover
    * by syncing with the server every now and then
    */
  function startErrorWatch() {

    // Clean up
    if (this.errorIntervalHandle !== undefined) {
      IntervalManager.stop(this.errorIntervalHandle);
    }

    this.errorIntervalHandle = IntervalManager.add((4 * 1000), sync_with_server);

  }

  /**
    * Update the duration interval between showing pages
    * @param int duration length of interval
    */
  function updateDurationInterval(duration) {

    // Stop previous intervals
    stopDurationInterval();

    // Create a new duration interval
    this.durationIntervalHandle = IntervalManager.add((duration * 1000), update_page);

  }

  /**
    * Stops the current interval
    */
  function stopDurationInterval() {
    // If we already have an insterval stop it first
    if (this.durationIntervalHandle !== undefined) {
      IntervalManager.stop(this.durationIntervalHandle);
    }
  }

  // Data received update content
  function update_page() {

    AppDebug.print("Updating page");

    // Load flags from storage
    var showGlobal = localStorage.getItem('showGlobal');
    var current_advert_index = localStorage.getItem('current_advert_index');
    var current_page_index = localStorage.getItem('current_page_index');

    var currentAdvert = getCurrentAdvert(current_advert_index, showGlobal);

    if (currentAdvert !== null && currentAdvert !== undefined) {
      var max_advert_index = currentAdvert.length - 1;
      var max_page_index = currentAdvert.pages.length -1;

      if (current_page_index > max_page_index) { // Shown all pages?
        current_page_index = 0;

        current_advert_index++;
        currentAdvert = getCurrentAdvert(current_advert_index, showGlobal);

        if (currentAdvert === undefined || currentAdvert.pages.length == 0) { // Shown all adverts?
          current_advert_index = 0;

          if (showGlobal == 1) { // Show global?
            showGlobal = 0;
            sync_with_server(); // Sync as we've finished both playlists
            return; // Prevent further execution
          } else {
            showGlobal = 1;
            currentAdvert = getCurrentAdvert(0, showGlobal);
          }
        }
      }

      if (currentAdvert !== undefined && currentAdvert !== null) {

        if (currentAdvert.pages.length > 0) {

          if (currentAdvert.pages[current_page_index].page_data !== undefined) {
            if (currentAdvert.pages[current_page_index].page_data.video_path !== "") {

              stopDurationInterval();

              current_page_index = showPage(currentAdvert, current_page_index);

            } else {
              // Update the duration inverval for this page
              updateDurationInterval(currentAdvert.pages[current_page_index].template.duration);

              // Display page
              current_page_index = showPage(currentAdvert, current_page_index);
            }
          }

        }

      } else {
        showGlobal = 0;
        sync_with_server();
      }

      // Update current indexes
      localStorage.setItem('current_advert_index', current_advert_index);
      localStorage.setItem('current_page_index', current_page_index);
      localStorage.setItem('showGlobal', showGlobal);
    }
  }

  /**
    * Return the current advert
    * @param int index current advert index to pull
    * @param bool showGlobal, flag to determineif we should return a global advert
    */
  function getCurrentAdvert(index, showGlobal) {

    // Get adverts from storage
    var adverts = JSON.parse(localStorage.getItem('adverts'));
    var globalPlaylist = JSON.parse(localStorage.getItem('globalPlaylist'));
    var advert = null;

    if (adverts !== undefined && adverts !== null) {
      // Show global or screen playlist?
      if (showGlobal == 0) {
        advert = adverts[index];
      } else {
        advert =  globalPlaylist.adverts[index];
      }

    }

    return advert;
  }

  function reset($elem) {
    $elem.before($elem.clone(true));
    var $newElem = $elem.prev();
    $elem.remove();
    return $newElem;
} // end reset()

  /**
    * Update the DOM with a new page
    * @param object currentAdvert to show
    * @param int index of the current page to show
    */
  function showPage(currentAdvert, index) {

    // If we have data show it
    if (currentAdvert.pages[index].page_data !== undefined) {

      // Update page
      $('#serve_container').removeClass();
      $('#serve_container').addClass(currentAdvert.pages[index].template.class_name);
      $('[name="pageName"]').html(currentAdvert.pages[index].page_data.heading);
      $('[name="pageContent"]').html(currentAdvert.pages[index].page_data.content);

      //console.log(currentAdvert.background);
      if (currentAdvert.background.image_path != "") {
        $('body').css('background', 'url(../advert_backgrounds/' + currentAdvert.background.image_path + ')');
        $('body').css('background-size', 'cover');
      } else if (currentAdvert.background.hex_colour != "") {
        $('body').css('background', '#' + currentAdvert.background.hex_colour);
      } else {
        $('body').css('background', 'url(../advert_backgrounds/background_placeholder.png)');
        $('body').css('background-size', 'cover');
      }

      // Check if we have an image to display
      if (currentAdvert.pages[index].page_data.image_path !== "") {
        addImage();
        // Insert image
        $('#serve_image').children('img').attr('src', '../advert_images/' + currentAdvert.pages[index].page_data.image_path);
      } else {

        if (currentAdvert.pages[index].page_data.video_path !== "") {
          addVideo(updateDurationInterval, currentAdvert.pages[index].page_data.video_path);
        } else {
          addImage();
          $('#serve_container').animateCss(currentAdvert.pages[index].transition);
          // Insert logo image
          $('#serve_image').children('img').attr('src', '/images/image_placeholder.png' + currentAdvert.pages[index].page_data.image_path);
        }

      }
    }

    return ++index;

  }

  return Page;

} (Page || {}));

/**
  * Define the page editor functions
  */
var PageEditor = (function() {

  /**
    * Register event handlers
    */
  function register_eventhandlers() {

    // Update the title as it is keyed in
    $('input[name$="txtPageName"]').keyup(function() {
      $('[name$="pageName"]').html($(this).val());
    });

    // Update the content as it is keyed in
    $('[name$="txtPageContent"]').keyup(function() {
      $('[name$="pageContent"]').html($(this).val());
    });

    // Disable video upload if an image is uploaded
    $('[name=filPageImage]').on('change', function(evt) {
      if (this.value == "") {
        $('[name=filPageVideo]').prop('disabled', false);
      } else {
        //console.log("S");
        $('[name=filPageVideo]').prop('disabled', true);
      }
    });

    // Disable image upload if a video is uploaded
    $('[name=filPageVideo]').on('change', function(evt) {
      if (this.value == "") {
        $('[name=filPageImage]').prop('disabled', false);
      } else {
        //console.log("S");
        $('[name=filPageImage]').prop('disabled', true);
      }
    });

    $('li[data-btnTemplate="true"]').click(function() {
			$( '#serve_container, li[data-btnTemplate="true"]' ).removeClass(); // Remove all classes
			$(this).toggleClass('active'); // Toggle active

			var newTemplate = $(this).data('template');
			$('#serve_container').addClass(newTemplate);
			$('input[name="txtTemplate"]').val($(this).data('templateid'));

		});


  }

  function updateTransitions(transition) {

    var trans = transition.substring(0, transition.indexOf('I') + 2);
    var dir = transition.substring(transition.indexOf('I') + 2, transition.length);

    $('[name="drpTransitions"]').val(trans);
    $('[name="drpTransitionDirection"]').val(dir);

  }

  function init() {
    register_eventhandlers();
  }

  function dispose() {

  }

  return {
    init: init,
    dispose: dispose,
    register_eventhandlers: register_eventhandlers,
    updateTransitions: updateTransitions
  };

}());
