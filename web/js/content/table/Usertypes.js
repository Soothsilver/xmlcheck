/**
 * Table of user types.
 */
asm.ui.table.Usertypes = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var iconizePrivs = function (data) {
			var iconized = $('<div></div>');
			for (var i in data) {
				$('<div></div>').addClass('privilege-icon')
					.icon({
						type: data[i][1],
						title: data[i][0]
					})
					.appendTo(iconized);
			}
			return iconized;
		};
		var defaults = {
			icon: asm.ui.globals.icons.usertype,
			structure: {
				id: { key: true, hidden: true, comparable: true },
				name: { label: 'Name', comparable: true, string: true },
				privsUsers: { label: 'Users', renderer: iconizePrivs },
				privsSubscriptions: { label: 'Subscriptions', renderer: iconizePrivs },
				privsPlugins: { label: 'Plugins', renderer: iconizePrivs },
				privsAssignments: { label: 'Assignments', renderer: iconizePrivs },
				privsSubmissions: { label: 'Correction', renderer: iconizePrivs },
				privsLectures: { label: 'Lectures', renderer: iconizePrivs },
				privsGroups: { label: 'Groups', renderer: iconizePrivs },
				privsLog: { label: 'Log', renderer: iconizePrivs }
			},
			title: 'User types with their privileges',
			transformer: function (row) {
				var privileges = row.privileges;
				delete row.privileges;
				for (var subj in asm.ui.globals.privilegesBreakdown) {
					var actions = asm.ui.globals.privilegesBreakdown[subj],
						fieldId = 'privs' + asm.ui.StringUtils.ucfirst(subj);
					row[fieldId] = [];
					for (var action in actions) {
						if (privileges[actions[action][0]]) {
							row[fieldId].push([action + ' ' + subj, actions[action][1]]);
						}
					}
				}
				return row;
			},
			stores: [asm.ui.globals.stores.usertypes]
		};
		this.base($.extend(true, defaults, config));
	}
});