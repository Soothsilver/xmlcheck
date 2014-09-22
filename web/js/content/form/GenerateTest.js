/**
 * Form for generating tests from sets of test questions (question selection
 * has to happen outside the form).
 */
asm.ui.form.GenerateTest = asm.ui.DynamicForm.extend({
	constructor: function (config) {
		var defaults = {
			formStructure: { main: {
				icon: asm.ui.globals.icons.xtest,
				caption: 'Generate new test',
				fields: {
					description: {
						label: 'Description',
						type: 'text',
						check: 'hasLength',
						checkParams: { minLength: 5, maxLength: 50}
					},
					count: {
						label: 'Number of questions',
						type: 'select',
						check: 'isNotEmpty'
					},
					questions: {
						type: 'hidden',
						check: 'isNotEmpty'
					},
					questionHint: {
						label: 'Questions',
						type: 'info',
						value: 'Select and filter questions above.'
					}
				}
			}},
			request: 'AddTest'
		};
		this.base($.extend(true, defaults, config));
	},
	/**
	 * Set questions to be used for test generation.
	 * @tparam array questions an array of question IDs
	 */
	setQuestions: function (selectedIds, filteredIds) {
		var questionsEl = this.form('getFieldByName', 'questions'),
			countEl = this.form('getFieldByName', 'count'),
			countOptions = [],
			i = selectedIds.length;
		while (i) {
			asm.ui.ArrayUtils.remove(selectedIds[--i], filteredIds);
		}
		var fullCount = selectedIds.length + filteredIds.length,
			questionStr = selectedIds.join(',') + ';' + filteredIds.join(',');
		for (var j = Math.max(selectedIds.length, 1); j <= fullCount; ++j) {
			countOptions.push(j);
		}
		questionsEl.field('option', 'value', questionStr);
		countEl.field('option', 'options', countOptions);
	}
});