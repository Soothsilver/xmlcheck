asm.ui.form.OtherAdministration = asm.ui.DynamicForm.extend({
    constructor: function (config) {
        var defaults = {
            formProps: {
                offline: true
            },
            formStructure: { main: {
                icon: asm.ui.globals.icons.settings,
                caption: asm.lang.otherAdministration.caption,
                fields: {
                    name: {
                        label: asm.lang.otherAdministration.firstParagraphLabel,
                        type: 'info',
                        value: asm.lang.otherAdministration.firstParagraphText
                    }
                }
            }}
        };
        this.base($.extend(true, defaults, config));
    }
});