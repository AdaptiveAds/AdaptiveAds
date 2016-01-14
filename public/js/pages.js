// MODULE PATTERN - http://www.adequatelygood.com/JavaScript-Module-Pattern-In-Depth.html

var Page = {};
var Settings = {};
var IntervalManager = {};

// Define (global) settings here
Settings.debug = false;
Settings.syncInterval = 10000;
Settings.syncAction = "";
Settings.syncToken = "";
Settings.syncScreen = 1;

// Interval manager to create, store and remove window intervals
IntervalManager = (function() {

  var Intervals = [];

  // Add a new interval to the manager
  function add(delayInterval, callback) {

    // Grab an additional param used for passing data to the callback
    var callbackData = (arguments[2] !== undefined) ? arguments[2] : undefined;

    var newInterval = window.setInterval(function() {
        callback(callbackData); // pass data back works for functions without params
    }, delayInterval);

    // Save the interval handle
    Intervals.push(newInterval);

    if (Settings.debug == true) console.log('Stored intervals = ' + Intervals);

    // Return the handle just incase we want to stop a specific one later
    return newInterval;
  }

  // Stop a specific interval
  function stop(intervalHandle) {
    clearInterval(intervalHandle);
  }

  // Stop all intervals
  function stop_all() {
    for (index = 0; index < Intervals.index; count++) {
      clearInterval(Intervals[index])
    }
  }

  return {
    add: add,
    stop: stop,
    stop_all: stop_all
  };

} ());

Page.serve = (function() {

  var syncIntervalHandle;

  function init() {
    sync_with_server();
  }

  function dispose() {
    IntervalManager.stop_all();
  }

  //  Make AJAX request to server
  function sync_with_server() {
    // Source : http://learninglaravel.net/using-ajax-in-laravel/link

    // Headers source: https://laravel.com/docs/master/routing#csrf-x-csrf-token
    // Required to prevent server 500 error
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': Settings.syncToken
      }
    });

    $.ajax({
      type: "POST",
      url : Settings.syncAction,
      data : {id: Settings.syncScreen},
      success : function(data){
        if (Settings.debug == true) console.log(data)
        process_data(data);
      },
      error : function(xhr, textStatus, errorThrown) {
        alert(textStatus + " == " + errorThrown);
      }
    },"JSON");
  }

  // Data recieved process it
  function process_data(data) {

    if (Settings.debug == true) console.log("Processing data...");

    // Get lower and upper indexes
    var current_advert_index = 0;// data[0].adverts[0].pivot.advert_index;
    var current_page_index = 0;// data[0].adverts[0].page[0].page_index;
    var max_advert_index = 1;
    var max_page_index = 1;
    var duration = data[0].adverts[current_advert_index].page[current_page_index].template.duration;

    // Save data to session
    localStorage.setItem('playlist', data);
    localStorage.setItem('current_advert_index', current_advert_index);
    localStorage.setItem('current_page_index', current_page_index);
    localStorage.setItem('max_advert_index', max_advert_index);
    localStorage.setItem('max_page_index', max_page_index);

    // Set up an interval to keep syncing with the server
    syncIntervalHandle = IntervalManager.add((duration * 1000),
                                            update_page_content, data);

  }

  // Data received update content
  function update_page_content(data) {

    if (Settings.debug == true) console.log("Updating page");

    var current_advert_index = localStorage.getItem('current_advert_index');
    var current_page_index = localStorage.getItem('current_page_index');
    var max_advert_index = localStorage.getItem('max_advert_index');
    var max_page_index = localStorage.getItem('max_page_index');

    //current_advert_index++; REVIEW need this??
    current_page_index++;

    // Have we reached the end of the
    if (current_advert_index > max_advert_index) {current_advert_index = 0;}
    if (current_page_index > max_page_index) {current_page_index = 0;}

    // Update page
    $('h1').html(data[0].adverts[current_advert_index].page[current_page_index].page_data.page_data_name);
    $('#page_content').html(data[0].adverts[current_advert_index].page[current_page_index].page_data.page_content);

    // Update current indexes
    localStorage.setItem('current_advert_index', current_advert_index);
    localStorage.setItem('current_page_index', current_page_index);
  }

  return {
    init: init,
    dispose: dispose,
		sync_with_server: sync_with_server
  };

} ());

Page.serve.template = (function() {

  function register_eventhandlers() {

    window.onbeforeunload = cleanupBeforeExit;

  }

  function cleanupBeforeExit()
  {
    Page.serve.dispose();
  }

  return {
    register_eventhandlers: register_eventhandlers,
  };

} ());
