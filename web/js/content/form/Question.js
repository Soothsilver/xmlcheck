/**
 * Add/edit a test question form.
 */
asm.ui.form.Question = asm.ui.DynamicForm.extend({
	constructor: function (config) {
		var defaults = {
			formStructure: { main: {
				icon: asm.ui.globals.icons.question,
				caption: 'Add/Edit question',
				fields: {
					id: {
						type: 'hidden'
					},
					lecture: {
						label: 'Lecture',
						type: 'select',
						hint: 'question will be bound to this lecture',
						check: 'isNotEmpty'
					},
					text: {
						label: 'Question',
						type: 'textarea',
						check: 'isNotEmpty'
					},
					type: {
						label: 'Type',
						type: 'select',
						options: {
							'text': 'text answer',
							'choice': 'single choice',
							'multi': 'multiple choice'
						},
						check: 'isNotEmpty'
					},
					options: {
						label: 'Options',
						type: 'textarea',
						check: 'isNotEmpty'
					},
					attachments: {
						label: 'Attachments',
						type: 'multiselect'
					}
				}
			}},
			request: 'EditQuestion',
			stores: [asm.ui.globals.stores.lectures, asm.ui.globals.stores.attachments]
		};
		if (config && config.stores) {
			$.merge(defaults.stores, config.stores);
			delete config.stores;
		}
		this.base($.extend(true, defaults, config));
	},
	_initContent: function () {
		this.setFieldOptions('lecture',
				asm.ui.Utils.tableToOptions(asm.ui.globals.stores.lectures.get(), 'id', 'name'));

		var lectureEl = this.form('getFieldByName', 'lecture'),
			attachmentsEl = this.form('getFieldByName', 'attachments'),
			attachments = asm.ui.globals.stores.attachments.get();
		lectureEl.unbind('change.pageInit').bind('change.pageInit', function () {
			var lectureId = lectureEl.field('option', 'value'),
				attFiltered = $.grep(attachments, function (attachment) {
					return (attachment.lectureId == lectureId);
				}),
				noAttachments = !attFiltered.length;
			attachmentsEl.field('option', 'type', noAttachments ? 'info' : 'multiselect')
				.field('option', 'options', asm.ui.Utils.tableToOptions(
					attFiltered, 'id', 'name'));
			if (noAttachments) {
				attachmentsEl.field('option', 'value', 'N/A');
			}

		}).change();

		var typeEl = this.form('getFieldByName', 'type'),
			optionsEl = this.form('getFieldByName', 'options');
		typeEl.unbind('change.pageInit').bind('change.pageInit', function () {
			var type = typeEl.field('option', 'value'),
				enableOptions = (type != 'text'),
				hint = 'first character will be used as option separator';
			optionsEl.field('option', 'type', enableOptions ? 'textarea' : 'empty')
				.field('option', 'hint', enableOptions ? hint : '')
				.field('option', 'editable', enableOptions);
		}).change();
	}
});