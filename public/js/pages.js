// MODULE PATTERN - http://www.adequatelygood.com/JavaScript-Module-Pattern-In-Depth.html

// Page master class (inherit from this 'class' for every page)
var Page = (function() {

  function init() {
    register_eventhandlers();
    AppDebug.print("Page init...");
  }

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

var Serve = (function(Page) {

  var syncIntervalHandle;

  var syncInterval = 10000;
  var syncAction = "";
  var syncToken = "";
  var syncScreen = 1;

  // Override init
  Page.init = function () {
    Page.register_eventhandlers(); // register required handlers
    sync_with_server(); // Sync!
  }

  //  Make AJAX request to server
  function sync_with_server() {
    // Source : http://learninglaravel.net/using-ajax-in-laravel/link

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
        console.log(textStatus + " ------ " + errorThrown);
      }
    },"JSON");
  }

  // Data recieved process it
  function process_data(data) {
    AppDebug.print("Processing data...");

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

    AppDebug.print("Updating page");

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

  return Page;

} (Page || {}));
