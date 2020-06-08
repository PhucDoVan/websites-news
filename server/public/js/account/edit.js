'use strict'

/**
 * Pattern:
 * 1. At least one char in [a-zA-Z0-9]
 * 2. Not contain chars in [1lIoO0]
 */
const validatePattern = /^((?![1lIoO0])[a-zA-Z0-9])+$/;

/**
 * Delete a service row
 *
 * @param _this
 */
function deleteServiceRow(_this) {
  _this.parentElement.parentElement.parentElement.parentElement.parentElement.remove();
}

/**
 * Delete a restrict ip row
 *
 * @param _this
 */
function deleteRestrictIpRow(_this) {
  _this.parentElement.parentElement.parentElement.remove();
}

/**
 * Generate random username
 * @param isKeepLastPart
 */
function generateUsername(isKeepLastPart = false) {
  const random5Chars   = Password.generate(5, validatePattern);
  const corporationUid = $('select[name=corporation_id]').find(':selected').data('uid');

  let lastPart      = random5Chars;
  const oldUsername = $('input[name=username]').val();
  if (isKeepLastPart && oldUsername.split('-')[1]) {
    lastPart = oldUsername.split('-')[1];
  }

  const username = (corporationUid || '') + '-' + lastPart;
  $('input[name=username]').val(username);
}

$(document).ready(function () {
  /**
   * Generate username
   */
  if (!$('input[name=username]').val()) {
    generateUsername();
  }
  $('.generate_username').on('click', function () {
    generateUsername();
  });
  $('select[name=corporation_id]').on('change', function () {
    generateUsername(true);
  });

  /**
   * Generate password
   */
  $('.generate_password').on('click', function () {
    $('input[name=password]').val(Password.generate(10));
  });

  /**
   * Add service row
   */
  $('.add_account_in_service').on('click', function () {
    $('.service_last_row').before($('.service_row').html());
  });

  /**
   * Add restrict ip row
   */
  $('.add_restrict_ip').on('click', function () {
    $('.restrict_ip_last_row').before($('.restrict_ip_row').html());
  });

});
