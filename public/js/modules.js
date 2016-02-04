var AppDebug = (function() {

  var debug = false;

  // Print a message to the console if we are debugging
  function print(message) {
    if (debug == true ) console.log(message);
  }

  return {
    print: print
  };

} ());

// Interval manager to create, store and remove window intervals
var IntervalManager = (function() {

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

    AppDebug.print('Stored intervals = ' + Intervals);

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

var SelectManager = (function() {

  var action = "";
  var token = "";

  function register_eventhandlers() {
    $('.advertItem').click(function() {
       $('.pagecontainer li').removeClass('selected');
       $(this).toggleClass('selected');
    });

    $('#btnUp').click(function() {

        $('.selected').insertBefore($('.selected').prev('li'));

        var newIndex = $('.selected').index();
        var effectedID = $('.selected').next('li').attr('data-itemID');
        var itemID = $('.selected').attr('data-itemID');

        var effectedIndex = newIndex + 1;

        updateIndexes(itemID, effectedID, newIndex, effectedIndex);
    });

    $('#btnDown').click(function() {
        $('.selected').insertAfter($('.selected').next('li'));

        var newIndex = $('.selected').index();
        var effectedID = $('.selected').prev('li').attr('data-itemID');
        var itemID = $('.selected').attr('data-itemID');

        var effectedIndex = newIndex - 1;

        updateIndexes(itemID, effectedID, newIndex, effectedIndex);
    });
  }

  function updateIndexes(itemID, effectedID, newIndex, effectedIndex) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': SelectManager.token
      }
    });

    $.ajax({
      type: "POST",
      url : SelectManager.action,
      data : {'itemID': itemID, 'effectedID': effectedID, 'newIndex': newIndex, 'effectedIndex': effectedIndex},
      success : function(data){
        // Do nothing...
      },
      error : function(xhr, textStatus, errorThrown) {
        console.log(textStatus + " ------ " + errorThrown);
      }
    },"JSON");
  }

  return {
    register_eventhandlers: register_eventhandlers
  };

} ());
