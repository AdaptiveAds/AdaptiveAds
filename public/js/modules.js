/**
  * Debug logger to print debug messages through out the application
  */
var AppDebug = (function() {

  // Set to true to enable logging
  var debug = false;

  // Print a message to the console if we are debugging
  function print(message) {
    if (debug == true ) console.log(message);
  }

  // Expose methods
  return {
    print: print
  };

} ());

/**
  * Interval manager to create, store and remove window intervals
  */
var IntervalManager = (function() {

  var Intervals = [];

  /**
    * Add an interval
    * @param int @delayInterval duration of interval
    * @param func callback function to call when interval ticks over
    * @return handle Interval handle/pointer
    */
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

  /**
    * Stops a specified interval
    * @param handle/pointer Interval handle to stop
    */
  function stop(intervalHandle) {
    clearInterval(intervalHandle);
    var index = Intervals.indexOf(intervalHandle);
    Intervals.splice(index, 1);
  }

  /**
    * Stops all intervals
    */
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

/**
  * Select Manager controls selecting of list items
  * and their ids to be compiled as an array to send via AJAX
  */
var SelectManager = (function() {

  // Properties
  var action = "";
  var token = "";
  var multi = false;
  var adverts = [];

  /**
    * Registers required event handlers
    */
  function register_eventhandlers() {

    // Un-check all checkboxes
    $('input:checkbox').removeAttr('checked');

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    // Listen for clicks on selectable items
    $('li[data-selectableItem="true"], [data-selectableItem="true"]').click(function() {

       if (SelectManager.multi == false) {

         // Remove selected from all links
         $('ul[data-selectableList="true"] li a').removeClass('selected');

         // Un-check all checkboxes except this one
         $('input:checkbox').not(this).removeAttr('checked');
       }

       if ($(this).is(':checked')) {

         // Apply selected to inner link
         if ($(this).parent().is('li')) {
           $(this).children('a').toggleClass('selected');
         } else {
           $(this).parent('a').toggleClass('selected');
         }

         $(this).trigger('selected');

       } else {

         $(this).parent('a').removeClass('selected');
         $(this).trigger('deselected');
       }
    });


  }

  /**
    * Return the selected items as an array
    * @return array of selected items/ids
    */
  function getSelected() {
    var objects = [];
    $('[data-selectableItem="true"]:checked').each(function() {
      objects.push($(this).parents('li').data('itemid'));
    });

    return objects;
  }

  return {
    register_eventhandlers: register_eventhandlers,
    getSelected: getSelected
  };

} ());

/**
  * Extensions of the select manager to collect
  * selected objects then send a add or remove
  */
var ObjectAssign = (function() {

  // Properties
  var token = "";
  var action = "";
  var extra = null;

  /**
    * Register required event callbacks
    * @param func callback to call after registration
    */
  function register_eventhandlers(callback) {

    // Listen for add click
    $('button[name="btnAdd"]').click(function() {

      update('add', SelectManager.getSelected());

    });

    // Listen for remove click
    $('button[name="btnRemove"]').click(function() {

      update('remove', SelectManager.getSelected());

    });

    // Process any post registration logic
    // Used to add custom event listeners on the pages
    if (callback !== undefined) {
      callback();
    }

  }

  /**
    * Redirect browser
    * @param string path to redirect uri
    */
  function redirect(path) {
    window.location.href = path;
  }

  /**
    * Sends a AJAX request with array of list items
    * @param string mode to perform (add or remove object)
    * @param array of objects to update
    */
  function update(mode, objects) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': ObjectAssign.token
      }
    });

    $.ajax({
      type: "POST",
      url : ObjectAssign.action,
      data : {'mode': mode, 'arrObjects': objects, 'extra': ObjectAssign.extra},
      success : function(data){
        if (data.failed === undefined) {
          redirect(data.redirect); // Redirect
        } else {
          // Failed inform the user
          $('[name="errorMsg"]').html(data.message);
          $('.errors').removeClass('hidden');
          window.location.href = '#ErrorModal';

          $('.close').on('modalClosed', function() {
            redirect(data.redirect);
          });
        }
      },
      error : function(xhr, textStatus, errorThrown) {
        // Do nothing
      }
    },"JSON");
  }

  return {
    register_eventhandlers: register_eventhandlers,
  };

} ());

/**
  * Index updater handles updating the advert page indexes
  */
