var Page = {};

Page.serve = (function() {

  var syncInterval;

  function setup_interval() {
    syncInterval = window.setInterval(function () {
      //sync_with_server();
      alert("SYNC");
    }, 60000); // Check every minute
  }

  function destruct_intervals() {
    clearInterval(syncInterval);
  }

  //  Make AJAX request to server
  function sync_with_server() {
    // Source : http://learninglaravel.net/using-ajax-in-laravel/link
    $.post(
           $( this ).prop( 'action' ),
           {
               "_token": $( this ).find( 'input[name=_token]' ).val(),
               "setting_name": $( '#setting_name' ).val(),
               "setting_value": $( '#setting_value' ).val()
           },
           function( data ) {
               // Set all 'objects' to new value
           },
           'json'
       );
  }

  return {
    setup_interval: setup_interval,
		sync_with_server: sync_with_server,
    destruct_intervals: destruct_intervals
  };

} ());

Page.serve.template = (function() {

  function register_eventhandlers() {

    window.onbeforeunload = cleanupBeforeExit;

  }

  function cleanupBeforeExit()
  {
    Page.serve.destruct_intervals();
  }

  return {
    register_eventhandlers: register_eventhandlers,
  };

} ());
