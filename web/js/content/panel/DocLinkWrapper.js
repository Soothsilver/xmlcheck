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
                        var builtLink = this._buildLink('', '  Česky');
                        var classedLink = builtLink.addClass('outlink');
                        var clickableLink = classedLink.click(function() {
                                asm.lang.setLanguage('cs');
                            });
                        clickableLink.appendTo(this.config.target);

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