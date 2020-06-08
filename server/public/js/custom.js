"use strict";

$(document).ready(function () {

  /**
   * Customize required error message
   */
  function customeRequiredMessage() {
    $('button[type=submit]').click(function () {
      $('input').each(function () {
        if ($(this)[0].validity && $(this)[0].validity.valueMissing) {
          $(this)[0].setCustomValidity($(this).attr('placeholder') + "は、必ず指定してください。");
        } else {
          $(this)[0].setCustomValidity("");
        }
      });
    });
    $('input').on('input', function () {
      if ($(this)[0].validity && $(this)[0].validity.valueMissing) {
        $(this)[0].setCustomValidity($(this).attr('placeholder') + "は、必ず指定してください。");
      } else {
        $(this)[0].setCustomValidity("");
      }
    });
  }

  customeRequiredMessage();

  // Auto select all when focus input text
  $('input:text').focus(function () {
    $(this).select();
  });

  // Auto select all when focus password
  $('input:password').focus(function () {
    $(this).select();
  });

  // For A Delete Record Modal
  $('button[data-target=deleteModal]').click(function () {
    $('#deleteModalForm').attr("action", $(this).attr('data-url'));
    $('#deleteModal').modal('show');
  });

});
