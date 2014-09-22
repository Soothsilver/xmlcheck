/**
 * Table of attachments.
 */
asm.ui.table.Attachments = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			icon: asm.ui.globals.icons.attachment,
			structure: {
				id: { key: true, hidden: true, comparable: true },
				name: { label: 'Name', string: true, comparable: true },
				type: { label: 'Type', string: true, comparable: true },
				lectureId: { hidden: true, comparable: true },
				lecture: { label: 'Lecture', comparable: true, string: true }
			},
			title: 'Attachments',
			stores: [asm.ui.globals.stores.attachments]
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