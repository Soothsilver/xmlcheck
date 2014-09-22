/**
 * Table of questions.
 */
asm.ui.table.Questions = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			icon: asm.ui.globals.icons.question,
			structure: {
				id: { key: true, hidden: true, comparable: true },
				text: { label: 'Text', string: true, comparable: true },
				type: { label: 'Type', string: true, comparable: true, renderer: function (val) {
					switch (val) {
						case 'text':
							return 'text answer';
						case 'choice':
							return 'single choice';
						case 'multi':
							return 'multiple choice';
						default:
							return val;
					}
				} },
				options: { label: 'Options', string: true },
				lectureId: { hidden: true, comparable: true },
				lecture: { label: 'Lecture', comparable: true, string: true }
			},
			title: 'Questions',
			stores: [asm.ui.globals.stores.questions]
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