var IndexUpdater = (function() {

  // Proerties
  var token = "";
  var action = "";

  /**
    * Register event listeners
    */
  function register_eventhandlers() {

    $('[data-selectableItem="true"]').on('selected', function() {
      // Enable buttons
      $('#btnUp').removeAttr('disabled');
      $('#btnDown').removeAttr('disabled');
    });

    $('[data-selectableItem="true"]').on('deselected', function() {
      // Disable buttons
      $('#btnUp').attr('disabled', true);
      $('#btnDown').attr('disabled', true);
    });

    $('#btnUp').click(function() {
        var parentLi = $('.selected').parent();
        parentLi.insertBefore(parentLi.prev('li'));

        // Collect index info
        var newIndex = parentLi.index();
        var effectedID = parentLi.next('li').attr('data-itemID');
        var itemID = parentLi.attr('data-itemID');

        var effectedIndex = newIndex + 1;

        updateIndexes(itemID, effectedID, newIndex, effectedIndex);
    });

    $('#btnDown').click(function() {
        var parentLi = $('.selected').parent();
        parentLi.insertAfter(parentLi.next('li'));

        // Collect index info
        var newIndex = parentLi.index();
        var effectedID = parentLi.prev('li').attr('data-itemID');
        var itemID = parentLi.attr('data-itemID');

        var effectedIndex = newIndex - 1;

        updateIndexes(itemID, effectedID, newIndex, effectedIndex);
    });
  }

  /**
    * Update indexes via AJAX
    * @param int itemID Id of the selected item to update
    * @param int effectID Id of the item replaced by the selected item
    * @param int newIndex new selected item index
    * @param int effectedIndex new index for the effected item
    */
  function updateIndexes(itemID, effectedID, newIndex, effectedIndex) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': IndexUpdater.token
      }
    });

    $.ajax({
      type: "POST",
      url : IndexUpdater.action,
      data : {'itemID': itemID, 'effectedID': effectedID, 'newIndex': newIndex, 'effectedIndex': effectedIndex},
      success : function(data){
        // Redirect if available
        if (data.redirect !== undefined || data.redirect !== null) {
          window.location.href = data.redirect;
        }
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

/**
  * Modal manager to control the lifetime of a modal dialog
  */
var ModalManager = (function() {

  // Properties
  var token = "";
  var action = "";

  /**
    * Register event listeners
    */
  function register_eventhandlers() {

    // Listen for an display edit modal click
    $('[data-displayEditModal="true"]').click(function() {

      showLoading();
      clearInput();

      // Setup the modal
      setup($(this), "Edit");

      var id = $(this).attr('data-userID');
      var object = $(this).attr('data-modalObject');

      // Search for our function def
      var fn = window["ModalManager"][object.toLowerCase()];

      // If it is not a function cancel the process
      if (typeof fn !== "function")
        return;

      // Go AJAX the data
      getData(id, fn);
    });

    // Listen for a display create modal
    $('[data-displayCreateModal="true"]').click(function() {

      showData();
      clearInput();

      var selected = $(this);
      var object = selected.attr('data-modalObject');

      // Update some Properties
      $('[name="heading"]').html('Create New ' + object);
      var form = $('#' + object + 'Modal').find('form');
      form.attr('action', selected.attr('data-modalRoute'));
      form.attr('method', selected.attr('data-modalMethod'));
      form.children('input[name="_method"]').remove();
    });

    // Listen for show delete modal
    $('[data-displayDeleteModal="true"]').click(function() {

      setup($(this), 'Delete');

    });

  }

  /**
    * Sets up the current modal with the correct heading and mode
    * mode needs to be given so the action and method of the modal form and
    * be appropriately updated
    * @param jObject object to update
    * @param string mode of the form to use
    */
  function setup(selected, mode) {
    var object = selected.attr('data-modalObject');//.toLowerCase();

    //getData($(this).attr('data-userID'), $(this).attr('data-modalObject') + '();');
    $('[name="heading"]').html(mode + ' ' + object);
    //var form = $('[name="' + object + 'ModalForm"]');
    var form = $('#' + object + 'Modal').find('form');

    form.attr('action', selected.attr('data-modalRoute'));

    if (selected.attr('data-modalMethod') == "PUT" || selected.attr('data-modalMethod') == "PATCH") {
      form.attr('method', 'POST');
      form.prepend('<input name="_method" type="hidden" value="PUT"/>');
    } else if (selected.attr('data-modalMethod') == "DELETE") {
      form.attr('method', 'POST');
      form.prepend('<input name="_method" type="hidden" value="DELETE"/>');
    } else {
      form.attr('method', selected.attr('data-modalMethod') || 'POST');
    }
  }

  /**
    * Clear the input boxes of the current modal
    */
  function clearInput() {
    $('input').not('input[name="_token"], input[name="_method"]').val('');
    $('input[type="checkbox"]').prop('checked', false);
  }

  /**
    * Populate the modal with user data
    * @param object data containing user info
    */
  function users(data) {
    $('[name="username"]').val(data.user.username);

    // Only show super check if user is super
    // to protect the identity of the super users
    if (data.user.is_super_user) {
      $('[name="chkIsSuper"]').prop('checked', true);
    }
  }

  /**
    * Populates the modal with templates data
    * @param object data containing template data
    */
  function templates(data) {
    $('[name="txtTemplateName"]').val(data.template.name);
    $('[name="txtTemplateClass"]').val(data.template.class_name);
    $('[name="numTemplateDuration"]').val(data.template.duration);
  }

  /**
    * Populates the modal with locations data
    * @param object data containing locations data
    */
  function locations(data) {
    $('[name="txtLocationName"]').val(data.location.name);
    $('[name="drpDepartments"]').val(data.location.department_id);
  }

  /**
    * Populates the modal with departments data
    * @param object data containing departments data
    */
  function departments(data) {
    $('[name="txtDepartmentName"]').val(data.department.name);
    $('[name="drpBackgrounds"]').val(data.department.background_id);
  }

  /**
    * Populates the modal with screens data
    * @param object data containing screens data
    */
  function screens(data) {
    $('[name="txtScreenID"]').val(data.screen.id);
    $('[name="drpLocations"]').val(data.screen.location_id);
    $('[name="drpPlaylists"]').val(data.screen.playlist_id);
  }

  /**
    * Populates the modal with playlist data
    * @param object data containing playlist data
    */
  function playlist(data) {
    $('[name="txtPlaylistName"]').val(data.playlist.name);
    $('[name="drpDepartments"]').val(data.playlist.department_id);

    if (data.playlist.isGlobal) {
      $('[name="chkIsGlobal"]').attr('checked', true);
    }
  }

  /**
    * Populates the modal with advert data
    * @param object data containing advert data
    */
  function advert(data) {
    $('[name="txtAdvertName"]').val(data.advert.name);
    $('[name="drpDepartments"]').val(data.advert.department_id);
    $('[name="drpBackgrounds"]').val(data.advert.background_id);
  }

  /**
    * Populates the modal with background data
    * @param object data containing background data
    */
  function backgrounds(data) {
    $('[name="txtBackgroundName"]').val(data.background.name);
    $('[name="hexBackgroundColor"]').val(data.background.hex_colour);
    $('#colorSelector2 div').css('backgroundColor', '#' + data.background.hex_colour);
    $('#colorSelector2').ColorPickerSetColor(data.background.hex_colour);
  }

  /**
    * Requests data from the server (AJAX), uses the action property to
    * determine which object type (user, template etc...)
    * @param int id of object to request
    * @param func callback to use to populate the modal
    */
  function getData(id, callback) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': ModalManager.token
      }
    });

    $.ajax({
      type: "GET",
      url : ModalManager.action + id,
      data : {'id': id},
      success : function(data){
        if (data.error !== undefined) {
          showErrors();
          $('[name="errorMsg"]').html(data.error);
        } else {
          showData();
          callback(data);
        }
      },
      error : function(xhr, textStatus, errorThrown) {
        showErrors();
        $('[name="errorMsg"]').html(errorThrown);
      }
    },"JSON");
  }

  /**
    * Shows the loading screen on the modal
    */
  function showLoading() {
    $('.loading').removeClass('hidden');
    $('.modal_content').addClass('hidden');
    $('.errors').addClass('hidden');
  }

  /**
    * Shows the data screen on the modal to display data
    */
  function showData() {
    $('.modal_content').removeClass('hidden');
    $('.loading').addClass('hidden');
    $('.errors').addClass('hidden');
  }

  /**
    * Shows the error screem to indicate a problem
    */
  function showErrors() {
    $('.errors').removeClass('hidden');
    $('.loading').addClass('hidden');
    $('.modal_content').addClass('hidden');
  }

  return {
    register_eventhandlers: register_eventhandlers,
    users: users,
    templates: templates,
    locations: locations,
    departments: departments,
    screens: screens,
    playlist: playlist,
    advert: advert,
    backgrounds: backgrounds
  };

} ());

var BackgroundUpdater = (function() {

  var token = "";
  var action = "";

  /**
    * Register event listeners
    */
  function register_eventhandlers() {

    $('[name="drpBackgrounds"]').on('change', function() {
      update($(this).val());
    });

  }

  function updateDropdown(option) {

    $('[name="drpBackgrounds"]').val(option);

  }

  function update(id) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': BackgroundUpdater.token
      }
    });

    $.ajax({
      type: "POST",
      url : BackgroundUpdater.action,
      data : {'background_id': id},
      success : function(data){
        // Redirect if available
        if (data.redirect !== undefined || data.redirect !== null) {
          window.location.href = data.redirect;
        }
      },
      error : function(xhr, textStatus, errorThrown) {
        console.log(xhr);
      }
    },"JSON");

  }

  return {
    register_eventhandlers: register_eventhandlers,
    updateDropdown: updateDropdown
  };

} ());
