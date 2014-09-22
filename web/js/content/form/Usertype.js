/**
 * User type add/edit form.
 */
asm.ui.form.Usertype = asm.ui.DynamicForm.extend({
	constructor: function (config) {
		var formStructure = { main: {
				icon: asm.ui.globals.icons.usertype,
				caption: asm.lang.userType.editCaption,
				fields: {
					id: {
						type: 'hidden'
					},
					name: {
						label: asm.lang.userType.name,
						type: 'text',
						hint: asm.lang.userType.nameHint,
						check: ['isAlphaNumeric', 'hasLength', asm.ui.Macros.nameCheck('usertypes')],
						checkParams: { minLength: 5, maxLength: 15 }
					}
				}
			}};
		
		$.each(asm.ui.globals.privilegesBreakdown, function (subject, privs) {
			var options = {};
			$.each(privs, function (action, data) {
				options[data[0]] = [action + ' ' + subject, data[1]];
			});
			formStructure.main.fields[subject] = {
				type: 'checkset',
				fancy: true,
				label: asm.ui.StringUtils.ucfirst(subject),
				options: options
			};
		})

		var defaults = {
			formStructure: formStructure,
			request: 'EditUsertype'
		};
		this.base($.extend(true, defaults, config));
	}
});