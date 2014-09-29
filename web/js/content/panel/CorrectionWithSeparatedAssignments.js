/**
 * Container with two tables: submissions ready to be rated and already rated submissions.
 */
asm.ui.panel.CorrectionWithSeparatedAssignments = asm.ui.Container.extend({
	constructor: function (config) {
		var defaults = {
            stores: [
                asm.ui.globals.stores.correctionAll,
                asm.ui.globals.stores.assignments
            ],
			children: {
				loadingPanel: new asm.ui.ContentPanel().extend(
                    {
                        _buildContent : function() {
                            var panel = $('<div></div>')
                                .appendTo(this.config.target)
                                .append(asm.lang.general.loadingData)
                                .panel({ icon: 'info' });
                        }
                    }
                )
			}
		};
		this.base($.extend(true, defaults, config));
	},
    _loadAllTables: function(assignmentData) {
        for(var index = 0; index < assignmentData.length; index++)
        {
            var assignment = assignmentData[index];
            if (!this._tables) { this._tables = []; }
            var table = new asm.ui.table.Correction2({
                title: assignment.problem + " (" + assignment.group + ")",
                filter: function(id, values)
                {
                    return false;
                }
            });
            this._tables.push(table);
            this.config.children[assignment.id] = table;
        }
        this._callOnChildren('setParent', this);
        this._moveChildren(this.config.target);
        this._showContent();
        this.config.children.loadingPanel.hide();
        /*
        // Grade only submission by a specific user
        var authorId = this._params[0] || false;
        var children = this.config.children;
        if (this._filterIds != undefined) {
            children.fresh.table('removeFilter', this._filterIds.fresh);
            children.rated.table('removeFilter', this._filterIds.rated);
        }
        if (authorId) {
            this._filterIds = {
                fresh: children.fresh.table('addFilter', 'authorId', 'equal', authorId),
                rated: children.rated.table('addFilter', 'authorId', 'equal', authorId)
            };
        }
        */
    },
	_adjustContent: function () {
        asm.ui.globals.stores.assignments.get($.proxy(this._loadAllTables, this));
	}
});