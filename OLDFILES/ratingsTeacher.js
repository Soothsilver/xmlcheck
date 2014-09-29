asm.ui.globals.stores.ratingsTeacher = new asm.ui.TableStore({
	cols: [
		'user',
		'email',
		'groupId',
		'rating',
		'group',
		'groupDescription',
		'lecture',
		'lectureDescription'
	],
	request: 'GetTeacherRatingSums'
});