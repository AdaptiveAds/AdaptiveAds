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

    AppDebug.print('Stored interval ids = ' + Intervals);

    // Return the handle just incase we want to stop a specific one later
    return newInterval;
  }

  // Stop a specific interval
  function stop(intervalHandle) {
    clearInterval(intervalHandle);
    var index = Intervals.indexOf(intervalHandle);
    Intervals.splice(index, 1);
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
    $('li[data-selectableItem="true"], [data-selectableItem="true"]').click(function() {

       // Remove selected from all links
       $('ul[data-selectableList="true"] li a').removeClass('selected');

       if ($(this).is(':checked')) {

         // Apply selected to inner link
         if ($(this).parent().is('li')) {
           $(this).children('a').toggleClass('selected');
         } else {
           $(this).parent('a').toggleClass('selected');
         }

         // Un-check all checkboxes except this one
         $('input:checkbox').not(this).removeAttr('checked');

         // Enable buttons
         $('#btnUp').removeAttr('disabled');
         $('#btnDown').removeAttr('disabled');

       } else {
         // Disable buttons
         $('#btnUp').attr('disabled', true);
         $('#btnDown').attr('disabled', true);
       }
    });

    $('#btnUp').click(function() {
        var parentLi = $('.selected').parent();
        parentLi.insertBefore(parentLi.prev('li'));

        var newIndex = parentLi.index();
        var effectedID = parentLi.next('li').attr('data-itemID');
        var itemID = parentLi.attr('data-itemID');

        var effectedIndex = newIndex + 1;

        updateIndexes(itemID, effectedID, newIndex, effectedIndex);
    });

    $('#btnDown').click(function() {
        var parentLi = $('.selected').parent();
        parentLi.insertAfter(parentLi.next('li'));

        var newIndex = parentLi.index();
        var effectedID = parentLi.prev('li').attr('data-itemID');
        var itemID = parentLi.attr('data-itemID');

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

// From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Iterators_and_Generators
function makeIterator(array){
    var nextIndex = 0;
    var length = array.length;

    return {
       next: function() {
           return nextIndex < length ?
               {value: array[nextIndex++], done: false} :
               {done: true};
       },

       get: function(index) {
         return index < length ?
              {value: array[index], done: false} :
              {value: null}
       },

       startPos: function(index) {
         nextIndex = index;
       },

       getIndex: function() {
         return nextIndex;
       },

       done: function() {
         return nextIndex < length ?
            false : true;
       }
    }
}

var ModalManager = (function() {

  var token = "";
  var action = "";

  function register_eventhandlers() {

    $('[data-displayEditModal="true"]').click(function() {

      showLoading();
      //console.log($('.modal_content'));

      var selected = $(this);
      var id = selected.attr('data-userID');
      var object = selected.attr('data-modalObject');
      switch(object) {
        case 'Users':
          getData(id, users);
      }

      //getData($(this).attr('data-userID'), $(this).attr('data-modalObject') + '();');
      $('[name="heading"]').html('Edit User');
      $('#' + $(this).attr('data-modalObject') + 'Modal').find('form').attr('action', $(this).attr('data-modalRoute'));
    });

    $('[data-displayCreateModal="true"]').click(function() {

      showData();

      clearInput();
      $('[name="heading"]').html('Create New User');
      $('#' + $(this).attr('data-modalObject') + 'Modal').find('form').attr('action', $(this).attr('data-modalRoute'));
    });

  }

  function clearInput() {
    $('input').val('');
    $('input').removeAttr('checked');
  }

  function users(data) {
    $('[name="txtUsername"]').val(data.user.username);

    if (data.user.is_super_user) {
      $('[name="chkIsSuper"]').attr('checked', true);
    }
  }

  function getData(id, callback) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': ModalManager.token
      }
    });

    $.ajax({
      type: "GET",
      url : '/dashboard/settings/users/1',
      data : {'id': id},
      success : function(data){
        showData();
        callback(data);
      },
      error : function(xhr, textStatus, errorThrown) {
        console.log("JJJJ");
        showErrors();
        $('[name="errorMsg"]').html(errorThrown);
      }
    },"JSON");
  }

  function showLoading() {
    $('.loading').removeClass('hidden');
    $('.modal_content').addClass('hidden');
    $('.errors').addClass('hidden');
  }

  function showData() {
    $('.modal_content').removeClass('hidden');
    $('.loading').addClass('hidden');
    $('.errors').addClass('hidden');
  }

  function showErrors() {
    $('.errors').removeClass('hidden');
    $('.loading').addClass('hidden');
    $('.modal_content').addClass('hidden');
  }

  return {
    register_eventhandlers: register_eventhandlers
  };

} ());
