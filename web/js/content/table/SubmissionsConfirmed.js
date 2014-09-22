/**
 * Table of confirmed submissions.
 */
asm.ui.table.SubmissionsConfirmed = asm.ui.table.SubmissionsBase.extend({
	constructor: function (config) {
		var defaults = {
			filter: function (row) {
				return ((row.status == 'confirmed') || (row.status == 'rated'));
			},
			icon: asm.ui.globals.icons.submission,
			structure: {
				date: { label: 'Submitted', comparable: true, string: true },
				status: { label: 'Status', comparable: true },
				fulfillment: { label: 'Success', comparable: true, renderer: function(percentage) { return percentage + "%"; } },
				rating: { label: 'Points', comparable: true },
                explanation: { label: 'Note', string: true}
			},
			title: 'Confirmed submissions'
		};
		this.base($.extend(true, defaults, config));
	}
});