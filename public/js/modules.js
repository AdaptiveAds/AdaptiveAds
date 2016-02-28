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
  var multi = false;
  var adverts = [];

  function register_eventhandlers() {

    // Un-check all checkboxes
    $('input:checkbox').removeAttr('checked');

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

var ObjectAssign = (function() {

  var token = "";
  var action = "";

  function register_eventhandlers() {

    $('button[name="btnAdd"]').click(function() {

      update('add', SelectManager.getSelected());

    });

    $('button[name="btnRemove"]').click(function() {

      update('remove', SelectManager.getSelected());

    });

  }

  function redirect(path) {
    console.log(path);
    window.location.href = path;
  }

  function update(mode, objects) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': ObjectAssign.token
      }
    });

    $.ajax({
      type: "POST",
      url : ObjectAssign.action,
      data : {'mode': mode, 'arrObjects': objects},
      success : function(data){
        console.log(data);
        if (data.failed === undefined) {
          redirect(data.redirect); // Redirect
        } else {
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

var IndexUpdater = (function() {

  var token = "";
  var action = "";

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
        'X-CSRF-Token': IndexUpdater.token
      }
    });

    $.ajax({
      type: "POST",
      url : IndexUpdater.action,
      data : {'itemID': itemID, 'effectedID': effectedID, 'newIndex': newIndex, 'effectedIndex': effectedIndex},
      success : function(data){
        // Do Nothing...
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
      clearInput();

      var selected = $(this);
      var id = selected.attr('data-userID');
      var object = selected.attr('data-modalObject').toLowerCase();

      // Search for our function def
      var fn = window["ModalManager"][object];

      // If it is not a function cancel the process
      if (typeof fn !== "function")
        return;

      // Go AJAX the data
      getData(id, fn);

      //getData($(this).attr('data-userID'), $(this).attr('data-modalObject') + '();');
      $('[name="heading"]').html('Edit ' + object);
      var form = $('#' + object + 'Modal').find('form');
      form.attr('action', selected.attr('data-modalRoute'));

      if (selected.attr('data-modalMethod') == "PUT" || selected.attr('data-modalMethod') == "PATCH") {
        form.attr('method', 'POST');
        form.prepend('<input name="_method" type="hidden" value="PUT"/>');
      } else {
        form.attr('method', selected.attr('data-modalMethod') || 'POST');
      }
    });

    $('[data-displayCreateModal="true"]').click(function() {

      showData();
      clearInput();

      var selected = $(this);
      var object = selected.attr('data-modalObject');

      $('[name="heading"]').html('Create New ' + object);
      var form = $('#' + object + 'Modal').find('form');
      form.attr('action', selected.attr('data-modalRoute'));
      form.attr('method', selected.attr('data-modalMethod'));
      form.children('input[name="_method"]').remove();
    });

  }

  function clearInput() {
    $('input').not('input[name="_token"], input[name="_method"]').val('');
    $('input[type="checkbox"]').prop('checked', false);
  }

  function users(data) {
    $('[name="txtUsername"]').val(data.user.username);

    if (data.user.is_super_user) {
      $('[name="chkIsSuper"]').prop('checked', true);
    }
  }

  function templates(data) {
    $('[name="txtTemplateName"]').val(data.template.name);
    $('[name="txtTemplateClass"]').val(data.template.class_name);
    $('[name="numTemplateDuration"]').val(data.template.duration);
  }

  function locations(data) {
    $('[name="txtLocationName"]').val(data.location.name);
    $('[name="drpDepartments"]').val(data.location.department_id);
  }

  function departments(data) {
    $('[name="txtDepartmentName"]').val(data.department.name);
    $('[name="drpSkins"]').val(data.department.skin_id);
  }

  function screens(data) {
    $('[name="txtScreenID"]').val(data.screen.id);
    $('[name="drpLocations"]').val(data.screen.location_id);
    $('[name="drpPlaylists"]').val(data.screen.playlist_id);
  }

  function playlist(data) {
    $('[name="txtPlaylistName"]').val(data.playlist.name);
    $('[name="drpDepartments"]').val(data.playlist.department_id);

    if (data.playlist.isGlobal) {
      $('[name="chkIsGlobal"]').attr('checked', true);
    }
  }

  function advert(data) {
    $('[name="txtAdvertName"]').val(data.advert.name);
    $('[name="drpDepartments"]').val(data.advert.department_id);
  }

  function skins(data) {
    $('[name="txtSkinName"]').val(data.skin.name);
    $('[name="txtSkinClass"]').val(data.skin.class_name);
  }

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
        showData();
        callback(data);
      },
      error : function(xhr, textStatus, errorThrown) {
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
    register_eventhandlers: register_eventhandlers,
    users: users,
    templates: templates,
    locations: locations,
    departments: departments,
    screens: screens,
    playlist: playlist,
    advert: advert,
    skins, skins
  };

} ());
