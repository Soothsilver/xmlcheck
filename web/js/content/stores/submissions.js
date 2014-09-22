asm.ui.globals.stores.submissions = new asm.ui.TableStore({
	cols: [
		'id',
		'problem',
		'deadline',
		'date',
		'status',
		'fulfillment',
		'details',
		'rating',
        'explanation',
		'hasOutput'
	],
	request: 'GetSubmissions'
});