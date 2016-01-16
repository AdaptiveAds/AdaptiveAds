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
