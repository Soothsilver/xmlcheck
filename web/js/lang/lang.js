asm.lang = {
    general : {
        success : "Success",
        submit : 'Submit',
        loadingData : "Downloading data...",
        initializing: "Constructing HTML content...",
        adjusting : "Adjusting...",
        yes : "Yes",
        no : "No"
    },
    table : {
        footer_show : "Show",
        footer_rowsPerPage : "rows per page",
        removeFilter : "Remove filter",
        confirmFilter : "Confirm filter",
        clickToShowOrHide : "Click to show/hide table.",
        clearFilters : "Clear filters",
        addFilter : "Add filter",
        empty : "(empty)",
        cancelFilterCreation : "Cancel filter creation",
        firstPage : "First page",
        fivePagesBackward : "Five pages backwards",
        previousPage : "Previous page",
        currentPage : "Current page",
        nextPage : "Next page",
        fivePagesForward : "Five pages forwards",
        lastPage : "Last page",
        showHideFilters : "Show/Hide filters"
    },
    loginScreen : {
        caption : "Login",
        username : "Username",
        password : "Password",
        register : "Register",
        activate : "Activate",
        lostPassword : "Lost Password?",
        loginButton : "Login",
        back : "Back",
        passwordResetSuccessful : "Your password has been reset. You may now log in with your new password.",
        activationSuccessful: "Your user account has been activated.",
        registrationSuccessful: "An e-mail with an activation code has been sent to the e-mail address you provided. You will be able to use your user account only after it is activated."
    },
    registrationScreen : {
        caption : "Register New Account",
        fullName : "Full name",
        email : "Email",
        username : "Username",
        password : "Password",
        retypePassword : "Retype password",
        registerButton : "Register",
        fullnameHelp: "your first name and surname separated by space",
        emailHelp: "valid address is required for account activation",
        usernameHelp: "alphanumeric, at least " + asm.ui.constants.usernameMinLength + " characters",
        passwordHelp : "any characters; length at least " + asm.ui.constants.passwordMinLength,
        retypePasswordHelp : "must match the password above",
        retypePasswordError : "Password retyped incorrectly."
    },
    activationScreen : {
        caption : "Activate account",
        activationCode : "Activation code",
        activateButton : "Activate"
    },
    lostPasswordScreen : {
        caption : "Request a Password Reset Link",
        email : "E-mail address",
        resetButton : "Send a reset link",
        resetLinkSent : "A reset link has been sent to the e-mail address provided. It will be valid for the next 24 hours. Check your spam folder for the e-mail.",
        resetLinksSent : "Multiple user accounts are associated with this e-mail address. A reset link has been sent to all of them. Each e-mail specifies the user account it provides the reset link for. The reset links will be valid for the next 24 hours. Check your spam folder for the e-mails."
    },
    resetPasswordScreen : {
        caption : 'Choose New Password',
        resetLink : 'Reset Link',
        password : 'New password',
        retypePassword: 'Retype new password',
        passwordHint : "any characters; length at least " + asm.ui.constants.passwordMinLength,
        retypePasswordHint : 'must match the password above',
        retypePasswordError : 'Password retyped incorrectly.',
        submit : 'Set Password'
    },
    menu : {
        student : "Student",
        tutor : "Tutor",
        lecturer : "Lecturer",
        system : "System",
        settings : "Settings",

        studentAssignments : "Assignments",
        submissions : "Submissions",
        subscriptions : "Subscriptions",

        assignments : "Assignments",
        correction : "Rate Submissions",
        groups : "Groups",
        userRatings : "User Ratings",
        subscriptionRequests : "Subscription Requests",

        lectures : "Lectures",
        problems : "Problems",
        plugins : "Plugins",
        pluginTests : "Plugin Tests",
        questions : "Questions",
        attachments : "Attachments",
        tests : "Tests",

        changelog : "Changelog",
        systemLog : "System Log",
        uiLog : "UI Log",
        users : "Users",
        userTypes : "User Types",

        accountSettings : "Account settings",
        emailNotification : "Email notifications",
        userInterface : "User Interface",
        languageSettings : "Change Language",

        logout : "Logout"
    },
    home : {
        noTasks : 'There are no tasks requiring your attention at the moment.',
        noMotd :'There is no message of the day.' ,
        motd : 'Message of the day:',
        unconfirmedAssignments : 'assignment(s) with no confirmed submission',
        correctedButUnconfirmedSubmissions : 'corrected but unconfirmed submission(s)',
        unratedSubmissions : 'submission(s) waiting to be rated',
        subscriptionRequests : 'subscription request(s) pending',
        tasksRequireAttention : 'Following tasks require your attention:',
        currentGroupRatings : 'Current group ratings:',
        passwordChanged : 'Full name, e-mail and password changed.',
        passwordNotChanged : 'Full name and e-mail changed. Password remains the same.'
},
    userInterface : {
        caption : 'User Interface settings',
        visualTheme : 'Visual theme'
    },
    changelog: {
      loading: "Loading changelog..."
    },
    emailNotifications : {
        caption : 'Notify me via e-mail when these events occur',
        whenRated : 'When my submission is rated',
        whenGiven : 'When an assignment is given',
        whenStudentConfirms : 'When a student confirms',
        whenRatedHint : 'Send me an e-mail whenever a tutor rates my submission',
        whenGivenHint : 'Send me an e-mail whenever a new assignment appears in one of my groups',
        whenStudentConfirmsHint : '[Tutor only] Send me an e-mail whenever a student confirms a solution in my group',
        savedMessage : "Your e-mail notification settings have been saved."
    },

    accountSettings : {
        caption : 'User Account settings',
        fullname : '(*) Full name',
        email : '(*) Email',
        newPassword : 'New password',
        retypeNewPassword : 'Retype password',
        nameHint : 'first name and surname separated by space',
        passwordHint : 'leave blank to leave password unchanged; 6 to 20 characters',
        retypeHint : 'must match the password above',
        tooFewCharactersError : 'Password must have at least 6 characters.',
        tooManyCharactersError : 'Password must have at most 20 characters.',
        retypeError : 'Password retyped incorrectly.'
    },

    assignments: {
        currentAssignments : "Current assignments",
        pastAssignments : "Past assignments",
        tutorsAssignments : "Assignments you control",
        openAssignment : "open assignment",
        name : "Name",
        deadline : "Deadline",
        points : "Points",
        lecture : "Lecture",
        group : "Group",
        done : "Done",
        submitted : "submitted",
        reward : "Reward",
        problem : "Problem",
        rewardEdit : "Reward (points)",
        rewardHint : "maximum reward that can be gained for this assignment",
        addEditAssignmentCaption : "Add/Edit Assignment"
    },

    assignmentDetails : {
        caption : "Assignment details",
        problemName : "Problem name",
        deadline : "Deadline",
        reward : "Maximum reward",
        lecture : "Lecture",
        group : "Group",
        problemDescription : "Problem description",
        pluginDescription : "Auto-correct plugin description"
    },

    edit : {
        doYouReallyWantToDeleteThis_Before : "Do you really want to delete this ",
        doYouReallyWantToDeleteThis_After : "?",
        confirmDeletion : "Confirm deletion",
        add : "add",
        edit : "edit",
        remove : "remove"
    },

    subjects : {
        assignment : "assignment",
        pluginTest : "plugin test",
        plugin : "plugin",
        lecture : "lecture",
        group : "group",
        submission : "submission",
        user : "user",
        userType : "userType"
    },

    uiLog : {
        caption : "UI Log",
        timestamp : "Timestamp",
        type : "Type",
        message : "Message",
        details : "Details",
        notice : "notice",
        warning : "warning",
        error : "error",
        fatal : "fatal error"
    },
    pluginTests : {
        runNewTestCaption : "Run new test",
        description : "Description",
        plugin : "Plugin",
        pluginConfiguration : "Plugin configuration",
        pluginConfigurationHint : "enter values of plugin parameters separated by semicolons: ",
        pluginHasNoArguments : "plugin has no arguments",
        inputFile : "Input file:",
        inputFileHint : "ZIP archive with test input",
        completedTests : "Completed tests",
        runningTests : "Running tests",
        description: "Description",
        config : "Config",
        pluginDescription : "Plugin description",
        downloadInput : "download input",
        downloadOutput : "download output",
        details : "Details"
    },
    plugins : {
        name : "Name",
        caption : "Currently installed plugins",
        arguments : "Arguments",
        type : "Language",
        description : "Description",
        addPluginCaption : "Add plugin",
        file : "File",
        nameHint : "unique plugin name",
        fileHint : "ZIP archive containing plugin files and manifest"
    },
    problems : {
        caption : "Problems you control",
        name : "Name",
        description : "Description",
        lecture : "Lecture",
        editCaption : "Add/Edit Problem",
        lectureHint : "problem will be bound to this lecture",
        problemName : "Problem name",
        correctivePlugin : "Correction plugin",
        pluginConfiguration : "Plugin configuration",
        enterValuesSeparatedBySemicolon : "enter values of plugin arguments separated by a semicolon: ",
        descriptionHint : "line breaks will be preserved",
        pluginHasNoArguments : "plugin has no arguments",
        noPlugin : "[no automatic correction]"
    },
    lectures : {
        caption : "Lectures",
        name : "Name",
        description : "Description",
        showProblems : "Show problems for this lecture",
        editCaption : "Add/Edit Lecture",
        lectureName : "Lecture name",
        lectureNameHint : "unique lecture name"
    },
    subscriptions : {
        group : 'Group',
        description : "Description",
        lecture : "Lecture",
        status : "Status",
        activeAndRequestedSubscription : "Active and Requested Subscriptions",
        availableSubscriptions : "Available Subscriptions",
        type : "Privacy",
        cancelSubscription : "cancel subscription",
        addRequestSubscription : "add/request subscription",
        confirmSubscriptionCancellation : "Confirm Subscription Cancellation",
        confirmSubscriptionCancellationText : "If you unsubscribe, all your submissions for this group's assignments will be deleted and all points rewarded for them will be lost. Do you really want to unsubscribe from this group?",
        subscriptionRequests : "Subscription requests",
        realName : "User",
        email : "E-mail",
        permitRequest : "permit request",
        prohibitRequest : "prohibit request"
    },
    userType : {
        removalMessage : "All users of this type will be assigned type student.",
        editCaption : "Add/Edit User Type",
        name : "Name",
        nameHint : "enter unique usertype name"
    },
    groups : {
        editCaption : 'Add/Edit Group',
        lecture : "Lecture",
        lectureHint : "group will forever be bound to this lecture",
        groupName : "Group name",
        groupNameHint : "unique group name",
        description : "Description",
        public : "Public",
        publicHint : "any student can join this group without approval",
        caption : "Groups",
        name : "Name",
        type : "Type",
        showAssignments : "show assignments for this group",
        showRatings : "show user ratings for this group"
    },
    submissions : {
        addSubmissionCaption : "Add a submission",
        submissionFile : "Submission file",
        submissionFileHint : "ZIP archive per this assigment's description"
    },
    users : {
        caption : "Users",
        lastLogin: "Last Login",
        editCaption : 'Add/Edit User',
        username : "Username",
        usernameHint : "unique, alphanumeric, 5 to 15 characters",
        type : "Privileges",
        typeHint : "determines user's privileges",
        realName : "Full name",
        realNameHint : 'user\'s first name and surname separated by space',
        email : "E-mail",
        password : "Password",
        passwordHint : 'leave blank to leave password unchanged; 6 to 20 characters',
        retypePassword : "Retype password",
        retypePasswordHint: 'must match the password above',
        passwordTooShort : "Password must have at least 6 characters.",
        passwordTooLong :"Password must have at most 20 characters.",
        passwordRetypeError : 'Password retyped incorrectly.'
    },
    userRatings : {
        id : "ID",
        student : "Student",
        sum : "Sum",
        ownedByYou : "owned by you",
        showUsersSubmission : "show user's submission"
    },
    checks : {
        nameTakenBefore : "Name ",
        nameTakenAfter : " is already taken.",
        mustBeANumber : "must be a number",
        mustBeNumeric : "must be numeric",
        mustBeAlphabetic : "must contain only letters",
        mustBeAlphanumeric : "must be alphanumeric",
        mustContainOnlyLettersAndSpaces : "must contain only letters and spaces",
        mustBeEmail : "must be a valid e-mail address",
        mustBeDate : "must be a correctly formatted date",
        mustBeAtLeast : "has a minimum length of ",
        mustBeAtMost : "has a maximum length of ",
        mustHaveExtension : "must have one of the following extensions: ",
        mustBeGreater : "must be greater than ",
        mustBeLower : "must be less than ",
        mustNotBeEmpty : "must not be empty",
        thisValueIsNotAllowed : "This value is not allowed.",
        mustBeNonNegative : "must not be negative"

    },
    errors : {
        fatalError : 'Fatal Error',
        error : 'Error',
        warning : 'Warning',
        notice : 'Notice',
        pin : 'Pin',
        unpin : 'Unpin',
        hideError : 'Hide this.'
    },
    languageSettings : {
        caption : "Language Settings",
        language : "Language",
        languageHint : "saved as a cookie on this computer"
    }
};