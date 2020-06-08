'use strict'

$(document).ready(function () {

  /**
   * Sort by column when click to header of table
   */
  $('th[class^=sorting]').on('click', function () {
    const field     = $(this).attr('aria-field');
    const sort      = $(this).attr('aria-sort');
    window.location = $('input[name=current_url]').val() + "&sort_column=" + field + "&sort_direction=" + sort;
  });

  /**
   * Pull rill pagination
   */
  $('.pagination').addClass('justify-content-end');

});
