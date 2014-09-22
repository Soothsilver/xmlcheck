/**
 * Table of system log entries.
 */
asm.ui.table.SystemLog = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			icon: asm.ui.globals.icons.log,
			structure: {
				severity: { label: '!', comparable: true },
				datetime: { label: 'Time', comparable: true, string: true },
				cause: { label: 'Cause', comparable: true, string: true },
				effect: { label: 'Effect', comparable: true, string: true },
				details: { label: 'Details', string: true },
				username: { label: 'U.', comparable: true, string: true },
				ip: { label: 'IP', comparable: true },
				request: { label: 'Req.', comparable: true, string: true }
			},
			title: 'System log',
			stores: [asm.ui.globals.stores.systemLog]
		};
		this.base($.extend(true, defaults, config));
	},
	_initContent: function () {
		this.base();
		this.table('sort', 'datetime', false);
	}
});