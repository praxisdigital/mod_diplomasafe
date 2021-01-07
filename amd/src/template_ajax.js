/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
define(['jquery'], function($) {
    return {
        'init' : function() {
            /**
             * @param $pageWrapper
             * @constructor
             */
            function TemplateField($pageWrapper) {
                this.$pageWrapper = $pageWrapper;
                var self = this;
                this.loadAjax = function() {
                    var $ajaxWrapper = this.$pageWrapper.find('#ajax-result');
                    var sessionKey = $ajaxWrapper.data('session-key');
                    var languageId = this.$pageWrapper.find('#id_language_id option:selected').val();
                    $.ajax({
                        type : 'GET',
                        url : '/mod/diplomasafe/ajax/template_ajax.php',
                        data : {
                            sesskey : sessionKey,
                            language_id : languageId
                        },
                        success : function(data) {
                            self.$pageWrapper.find('#ajax-result').html(data);
                        }
                    });
                };
            }
            var $pageWrapper = $('#page-mod-diplomasafe-mod');
            var templateField = new TemplateField($pageWrapper);
            templateField.loadAjax();
            $pageWrapper.find('#id_language_id').on('change', function() {
                templateField.loadAjax();
            });
        }
    };
});
