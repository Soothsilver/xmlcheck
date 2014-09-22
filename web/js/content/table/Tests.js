/**
 * Table of tests.
 */
asm.ui.table.Tests = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			actions: {
				extra: [{
					callback: $.proxy(function () {
						this.trigger('tests.create');
					}, this),
					global: true,
					icon: 'ui-icon-' + asm.ui.globals.icons.create,
					label: 'create new test'
				}, {
					callback: $.proxy(function (id) {
						asm.ui.globals.filePrinter.request('DownloadTest', { id: id }, null,
								$.proxy(this._triggerError, this));
					}, this),
					icon: 'ui-icon-' + asm.ui.globals.icons.print,
					label: 'print test'
				}, {
					callback: $.proxy(function () {
						this._triggerError(new asm.ui.Error('Test generated successfully.', asm.ui.Error.NOTICE));
					}, this),
					icon: 'ui-icon-' + asm.ui.globals.icons.xtestGenerate,
					label: 're-generate test',
					request: 'GenerateTest'
				}, asm.ui.Macros.trashAction({
					expireOnRemoval: [asm.ui.globals.stores.tests],
					removalRequest: 'DeleteTest',
					subject: 'test'
				})]
			},
			icon: asm.ui.globals.icons.xtest,
			structure: {
				id: { key: true, hidden: true, comparable: true },
				description: { label: 'Description', string: true, comparable: true },
				lectureId: { hidden: true, comparable: true },
				lecture: { label: 'Lecture', string: true, comparable: true }
			},
			title: 'Tests',
			stores: [asm.ui.globals.stores.tests]
		};
		this.base($.extend(true, defaults, config));
	},
	_adjustContent: function () {
		var lectureId = this._params[0] || false;
		if (this._filterId != undefined) {
			this.table('removeFilter', this._filterId);
		}
		if (lectureId) {
			this._filterId = this.table('addFilter', 'lectureId', 'equal', lectureId);
		}
	}
});