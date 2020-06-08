'use strict';

$(document).ready(function () {

    $('.corporation-select').change(function() {
        $(this).parents('form').submit();
    });

    $('.group-tree .child-level').each(function () {
        var level = $(this).data('level');
        var paddingLeft = level ? `${level * 30}px` : '.75rem';
        $(this).find('td:first-child').css('padding-left', paddingLeft );
    })

});
