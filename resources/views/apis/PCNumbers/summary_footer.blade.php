<script>
  $('document').ready(function() {

    var availabilityHandle = IntervalManager.add(60000, getAvailability);
    getAvailability()

  });

  function getAvailability() {

    $('#footer ul').empty();

    $.ajax({
      url: 'https://lis.glos.ac.uk/ict/pcajson.php?{{$mode or "mode=summary"}}',
      dataType: 'JSONP',
      jsonpCallback: 'callback',
      type: 'GET',
      success: function (data) {
        //console.log(data)
        for (var key in data) {
            for (key2 in data[key]) {

              var available = 0;
              if (data[key][key2].hasOwnProperty('inuse') && data[key][key2].hasOwnProperty('total')) {
                available = data[key][key2]['total'] - data[key][key2]['inuse']
              }

              if (available != 0) {
                var $div = $('<li>' + capitalizeFirstLetter(key.toLowerCase()) + ' - Available ' + key2 + 's: ' +
                  available
                 + '</span></li>');
                $('#footer ul').append($div);
              }
            }
        }
      }
    });
  }
</script>

<div id="footer">
  <ul>

  </ul>
  <div class="clear"></div>
</div>
