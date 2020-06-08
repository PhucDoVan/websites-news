'use strict';

$(window).on('load', function () {
  $('#preloader').hide();
});

$(document).ready(function () {
  // highlight different text when compare
  let mergeTo = $('input[name="merge_to"]:checked').val();
  highlightDiff(mergeTo);
  $('input[name="merge_to"]').change(function () {
    mergeTo = this.value;
    highlightDiff(mergeTo);
  });

  // disable arrow buttons when not choose item compare
  if (!$('input[name="account_id_merge"]').val()) {
    $('.merge_to').find('label').addClass('disabled');
    $('.merge_to').find('[type="radio"]').attr('disabled', true);
  }

  if ($('input[name="compare"]').length) {
    $('tr').click(function() {
      $(this).find('input[name="compare"]').prop('checked', true);
      const valueSelected = $(this).find('input[name="compare"]:checked').val();

      // reset radio button mergeTo
      mergeTo = '';
      $('.merge_to').find('label').removeClass('active disabled')
        .end().find('[type="radio"]').prop('checked', false).attr('disabled', false);

      // set value for form merge
      $('input[name="account_id_merge"]').val(valueSelected);

      compare(valueSelected);
      highlightDiff(mergeTo);
    });
  }

  $('form').submit(function () {
    $('#preloader').show();
  });
});

/**
 * Highlight text labels different
 * @param mergeTo '' | 'left' | 'right'
 */
function highlightDiff(mergeTo) {
  if (!mergeTo) {
    $('.js_left_box').find('.text-danger').removeClass('text-danger');
    $('.js_right_box').find('.text-danger').removeClass('text-danger');
    $('.js_button_merge').attr('disabled', true);
    return;
  }

  $('.js_button_merge').attr('disabled', false);
  let boxHighlight = (mergeTo == 'left') ? $('.js_left_box') : $('.js_right_box');
  let boxCompare   = (mergeTo == 'left') ? $('.js_right_box') : $('.js_left_box');

  boxHighlight.find('.form-row label[class*="js_"]').each(function (index, el) {
    const curText     = $(el).text();
    const curClasses  = el.className.split(/\s+/);
    const compareEl   = boxCompare.find('.' + curClasses[1]);
    const compareText = compareEl.text();

    $(el).removeClass('text-danger');
    compareEl.removeClass('text-danger');

    if (compareEl.length && curText != compareText) {
      $(el).addClass('text-danger');
    }
  });
}

/**
 * Show item chosen in list to right_box
 * @param id
 */
function compare(id) {
  const item = $(`input#compare_${id}`).closest('tr').data('content');

  $('.js_right_box .js_id').text(item.account_id);
  $('.js_right_box .js_corporation_name').text(item.corporation_name);
  $('.js_right_box .js_username').text(item.username);
  $('.js_right_box .js_name_last').text(item.name_last);
  $('.js_right_box .js_name_first').text(item.name_first);
  $('.js_right_box .js_kana_last').text(item.kana_last);
  $('.js_right_box .js_kana_first').text(item.kana_first);
}
