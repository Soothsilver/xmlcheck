asm.ui.panel.Submissions = asm.ui.Container.extend({
	constructor: function (config) {
		var defaults = {
			children: {
				fresh: new asm.ui.table.SubmissionsNew({
					autoRefresh: 5 * 1000,
					autoRefreshForce: true
				}),
				corrected: new asm.ui.table.SubmissionsCorrected(),
				confirmed: new asm.ui.table.SubmissionsConfirmed()
			}
		};
		this.base($.extend(defaults, config));

		this.config.children.fresh.bind('panel.refresh', function () {
			this.config.children.corrected.refresh();
		}, this);

		this.config.children.corrected.bind('panel.refresh', function () {
			this.config.children.confirmed.refresh();
		}, this);
	}
});