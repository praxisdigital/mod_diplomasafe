/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
define([
    'jquery',
    'core/ajax',
    'core/notification',
], function(
    $,
    Ajax,
    Notification
) {
    return {
        'init' : function() {
            /**
             * @param $pageWrapper
             */
            function TemplateField($pageWrapper) {
                this.$pageWrapper = $pageWrapper;
                this.input = this.$pageWrapper.find('#template_id_select');
                /**
                 * @return void
                 */
                this.loadAjax = function(firstRun) {
                    var selectedTemplateId = $pageWrapper.find('[name="template_id"]').val();
                    var languageId = $pageWrapper.find('#id_language_id option:selected').val();
                    if (!languageId) {
                        this.input.prop('disabled', true);
                        this.empty();
                        return;
                    }
                    this.input.prop('disabled', false);
                    this.input.val('');
                    var self = this;
                    var promises = Ajax.call([{
                        methodname: 'mod_diplomasafe_get_templates',
                        args: {
                            'language_id': languageId
                        }
                    }]);
                    promises[0].done(function(data) {
                        self.empty();
                        self.addData(data);
                        if (firstRun && parseInt(selectedTemplateId) !== 0) {
                            self.input.val(selectedTemplateId);
                        }
                    }).fail(Notification.exception);
                };
                /**
                 * @return void
                 */
                this.empty = function() {
                    this.input.empty();
                    this.input.append(
                        new Option(M.str.mod_diplomasafe.select_default_option_template, '')
                    );
                };
                /**
                 * @return void
                 */
                this.addData = function(data) {
                    if (data.templates.length === 0) {
                        return;
                    }
                    for (var i in data.templates) {
                        if (typeof data.templates[i] === 'undefined') {
                            continue;
                        }
                        var template = data.templates[i];
                        this.input.append(new Option(template.name, template.id));
                    }
                };
                /**
                 * @returns {*}
                 */
                this.getHidden = function() {
                    return this.$pageWrapper.find('[name="template_id"]');
                };
            }
            var $pageWrapper = $('#page-mod-diplomasafe-mod');
            var templateField = new TemplateField($pageWrapper);
            var $hiddenField = templateField.getHidden();
            templateField.loadAjax(true);
            $pageWrapper.find('#id_language_id').on('change', function() {
                $hiddenField.val('');
                templateField.loadAjax(false);
            });
            $pageWrapper.find('#template_id_select').on('change', function() {
                $hiddenField.val('');
                var selectedTemplate = $(this);
                if (selectedTemplate) {
                    $hiddenField.val(selectedTemplate.val());
                }
            });
        }
    };
});
