/**
 * Table of sums of users' submission ratings in owned groups.
 */
asm.ui.table.UserRatings = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			icon: asm.ui.globals.icons.rating,
			structure: {
				user: { label: 'Name', comparable: true, string: true },
				email: { label: 'E-mail', comparable: true, string: true },
				rating: { label: 'Points', comparable: true },
				groupId: { hidden: true, comparable: true },
				group: { label: 'Group', comparable: true, string: true },
				description: { hidden: true, label: 'Description', string: true },
				lecture: { label: 'Lecture', comparable: true, string: true },
				lectureDescription: { hidden: true, label: 'L. description', comparable: true, string: true }
			},
			title: 'User rating sums for owned groups',
			stores: [asm.ui.globals.stores.ratingsTeacher]
		};
		this.base($.extend(true, defaults, config));
	},
	_adjustContent: function () {
		var groupId = this._params[0] || false;
		if (this._filterId != undefined) {
			this.table('removeFilter', this._filterId);
		}
		if (groupId) {
			this._filterId = this.table('addFilter', 'groupId', 'equal', groupId);
		}
	}
});