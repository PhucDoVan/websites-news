'use strict';

$(window).on('load', function () {
  $('#preloader').hide();
});

$(document).ready(function () {
  // show file name to label file when change file
  $('input#file_history').change(function (e) {
    const fileName = e.target.files[0].name;
    $('label.custom-file-label').text(fileName);
  });

  $('button[type=submit]').click(function (e) {
    e.preventDefault();

    const form   = $(this).closest('form');
    const action = $(this).data('action');

    form.attr('action', action).submit();
  });

  $('form').submit(function () {
    $('#preloader').show();
  });
});
