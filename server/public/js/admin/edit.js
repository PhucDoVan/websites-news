'use strict'

$(document).ready(function () {

  /**
   * Pattern:
   * 1. At least one char in [a-z]
   * 2. At least one char in [A-Z]
   * 3. At least one char in [0-9]
   */
  const validatePattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

  /**
   * Generate password
   */
  $('.generate_password').on('click', function () {
    $('input[name=password]').val(Password.generate(15, validatePattern));
  });

});
