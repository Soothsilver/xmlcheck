// TODO remove this file
asm.ui.panel.UserSettings = asm.ui.Container.extend({
    constructor: function (config) {
        var defaults = {
            children: {
                major: new asm.ui.form.UserAccount(),
                email: new asm.ui.form.EmailSettings()
            }
        };
        this.base($.extend(defaults, config));
    }
});