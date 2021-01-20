/**
 * @developer   Johnny Drud
 * @date        20-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
define(['jquery'], function($) {
    return {
        'init' : function() {
            var $pageWrapper = $('#page-mod-diplomasafe-view');
            $pageWrapper.find('#delete-button').on('click', function() {
                return confirm($(this).data('confirm-deletion'));
            });
        }
    };
});
