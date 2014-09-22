/**
 * Table of submissions awaiting correction.
 */
asm.ui.table.CorrectionNew = asm.ui.table.CorrectionBase.extend({
	constructor: function (config) {
		var defaults = {
			actions: {
				raw: [
					this._createRateActionConfig(),
					this._createDownloadSubmissionActionConfig(),
					this._createDownloadOutputActionConfig()
				]
			},
			title: 'Submissions awaiting correction',
			stores: [asm.ui.globals.stores.correction]
		};
		this.base($.extend(true, defaults, config));
	}
});