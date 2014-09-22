/**
 * Add/edit lecture form.
 */
asm.ui.form.Lecture = asm.ui.DynamicForm.extend({
	constructor: function (config) {
		var defaults = {
			formStructure: { main: {
				icon: asm.ui.globals.icons.lecture,
				caption: asm.lang.lectures.editCaption,
				fields: {
					id: {
						type: 'hidden'
					},
					name: {
						label: asm.lang.lectures.lectureName,
						type: 'text',
						hint: asm.lang.lectures.lectureNameHint,
						check: ['isName', 'hasLength', asm.ui.Macros.nameCheck('lectures')],
						checkParams: { minLength: 3, maxLength: 20 }
					},
					description: {
						label: asm.lang.lectures.description,
						type: 'textarea',
						check: 'isNotEmpty'
					}
				}
			}},
			request: 'EditLecture'
		};
		this.base($.extend(true, defaults, config));
	}
});