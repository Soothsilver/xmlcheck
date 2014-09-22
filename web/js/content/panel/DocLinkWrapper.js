asm.ui.DocLinkWrapper = asm.ui.Container.extend({
	constructor: function (config) {
		var defaults = {
			classes: ['docLinkWrapper'],
			children: {
				docLink: new asm.ui.ContentPanel({
					classes: ['docLinkPanel']
				}).extend({
					_buildContent: function () {
						/* TODO remove this
                        this._buildOutLink('./docs/', asm.ui.globals.appName + ' documentation')
							.appendTo(this.config.target);
                        */
                        this._buildLink('', '  Česky').addClass('outlink')
                            .click(function() {
                                asm.lang.setLanguage('cs');
                            })
                            .appendTo(this.config.target);
                        this._buildLink('', '  English').addClass('outlink')
                            .click(function() {
                                asm.lang.setLanguage('en');
                            })
                            .appendTo(this.config.target);
					}
				})
			}
		};
		this.base($.extend(true, defaults, config));
	}
});