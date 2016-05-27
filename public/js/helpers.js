function ConfirmDelete() {

  //return result = confirm("Are you sure you want to delete? This action cannot be UNDONE!")

}

/**
  *
  */
function addVideo(callback) {
  $('#serve_image').children('img').replaceWith('<video autoplay>' +
    '<source src="/advert_videos/video_placeholder.mp4" type="video/mp4">' +
    '<source src="/advert_videos/video_placeholder.mp4" type="video/mp4">' +
    'Your browser does not support the provided codec types.' +
  '</video>');

  $('video').on('ended', function() {
    callback(2);
  });
}

function addImage() {
  if ($('#serve_image').children('video').length) {
    $('#serve_image').children('video').replaceWith('<img src="/images/logo.png" title="" alt=""/>');
  }
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
