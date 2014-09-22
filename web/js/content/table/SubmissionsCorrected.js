/**
 * Table of corrected and yet unconfirmed submissions.
 */
asm.ui.table.SubmissionsCorrected = asm.ui.table.SubmissionsBase.extend({
	constructor: function (config) {
		var defaults = {
			actions: {
				extra: [{
					callback: $.proxy(function () {
						this.trigger('custom.confirmSubmission');
					}, this),
					confirmFilter: function (id, values) {
						var success = +values[4]; // TODO this must be corrected! simply by adding columns, we are breaking code everywhere!
						return (success < 100 || asm.ui.TimeUtils.mysqlTimestamp() > values[3]);
                        // Warn when not fully successful or late
					},
					confirmText: 'Auto-correct plugin found some errors in your submission or you are submitting your solution late. Submission confirmation is an irreversible action. ' +
							'Do you really want to confirm this submission?',
					confirmTitle: 'Possibly incorrect or late submission',
					expire: [
						asm.ui.globals.stores.submissions,
						asm.ui.globals.stores.correction
					],
					filter: function (id, values) {
                        // Allow submitting old solutions
                        return true;
					    //	return asm.ui.TimeUtils.mysqlTimestamp() < values[3];
					},
					icon: 'ui-icon-' + asm.ui.globals.icons.confirm,
					label: 'confirm submission',
					refresh: true,
					request: 'ConfirmSubmission'
				}, asm.ui.Macros.trashAction({
					subject: 'submission',
					removalRequest: 'DeleteSubmission',
					expireOnRemoval: [asm.ui.globals.stores.submissions],
                    removalMessage: '(The submission will remain in the database but you won\'t be able to see it.)'
				})],
				raw: [{
					icon: 'ui-icon-' + asm.ui.globals.icons.downloadOutput,
					label: 'download output',
					filter: function (id, values) {
						return values[1] == 'yes';
					},
					action: function (id) {
						asm.ui.globals.fileSaver.request('DownloadSubmissionOutput',
								{ id: id }, null,	$.proxy(this._triggerError, this));
					}
				}]
			},
			filter: function (row) {
				return (row.status == 'corrected' || row.status == 'preferred');
			},
			structure: {
				deadline: { label: 'Deadline', comparable: true, string: true },
				fulfillment: { label: 'Success', comparable: true, renderer: function(percentage) { return percentage + "%"; } },
                date: { label: 'Uploaded', comparable: true, string: true },
				details: { label: 'Details', string: true, renderer: asm.ui.StringUtils.htmlspecialchars }
			},
			title: 'Corrected submission drafts'
		};
		this.base($.extend(true, defaults, config));
	},
    _initContent: function () {
        this.base();
        this.table('sort', 'date');
    }
});