/**
 * Table of new (not yet corrected) submissions.
 */
asm.ui.table.SubmissionsNew = asm.ui.table.SubmissionsBase.extend({
	constructor: function (config) {
		var defaults = {
			actions: {
				extra: [asm.ui.Macros.trashAction({
					subject: 'submission',
					removalRequest: 'DeleteSubmission',
					expireOnRemoval: [asm.ui.globals.stores.submissions]
				})]
			},
			filter: function (row) {
				return (row.status == 'new');
			},
			structure: {
				deadline: { label: 'Deadline', comparable: true, string: true }
			},
			title: 'New submission drafts'
		};
		this.base($.extend(true, defaults, config));
	}
});