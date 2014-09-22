/**
 * Base class for table of submissions for correction (or corrected).
 */
asm.ui.table.CorrectionBase = asm.ui.DynamicTable.extend({
	constructor: function (config) {
		var defaults = {
			actions: {
				raw: []
			},
			icon: asm.ui.globals.icons.submission,
			structure: {
				id: {key: true, hidden: true, comparable: true},
				problem: {label: 'Problem', comparable: true, string: true},
				group: {label: 'Group', comparable: true, string: true},
				date: {label: 'Submitted', comparable: true, string: true},
				fulfillment: {label: '%', renderer: function(percentage) { return percentage + "%"; }},
				details: {label: 'Details', string: true},
				reward: {hidden: true, comparable: true},
				authorId: {hidden: true, comparable: true},
				author: {label: 'Author', hidden: true, comparable: true, string: true},
                deadline: { hidden: true, comparable: true, string: true},
                explanation: {hidden: true, string: true},
                hasOutput: {hidden: true, renderer: function (value) {
                    return (value ? 'yes' : 'no');
                }}
			}
		};
		this.base($.extend(true, defaults, config));
	},
	_showContent: function () {
		var privileges = asm.ui.globals.session.getProperty('privileges') || {};
		this.config.structure.author.hidden = !privileges.submissionsViewAuthors;
		this.base.apply(this, arguments);
	},
	_createRateActionConfig: function (reRate) {
		var triggerError = $.proxy(this._triggerError, this);
		return {
			icon: 'ui-icon-' + asm.ui.globals.icons[reRate ? 'edit' : 'rating'],
			label: 'rate submission',
			action: $.proxy(function (id, values) {
				var options = [],
					maxRating = values[6],
					fulfillment = values[4],
                    submissionDate = values[3],
                    deadlineDate = values[9],
					rating = values[12],
                    explanation = values[10];

				for (var i = 0; i <= maxRating; ++i) {
					options.push(i);
				}
                var late = submissionDate > deadlineDate;

                    asm.ui.globals.dialogManager.form($.proxy(function (data) {
                        asm.ui.globals.coreCommunicator.request('RateSubmission', data, $.proxy(function () {
                            asm.ui.globals.stores.ratingsTeacher.expire();
                            asm.ui.globals.stores.ratingsTeacherDetailed.expire();
                            if (!reRate) {
                                asm.ui.globals.stores.correctionRated.expire();
                            }
                            this.refresh(true);
                        }, this), $.noop, triggerError);
                    }, this), {
                        fields: {
                            id: {
                                type: 'hidden',
                                value: id
                            },
                            rating: {
                                type: 'select',
                                options: options,
                                label: 'Rating',
                                value: reRate ? rating : Math.floor(fulfillment * maxRating / 100)
                            },
                            explanation: {
                               type: 'textarea',
                               label: 'Note to student',
                               value: explanation
                            },
                            lateNotice: {
                                type: (late ? 'info' : 'hidden'),
                                label: 'Submitted late',
                                value: 'This solution was submitted late.\nDeadline: ' + deadlineDate + "\nSubmission: " + submissionDate
                            }
                        },
                        submitText: reRate ? 'Change' : 'Rate'
                    }, (reRate ? 'Change submission rating' : 'Rate submission') + (late ? " (late submission)" : "")  );


			}, this)
		};
	},
	_createDownloadSubmissionActionConfig: function () {
		var triggerError = $.proxy(this._triggerError, this);
		return {
			icon: 'ui-icon-' + asm.ui.globals.icons.downloadInput,
			label: 'download submission',
			action: function (id) {
				asm.ui.globals.fileSaver.request('DownloadSubmissionInput',
						{id: id}, null, triggerError);
			}
		};
	},
	_createDownloadOutputActionConfig: function () {
		var triggerError = $.proxy(this._triggerError, this);
		return {
			icon: 'ui-icon-' + asm.ui.globals.icons.downloadOutput,
			label: 'download output',
            filter: function(id, values)
            {
              return values[11] == "yes";
            },
			action: function (id) {
				asm.ui.globals.fileSaver.request('DownloadSubmissionOutput',
						{id: id}, null, triggerError);
			}
		};
	}
});