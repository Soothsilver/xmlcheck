/**
 * Add attachment form.
 */
asm.ui.form.Attachment = asm.ui.DynamicForm.extend({
	constructor: function (config) {
		var defaults = {
			formStructure: { main: {
				icon: asm.ui.globals.icons.attachment,
				caption: 'Add/Edit attachment',
				fields: {
					id: {
						type: 'hidden'
					},
					lecture: {
						label: 'Lecture',
						type: 'select',
						hint: 'attachment will be bound to this lecture',
						check: 'isNotEmpty'
					},
					name: {
						label: 'Name',
						type: 'text',
						check: ['isName', 'hasLength'],
						checkParams: { minLength: 5, maxLength: 20 }
					},
					type: {
						label: 'Type',
						type: 'select',
						options: {
							text: 'text',
							code: 'code',
							image: 'image'
						},
						check: 'isNotEmpty'
					},
					file: {
						label: 'File',
						type: 'file',
						check: 'isNotEmpty'
					}
				}
			}},
			request: 'EditAttachment',
			stores: [asm.ui.globals.stores.lectures]
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

		var typeEl = this.form('getFieldByName', 'type'),
			fileEl = this.form('getFieldByName', 'file');
		typeEl.unbind('change.pageInit').bind('change.pageInit', function () {
			var type = typeEl.field('option', 'value'),
				restrictExtensions = (type == 'image'),
				hint = 'use \'image\' type for files usable as images in HTML',
				extensions = ['gif', 'png', 'jpeg', 'jpg', 'bmp'];
			fileEl.field('reset')
				.field('option', 'hint', restrictExtensions ? hint : '')
				.field('option', 'check', restrictExtensions ? 'hasExtension' : 'notEmpty')
				.field('option', 'checkParams', restrictExtensions ? { extensions: extensions } : {});
		}).change();
	}
});