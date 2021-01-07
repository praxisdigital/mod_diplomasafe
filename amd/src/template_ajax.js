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
                this.loadAjax = function() {
                    var $ajaxWrapper = $pageWrapper.find('#ajax-result');
                    var sessionKey = $ajaxWrapper.data('session-key');
                    var selectedTemplateId = $pageWrapper.find('[name="template_id"]').val();
                    var languageId = $pageWrapper.find('#id_language_id option:selected').val();
                    $.ajax({
                        type : 'GET',
                        url : '/mod/diplomasafe/ajax/template_ajax.php',
                        data : {
                            sesskey : sessionKey,
                            selected_template_id : selectedTemplateId,
                            language_id : languageId
                        },
                        success : function(data) {
                            $pageWrapper.find('#ajax-result').html(data);
                            $pageWrapper.find('#template').on('change', function() {
                                var selectedOption = $(this).find('option:selected');
                                var hiddenField = $pageWrapper.find('[name="template_id"]');
                                hiddenField.val(selectedOption.val());
                            });
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
