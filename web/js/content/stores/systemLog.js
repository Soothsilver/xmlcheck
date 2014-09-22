asm.ui.globals.stores.systemLog = new asm.ui.TableStore({
	cols: [
		'severity',
		'datetime',
		'cause',
		'effect',
		'details',
		'username',
		'ip',
		'host',
		'request'
	],
	request: 'GetSystemLog'
});