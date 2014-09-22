/**
 * Handles pre-uploading of files to server.
 *
 * @deprecated Server support for file pre-upload has been dropped at this time.
 */
asm.ui.FileUploader = Base.extend({
	/**
	 * Initializes instance with supplied configuration.
	 * @tparam object config
	 *
	 * Supported configuration options:
	 * @arg @a url (string) server url
	 * @arg @a resultHandler (function) callback called on request result
	 * @arg @a actionDummySuffix (string) suffix to add to @c action form field
	 *		if present to override action with name of file pre-upload core request
	 *		(must not be empty)
	 */
	constructor: function (config) {
		var defaults = {
			url: null,
			resultHandler: null,
			actionDummySuffix: '-action-dummy'
		};
		this.config = $.extend(defaults, config);
		this.data = {};
	},
	/**
	 * Creates new @c iframe element with supplied ID and appends it to page body.
	 * @tparam string id iframe ID
	 * @treturn jQueryEl iframe element
	 */
	_createFrame: function (id) {
		return $('<iframe></iframe>')
			.attr('id', id)
			.attr('name', id)
			.appendTo('body')
			.hide();
	},
	/**
	 * Destroys iframe with supplied ID (if it's managed by this instance).
	 * @tparam string id iframe ID (== upload ID)
	 */
	_destroyFrame: function (id) {
		if (this.data[id] && this.data[id].frame) {
			this.data[id].frame.remove();
		}
	},
	/**
	 * Adjusts form to allow for file upload.
	 * @tparam string id ID of iframe to load request response to (== upload ID)
	 * @tparam jQueryEl form form to be submitted
	 * @treturn object original values of currently overwritten form attributes
	 */
	_adjustForm: function (id, form) {
		var defaultFormAttrs = {
			action: form.attr('action'),
			method: form.attr('method'),
			enctype: form.attr('enctype'),
			target: form.attr('target')
		};
		form.attr({
			action: this.config.url,
			method: 'post',
			enctype: 'multipart/form-data',
			target: id
		});
		$(':input[name=action]', form).attr('name', id + this.config.actionDummySuffix),
		$('<input type="hidden"/>').attr('name', 'action')
			.val('StoreUploads')
			.appendTo(form);
		return defaultFormAttrs;
	},
	/**
	 * Resets currently managed form to its original state.
	 * @tparam string id upload ID
	 */
	_resetForm: function (id) {
		if (this.data[id] && this.data[id].form) {
			var form = this.data[id].form.attr(this.data[id].formAttrs);
			var dummyInput = $(':input[name=' + id + this.config.actionDummySuffix + ']', form);
			if (dummyInput.length) {
				$(':input[name=action]', form).remove();
				dummyInput.attr('name', 'action');
			}
		}
	},
	/**
	 * Handles finished file upload.
	 * Parses response and calls either configured response handler in case of
	 * success, or stored failure handler. Destroys receiving iframe and resets
	 * form to its original state
	 * @tparam string id upload ID
	 */
	_uploaded: function (id) {
		var data = this.data[id],
			frameWindow = data.frame.get()[0].contentWindow,
			loaded = (frameWindow.location != 'about:blank'),
			response = frameWindow.document.body.innerHTML;
		this._destroyFrame(id);
		this._resetForm(id);
		delete this.data[id];
		if (loaded) {
			this.config.resultHandler(response, data.succeed, data.fail);
		} else {
			data.fail();
			//return 'No response received.';'
		}
	},
	/**
	 * Uploads files selected in supplied form.
	 * @tparam jQueryEl form
	 * @tparam function successCallback to be called on upload success
	 * @tparam function failureCallback to be called on upload failure
	 */
	upload: function (form, successCallback, failureCallback) {
		var id = asm.ui.Utils.getUniqueElementId();
		this.data[id] = {
			form: form,
			frame: this._createFrame(id),
			formAttrs: this._adjustForm(id, form),
			succeed: $.isFunction(successCallback) ? successCallback : $.noop,
			fail: $.isFunction(failureCallback) ? failureCallback : $.noop
		};

		if ((this.config.url === null) || (this.config.parser === null)) {
			this.data[id].fail();
			//return 'No upload handler script supplied.';
			//return 'No file upload response parser supplied.';
		}

		this.data[id].frame.bind('load', { uploadId: id }, $.proxy(function (event) {
			this._uploaded.call(this, event.data.uploadId);
		}, this));
	}
});