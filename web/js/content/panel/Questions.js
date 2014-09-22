/**
 * Container with an editor of questions and a form for test generation.
 */
asm.ui.panel.Questions = asm.ui.Container.extend({
	constructor: function (config) {
		var defaults = {
			children: {
				editor: new asm.ui.editor.Questions(),
				genForm: new asm.ui.form.GenerateTest()
			}
		};
		this.base($.extend(defaults, config));

		var children = this.config.children;
		children.genForm.bind('form.success', $.proxy(function (o) {
			asm.ui.globals.stores.tests.expire();
			this._triggerError(new asm.ui.Error('Test generated successfully.', asm.ui.Error.NOTICE));
			this.trigger('questions.showTests');
		}, this));
		children.editor.bind('editor.stateChange', function (o) {
			var showForm = (o.state == asm.ui.DynamicTableEditor.STATE_EXPLORE);
			children.genForm[showForm ? 'show' : 'hide']();
		});
		children.editor.bind('table.selectionChange', function (o) {
			var getId = function (item) {
					return item.id;
				},
				selected = $.map(o.selected, getId),
				filtered = $.map(o.filtered, getId);
			children.genForm.setQuestions(selected, filtered);
		});
	}
});