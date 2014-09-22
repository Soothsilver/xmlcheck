/**
 * Base for submission tables.
 */
asm.ui.table.SubmissionsBase = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			structure: {
				id: { key: true, hidden: true, comparable: true },
				hasOutput: { hidden: true, renderer: function (value) {
					return (value ? 'yes' : 'no');
				}},
				problem: { label: 'Problem', comparable: true, string: true }
			},
			icon: asm.ui.globals.icons.submissionDraft,
			stores: [asm.ui.globals.stores.submissions],
            actions: {
                raw: [
                    this._createDownloadSubmissionActionConfig()
                ]
            }
		};
		this.base($.extend(true, defaults, config));
	},
    _createDownloadSubmissionActionConfig: function () {
        var triggerError = $.proxy(this._triggerError, this);
        return {
            icon: 'ui-icon-' + asm.ui.globals.icons.downloadOutput,
            label: 'download submission',
            action: function (id) {
                asm.ui.globals.fileSaver.request('DownloadSubmissionInput',
                    {id: id}, null, triggerError);
            }
        };
    }
});