'use strict'

/**
 * Pattern:
 * 1. At least one char in [a-zA-Z0-9]
 * 2. Not contain chars in [1lIoO0]
 */
const validatePattern = /^((?![1lIoO0])[a-zA-Z0-9])+$/;

$(document).ready(function () {
  /**
   * Generate corporation uid
   */
  if (!$('input[name=uid]').val()) {
    generateUid();
  }
  $('.generate_uid').on('click', function () {
    generateUid();
  });

  /**
   * Format string to postal code when first load
   */
  let code         = $('.js_postal_code').val();
  let codeFormated = formatPostalCode(code);
  $('.js_postal_code').val(codeFormated);

  /**
   * Format string to postal code when input change
   */
  $('.js_postal_code').on('change', function () {
    let code         = $(this).val();
    let codeFormated = formatPostalCode(code);

    $(this).val(codeFormated);
  });

  handleDisplayButtonAddContact();

  /** add block more contact when click button */
  $('body').on('click', '.js_button_add_contact', function () {
    const block = $(this).closest('.js_block_contact');
    const clone = block.clone();

    /* reset value to empty */
    clone.find('input').val('');
    clone.find('.text-danger').text('');

    block.after(clone);
    handleDisplayButtonAddContact();
  });

  $('.js-change-status').click(function () {
    const serviceId = $(this).data('service_id');
    const status    = $(this).data('status');

    const title   = $(this).data('modal_title');
    const message = $(this).data('modal_message').replace(':service_name', $(this).data('service_name'));

    const modal = $('#changeStatusModal');
    modal.find('#changeStatusModalLabel').html(title);
    modal.find('#changeStatusModalMessage').html(message);

    modal.find('input[name=service_id]').val(serviceId);
    modal.find('input[name=status]').val(status);
    modal.modal('show');
  });
});

/**
 * Format string to postal code
 *
 * @param str
 * @returns {String}
 */
function formatPostalCode(str) {
  if (!str) {
    return '';
  }

  str = str.replace(/[^0-9]/g, '');

  if (str.length < 7) {
    return str;

  }

  return str.substring(0, 3) + '-' + str.substring(3, 7);
}

/**
 * Show/hide buttons add, delete block contact
 */
function handleDisplayButtonAddContact() {
  $('body').find('.js_button_delete_contact').show();
  if ($('body').find('.js_button_delete_contact').length == 1) {
    $('body').find('.js_button_delete_contact').hide();
  }

  $('body').find('.js_button_add_contact').hide();
  $('body').find('.js_button_add_contact').last().show();
}

/**
 * Delete block contact when click button
 * @param _this
 */
function deleteBlockContact(_this) {
  $(_this).closest('.js_block_contact').remove();
  handleDisplayButtonAddContact();
}

/**
 * Generate random corporation uid
 */
function generateUid() {
  const uid = Password.generate(3, validatePattern);
  $('input[name=uid]').val(uid);
}
