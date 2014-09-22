asm.otherlangs = {};
asm.otherlangs.cs = {
    general : {
      success : 'Úspěch',
      submit : 'Potvrdit',
      loadingData: 'Stahování dat...',
      initializing: "Konstrukce HTML obsahu...",
      adjusting: 'Obnovení...',
      yes : "Ano",
      no : "Ne"
    },
    table : {
        footer_show : "Zobrazit",
        footer_rowsPerPage : "řádků na stránce",
        removeFilter : "Zrušit filtr",
        confirmFilter : "Potvrdit filtr",
        clickToShowOrHide : "Klikni pro zobrazení/skrytí tabulky.",
        clearFilters : "Zrušit všechny filtry",
        addFilter : "Přidat filter",
        empty : "(prázdná tabulka)",
        cancelFilterCreation : "Zrušit vytváření filtru",
        firstPage : "První stránka",
        fivePagesBackward : "O pět stránek zpět",
        previousPage : "Předchozí stránka",
        currentPage : "Aktuální stránka",
        nextPage : "Další stránka",
        fivePagesForward : "O pět stránek vpřed",
        lastPage : "Poslední stránka",
        showHideFilters : "Ukázat/skrýt filtry"
    },
    loginScreen : {
        caption : "Přihlašovací obrazovka",
        username : "Uživatelské jméno",
        password : "Heslo",
        register : "Registrace",
        activate : "Aktivování",
        lostPassword : "Ztracené heslo?",
        loginButton : "Přihlásit se",
        back : "Zpět",
        passwordResetSuccessful : "Vaše heslo bylo změněno. Můžete se nyní přihlásit s vaším novým heslem.",
        activationSuccessful: "Váš účet byl aktivován.",
        registrationSuccessful: "Email s aktivačním kódem byl odeslán na zadanou adresu. Přihlásit se můžete až po aktivaci."
    },
    registrationScreen : {
        caption : "Zaregistrovat nového uživatele",
        fullName : "Celé jméno",
        email : "Email",
        username : "Přihlašovací jméno",
        password : "Heslo",
        retypePassword : "Heslo (znovu)",
        registerButton : "Zaregistrovat",
        fullnameHelp: "křestní jméno a příjmení oddělené mezerou",
        emailHelp: "je vyžadována platná e-mailová adresa",
        usernameHelp: "alfanumerické, alespoň " + asm.ui.constants.usernameMinLength + " znaků",
        passwordHelp : "alespoň " + asm.ui.constants.passwordMinLength + " libovolných znaků",
        retypePasswordHelp : "musí být stejné jako heslo výše",
        retypePasswordError : "Hesla si neodpovídají."
    },
    changelog: {
    loading: "Načítám dokument..."
    },
    activationScreen : {
        caption : "Aktivovat uživatelský účet",
        activationCode : "Aktivační kód",
        activateButton : "Aktivovat"
    },
    lostPasswordScreen : {
        caption : "Požádat o odeslání odkazu na obnovu hesla",
        email : "Email",
        resetButton : "Poslat odkaz na obnovu hesla",
        resetLinkSent : "Odkaz pro obnovu hesla byl odeslán na zadanou adresu. Bude platný pro následujících 24 hodin. Zkontrolujte svojí složku pro spam.",
        resetLinksSent : "Tuto emailovou adresu používá více účtů. Odkaz na obnovu hesla byl poslán za každý z nich. Každý email má v předmětu napsáno, jaký účet obnovuje. Odkazy jsou platné pro následujících 24 hodin. Zkontrolujte svoji složku pro spam."

    },
    resetPasswordScreen : {
        caption : 'Vybratn nové heslo',
        resetLink : 'Kód na obnovu',
        password : 'Nové heslo',
        retypePassword: 'Nové heslo (znovu)',
        passwordHint : "alespoň " + asm.ui.constants.passwordMinLength + " libovolných znaků",
        retypePasswordHint : 'musí být stejné jako heslo výše',
        retypePasswordError : 'Hesla si neodpovídají.',
        submit : 'Nastavit'
    },
    menu : {
        student : "Student",
        tutor : "Cvičící",
        lecturer : "Přednášející",
        system : "Systém",
        settings : "Nastavení",

        studentAssignments : "Úkoly",
        submissions : "Řešení",
        subscriptions : "Členství",

        assignments : "Zadat úkoly",
        correction : "Oznámkovat řešení",
        groups : "Skupiny",
        userRatings : "Hodnocení studentů",
        subscriptionRequests : "Žádosti o členství",

        lectures : "Přednášky",
        problems : "Problémy",
        plugins : "Pluginy",
        pluginTests : "Testovat pluginy",
        questions : "Otázky",
        attachments : "Přílohy",
        tests : "Testy",

        changelog : "Changelog",
        systemLog : "Systémový log",
        uiLog : "Log UI",
        users : "Uživatelé",
        userTypes : "Druhy uživatelů",

        accountSettings : "Hlavní nastavení",
        emailNotification : "Emailové notifikace",
        userInterface : "Uživatelské rozhraní",
        languageSettings : "Změnit jazyk",

        logout : "Odhlásit se"
    },
    home : {
        noTasks : 'Žádné úkoly nyní nevyžadují vaši pozornost.',
        noMotd :'Žádná uvítací zpráva není nastavena.' ,
        motd : 'Uvítací zpráva:',
        unconfirmedAssignments : 'úkolů bez potvrzeného řešení',
        correctedButUnconfirmedSubmissions : 'opravených, ale nepotvrzených řešení',
        unratedSubmissions : 'neobodovaných řešení',
        subscriptionRequests : 'žádostí o členství k vyřešení',
        tasksRequireAttention : 'Následující situace vyžadují vaši pozornost:',
        currentGroupRatings : 'Vaše aktuální hodnocení:',
        passwordChanged : 'Celé jméno, e-mail a heslo byly změněny.',
        passwordNotChanged : 'Celé jméno a e-mail změněny. Heslo zůstává beze změny.'
    },
    userInterface : {
        caption : 'Nastavení uživatelského rozhraní',
        visualTheme : 'Vizuální téma'
    },
    emailNotifications : {
        caption : 'Upozornit na e-mail při následujících událostech',
        whenRated : 'Když je moje řešení oznámkováno',
        whenGiven : 'Když je zadán nový úkol',
        whenStudentConfirms : 'Když student odevzdá řešení',
        whenRatedHint : 'Poslat email, když cvičící oznámkuje moje řešení',
        whenGivenHint : 'Poslat email, když do jedné z mých skupin přibyde úkol',
        whenStudentConfirmsHint : '[Jen cvičící] Poslat email, kdykoliv student odevzdá řešení v mé skupině',
        submit : 'Potvrdit změny',
        savedMessage : "Vaše nastavení emailových notifikací byla uložena."
    },

    accountSettings : {
        caption : 'Hlavní nastavení',
        fullname : '(*) Celé jméno',
        email : '(*) Email',
        newPassword : 'Nové heslo',
        retypeNewPassword : 'Nové heslo (znovu)',
        nameHint : 'křestní jméno a příjmení oddělené mezerou',
        passwordHint : 'ponechat prázdné pro zachování starého hesla; 6 až 20 znaků',
        retypeHint : 'musí být stejné jako heslo výše',
        submit : 'Potvrdit změny',
        tooFewCharactersError : 'Heslo musí mít alespoň 6 znaků.',
        tooManyCharactersError : 'Heslo nesmí mít více než 20 znaků.',
        retypeError : 'Hesla si neodpovídají.'
    },

    assignments: {
        currentAssignments : "Aktuální úkoly",
        pastAssignments : "Dřívější úkoly",
        tutorsAssignments : "Úkoly pod vaší kontrolou",
        openAssignment : "otevřít úkol",
        name : "Jméno",
        deadline : "Termín",
        points : "Body",
        lecture : "Přednáška",
        group : "Skupina",
        done : "Dokončeno",
        submitted : "odevzdáno",
        reward : "Odměna",
        problem : "Problém",
        rewardEdit : "Odměna (maximální počet bodů)",
        rewardHint : "maximální počet bodů, který lze získat za tento úkol",
        addEditAssignmentCaption : "Přidat/upravit úkol"
    },

    assignmentDetails : {
        caption : "Podrobnosti o úkolu",
        problemName : "Jméno problému",
        deadline : "Termín",
        reward : "Maximální odměna",
        lecture : "Přednáška",
        group : "Skupina",
        problemDescription : "Popis problému",
        pluginDescription : "Popis opravujícího pluginu"
    },

    edit : {
        doYouReallyWantToDeleteThis_Before : "Opravdu chcete smazat tento objekt (",
        doYouReallyWantToDeleteThis_After : ")?",
        confirmDeletion : "Potvrdit smazání",
        add : "přidat",
        edit : "upravit",
        remove : "odstranit"
    },

    subjects : {
        assignment : "úkol",
        pluginTest : "test pluginu",
        plugin : "plugin",
        lecture : "přednášku",
        group : "skupinu",
        submission : "řešení",
        user : "uživatele",
        userType : "typ uživatele"
    },
    uiLog : {
        caption : "Log UI",
        timestamp : "Časová známka",
        type : "Druh",
        message : "Zpráva",
        details : "Podrobnosti",
        notice : "informace",
        warning : "varování",
        error : "chyba",
        fatal : "fatální chyba"
    },
    pluginTests : {
        runNewTestCaption : "Spustit nový test",
        description : "Popis",
        plugin : "Plugin",
        pluginConfiguration : "Parametry pluginu",
        pluginConfigurationHint : "hodnoty parametrů pluginu oddělené středníkem: ",
        pluginHasNoArguments : "plugin nemá žádné parametry",
        inputFile : "Vstupní soubor:",
        inputFileHint : "archiv ZIP s testovaným vstupem",
        completedTests : "Dokončené testy",
        runningTests : "Běžící testy",
        config : "Parametry",
        pluginDescription : "Popis pluginu",
        downloadInput : "stáhnout vstup",
        downloadOutput : "stáhnout výstup",
        details : "Podrobnosti"
    },
    plugins : {
        name : "Jméno",
        caption : "Nainstalované pluginy",
        arguments : "Parametry",
        type : "Jazyk",
        description : "Popis",
        addPluginCaption : "Přidat plugin",
        file : "Soubor",
        nameHint : "jedinečné jméno pluginu",
        fileHint : "archiv ZIP obsahující soubory pluginu a manifest"
    },
    problems : {
        caption : "Problémy pod vaší kontrolou",
        name : "Jméno",
        description : "Popis",
        lecture : "Přednáška",
        editCaption : "Přidat nebo upravit problém",
        lectureHint : "problém bude spojen s touto přednáškou",
        problemName : "Jméno problému",
        correctivePlugin : "Opravující plugin",
        pluginConfiguration : "Parametry pluginu",
        enterValuesSeparatedBySemicolon : "hodnoty parametrů pluginu oddělené středníkem: ",
        descriptionHint : "konce řádků budou zachovány",
        pluginHasNoArguments : "plugin nemá žádné parametry",
        noPlugin : "[bez automatické opravy]"
    },
    lectures : {
        caption : "Přednášky",
        name : "Jméno",
        description : "Popis",
        showProblems : "Zobrazit problémy z této přednášky",
        editCaption : "Přidat nebo upravit přednášku",
        lectureName : "Jméno přednášky",
        lectureNameHint : "jedinečné jméno přednášky"
    },
    subscriptions : {
        group : 'Skupina',
        description : "Popis",
        lecture : "Přednáška",
        status : "Stav",
        activeAndRequestedSubscription : "Aktivní členství a žádosti o členství",
        availableSubscriptions : "Skupiny, ke kterým se lze připojit",
        type : "Soukromí skupiny",
        cancelSubscription : "zrušit členství",
        addRequestSubscription : "přidat se nebo zažádat o členství",
        confirmSubscriptionCancellation : "Potvrdit zrušení členství",
        confirmSubscriptionCancellationText : "Pokud zrušíte členství, všechna vaše řešení pro tuto skupinu budou smazána a ztratíte všechny body v této skupině. Skutečně chcete zrušit své členství v této skupině?",
        subscriptionRequests : "Žádosti o členství",
        realName : "Uživatel",
        email : "E-mail",
        permitRequest : "povolit členství",
        prohibitRequest : "zamítnout členství"
    },
    userType : {
        removalMessage : "Všihcni uživatelé tohoto typu dostanou přidělený typ STUDENT.",
        editCaption : "Přidat nebo upravit typ uživatele",
        name : "Jméno",
        nameHint : "zadejte jedinečné jméno typu uživatele"
    },
    groups : {
        editCaption : 'Přidat nebo upravit skupinu',
        lecture : "Přednáška",
        lectureHint : "skupina bude vždy patřit této přednášce",
        groupName : "Jméno skupiny",
        groupNameHint : "jedinečné jméno skupiny",
        description : "Popis",
        public : "Veřejná?",
        publicHint : "kdokoliv se může připojit k této skupině bez svolení",
        caption : "Skupiny",
        name : "Jméno",
        type : "Soukromí",
        showAssignments : "zobrazit úkoly pro tuto skupinu",
        showRatings : "zobrazit hodnocení studentů v této skupině"
    },
    submissions : {
        addSubmissionCaption : "Odevzdat řešení",
        submissionFile : "Soubor s řešením",
        submissionFileHint : "archiv ZIP podle popisu úkolu"
    },
    users : {
        caption : "Uživatelé",
        lastLogin: "Poslední přihlášení",
        editCaption : 'Přidat nebo upravit uživatele',
        username : "Uživatelské jméno",
        usernameHint : "jedinečné, alfanumerické, 5 až 15 znaků",
        type : "Typ",
        typeHint : "určuje práva uživatele",
        realName : "Celé jméno",
        realNameHint : 'křestní jméno a příjmení oddělená mezerou',
        email : "Email",
        password : "Heslo",
        passwordHint : 'nechat prázdné pro zachování stávajícího hesla; 6 až 20 znaků',
        retypePassword : "Heslo (znovu)",
        retypePasswordHint: 'musí se shodovat s heslem výše',
        passwordTooShort : "Heslo musí mít alespoň 6 znaků..",
        passwordTooLong :"Heslo nesmí mít více než 20 znaků",
        passwordRetypeError : 'Hesla se neshodují.'
    },
    userRatings : {
        student : "Student",
        sum : "Součet",
        ownedByYou : "jste vlastníkem této skupiny",
        showUsersSubmission : "zobrazit řešení odevzdaná tímto studentem"
    },
    checks : {
        nameTakenBefore : "Jméno ",
        nameTakenAfter : " je již zabráno.",
        mustBeANumber : "musí být číslo",
        mustBeNumeric : "musí být číslo",
        mustBeAlphabetic : "musí obsahovat jen písmena",
        mustBeAlphanumeric : "musí obsahovat jen písmena a čísla",
        mustContainOnlyLettersAndSpaces : "musí obsahovat jen písmena a mezery",
        mustBeEmail : "musí být e-mailová adresa",
        mustBeDate : "musí být správně zformátované datum",
        mustBeAtLeast : "má minimální délku ",
        mustBeAtMost : "má maximální délku ",
        mustHaveExtension : "musí mít jednu z následujících přípon: ",
        mustBeGreater : "musí být větší než ",
        mustBeLower : "musí být menší než ",
        mustNotBeEmpty : "musí něco obsahovat",
        thisValueIsNotAllowed : "Tato hodnota není přípustná.",
        mustBeNonNegative : "musí být pozitivní nebo nula"
    },
    errors : {
        fatalError : 'Fatální chyba',
        error : 'Chyba',
        warning : 'Varování',
        notice : 'Informace',
        pin : 'Připnout',
        unpin : 'Odepnout',
        hideError : 'Skrýt toto oznámení.'
    },
    languageSettings : {
        caption : "Jazyková nastavení",
        language : "Jazyk",
        languageHint : "nastavení uloženo jako cookie na tomto počítači"
    }

};