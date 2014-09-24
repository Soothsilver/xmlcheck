/**
 * @file
 * Namespace and global variable declarations.
 *
 * @namespace asm
 * Namespace for the whole @projectname project.
 *
 * @namespace asm::ui
 * Contains all @projectname GUI classes and "global" variables.
 *
 * @namespace asm::ui::editor
 * Contains all @ref asm.DynamicTableEditor "table editor" panels.
 *
 * @namespace asm::ui::form
 * Contains all @ref asm.DynamicForm "form" panels.
 *
 * @namespace asm::ui::panel
 * Contains all miscellaneous panels (special content panels and containers).
 * 
 * @namespace asm::ui::table
 * Contains all @ref asm.DynamicTable "table" panels.
 */
asm = window.asm || {};
asm.ui = asm.ui || {};
asm.ui.editor = asm.ui.editor || {};
asm.ui.form = asm.ui.form || {};
asm.ui.panel = asm.ui.panel || {};
asm.ui.table = asm.ui.table || {};
asm.ui.constants = {
    passwordMinLength: 5,
    passwordMaxLength: 200,
    usernameMinLength: 5,
    usernameMaxLength: 200
}

asm.ui.globals = {
	stores: {},
	appName: 'XML Check',
	coreUrl: './core/request.php',
	defaults: {
		theme: 'ui-lightness'
	},
	icons: {
		account: 'contact',
		activate: 'scissors',
		attachment: 'contact',
		add: 'plus',
		assignment: 'calendar',
		back: 'arrowreturnthick-1-w',
		cancel: 'close',
		confirm: 'check',
		create: 'plusthick',
		'delete': 'trash',
		downloadInput: 'circle-arrow-n',
		downloadOutput: 'circle-arrow-s',
		edit: 'pencil',
		group: 'link',
		lecture: 'bookmark',
		log: 'script',
		login: 'key',
		logout: 'locked',
		plugin: 'gear',
		print: 'print',
		problem: 'document',
		question: 'comment',
		rating: 'tag',
		register: 'plusthick',
		results: 'script',
		settings: 'wrench',
		subscription: 'signal-diag',
		submissionDraft: 'mail-open',
		submission: 'mail-closed',
		submissionRated: 'mail-open',
		test: 'clock',
		user: 'person',
		usertype: 'key',
		xtest: 'document-b',
		xtestGenerate: 'refresh',
        lostPassword: 'key'
	},
	sessionTimeout: 2 * 60 * 60 * 1000, // 2 hours
	themes: ['black-tie', 'blitzer', 'cupertino', 'dark-hive', 'dot-luv', 'eggplant',
		'excite-bike', 'flick', 'hot-sneaks', 'humanity', 'le-frog', 'mint-choc',
		'overcast', 'pepper-grinder', 'redmond', 'smoothness', 'south-street',
		'start', 'sunny', 'swanky-purse', 'trontastic', 'ui-darkness', 'ui-lightness',
		'vader'],
	privilegesBreakdown: {
		users: {
			add: ['usersAdd', 'plus'],
			explore: ['usersExplore', 'search'],
			edit: ['usersManage', 'pencil'],
			remove: ['usersRemove', 'trash'],
			'edit types of': ['usersPrivPresets', 'wrench']
		},
		subscriptions: {
			'public': ['groupsJoinPublic', 'unlocked'],
			'request private': ['groupsRequest', 'comment'],
			'private': ['groupsJoinPrivate', 'locked']
		},
		plugins: {
			add: ['pluginsAdd', 'plus'],
			explore: ['pluginsExplore', 'search'],
			edit: ['pluginsManage', 'pencil'],
			remove: ['pluginsRemove', 'trash'],
			test: ['pluginsTest', 'gear']
		},
		assignments: {
			submit: ['assignmentsSubmit', 'mail-closed']
		},
		submissions: {
			correct: ['submissionsCorrect', 'tag'],
			'view authors of': ['submissionsViewAuthors', 'person'],
			're-rate': ['submissionsModifyRated', 'pencil']
		},
		lectures: {
			add: ['lecturesAdd', 'plus'],
			'edit own': ['lecturesManageOwn', 'pencil'],
			'edit all': ['lecturesManageAll', 'note']
		},
		groups: {
			add: ['groupsAdd', 'plus'],
			'edit own': ['groupsManageOwn', 'pencil'],
			'edit all': ['groupsManageAll', 'note']
		},
		log: {
			explore: ['systemLogExplore', 'script']
		}
	},
	supportedBrowsers: {
        // This is how jMigrate plugin reports Chrome now.
		chrome: {
			name: 'Google Chrome',
			flag: 'chrome',
			style: 'webkit',
			link: 'http://www.google.com/chrome'
		},
        // This is how jQuery reported Chrome previously.
        webkit: {
            name: 'Google Chrome (as webkit)',
            flag: 'webkit',
            style: 'webkit',
            link: 'http://www.google.com/chrome'
        },
		firefox: {
			name: 'Mozilla Firefox',
			flag: 'mozilla',
			style: 'mozilla',
			link: 'http://www.mozilla.com/firefox'
		},
		opera: {
			name: 'Opera',
			flag: 'opera',
			link: 'http://www.opera.com/download/'
		},
		msie: {
			name: 'Internet Explorer 9+',
			flag: 'msie',
			version: /^9./,
			link: 'http://www.beautyoftheweb.com/'
		}
	}
};