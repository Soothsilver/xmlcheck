asm = window.asm || {};
asm.otherlangs = asm.otherlangs || {};
asm.otherlangs.cs = {
    general : {
      success : 'Úspěch',
      submit : 'Potvrdit',
      loadingData: 'Stahování dat...',
      initializing: "Konstrukce HTML obsahu...",
      adjusting: 'Obnovení...',
      yes : "Ano",
      no : "Ne",
      clickHere : "Klikněte sem..."
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
        lostPassword : "Zapomenuté heslo?",
        loginButton : "Přihlásit se",
        back : "Zpět",
        passwordResetSuccessful : "Vaše heslo bylo změněno. Můžete se nyní přihlásit s vaším novým heslem.",
        activationSuccessful: "Váš účet byl aktivován.",
        registrationSuccessful: "Email s aktivačním kódem byl odeslán na zadanou adresu. Přihlásit se můžete až po aktivaci."
    },
    registrationScreen : {
        caption : "Zaregistrovat nového uživatele",
        fullName : "Celé jméno",
        email : "E-mail",
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
        email : "E-mail",
        resetButton : "Poslat odkaz na obnovu hesla",
        resetLinkSent : "Odkaz pro obnovu hesla byl odeslán na zadanou adresu. Bude platný pro následujících 24 hodin. Zkontrolujte svojí složku pro spam.",
        resetLinksSent : "Tuto emailovou adresu používá více účtů. Odkaz na obnovu hesla byl poslán za každý z nich. Každý email má v předmětu napsáno, jaký účet obnovuje. Odkazy jsou platné pro následujících 24 hodin. Zkontrolujte svoji složku pro spam."

    },
    resetPasswordScreen : {
        caption : 'Vybrat nové heslo',
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
        correction : "Oznámkovat řešení (staré)",
        correctionAll : "Oznámkovat řešení",
        correctionAbsolutelyAll : "Zobrazit všechna řešení",
        correctionSeparated: "Oznámkovat řešení (nové)",
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

        changelog : "Seznam změn",
        uiLog : "Log UI",
        users : "Uživatelé",
        userTypes : "Druhy uživatelů",
        otherAdministration : "Jiná administrace",

        accountSettings : "Hlavní nastavení",
        emailNotification : "E-mailové notifikace",
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
        passwordChanged : 'Celé jméno, e-mail a heslo byly změněny. Nové jméno se v pravém horním rohu zobrazí po opětovném přihlášení.',
        passwordNotChanged : 'Celé jméno a e-mail změněny. Heslo zůstává beze změny. Nové jméno se v pravém horním rohu zobrazí po opětovném přihlášení.',
        points: "bodů"
    },
    userInterface : {
        caption : 'Nastavení uživatelského rozhraní',
        visualTheme : 'Vizuální téma'
    },
    emailNotifications : {
        caption : 'Upozornit na e-mail při následujících událostech',
        whenRated : 'Když je moje řešení oznámkováno',
        whenGiven : 'Když je zadán nový úkol',
        whenStudentConfirms : 'Když se požádá o známkování',
        whenRatedHint : 'Poslat e-mail, když cvičící oznámkuje moje řešení',
        whenGivenHint : 'Poslat e-mail, když do jedné z mých skupin přibyde úkol',
        whenStudentConfirmsHint : '[Jen cvičící] Poslat e-mail, kdykoliv student požádá o předčasné oznámkování',
        savedMessage : "Vaše nastavení emailových notifikací byla uložena."
    },

    accountSettings : {
        caption : 'Hlavní nastavení',
        fullname : '(*) Celé jméno',
        email : '(*) E-mail',
        newPassword : 'Nové heslo',
        retypeNewPassword : 'Nové heslo (znovu)',
        nameHint : 'křestní jméno a příjmení oddělené mezerou',
        passwordHint : 'ponechat prázdné pro zachování starého hesla; alespoň ' + asm.ui.constants.passwordMinLength + ' znaků.',
        retypeHint : 'musí být stejné jako heslo výše',
        submit : 'Potvrdit změny',
        tooFewCharactersError : 'Heslo musí mít alespoň ' + asm.ui.constants.passwordMinLength  + ' znaků.',
        tooManyCharactersError : 'Heslo nesmí mít více než ' + asm.ui.constants.passwordMaxLength + ' znaků.',
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
        addEditAssignmentCaption : "Přidat/upravit úkol",
        somethingSubmitted : "Řešení",
        somethingSubmittedYes : "odevzdáno",
        addSubmissionButAlreadyGradedMessage: "<b>Varování! </b>Za tento úkol jste již byli oznámkováni! Upload dalšího řešení sice automaticky nezruší vaši známku, váš cvičící ji ale pak může smazat a nahradit známkou za toto nové řešení, pokud uzná za vhodné.",
        addSubmissionButAlreadyExistsMessage: "Vaše nové řešení přepíše vaše starší řešení tohoto úkolu..",
        addSubmissionFirstTimeMessage: "Můžete uploadovat libovolné množství řešení. Cvičící vám opraví jen to nejnovější, a to až po termínu.",
        addSubmissionAfterDeadline : "<b>Poznámka. </b>Již je po termínu. Váš cvičící vás za pozdní odevzdání může penalizovat."
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
        userType : "typ uživatele",
        problem : "problém",
        question: "otázku",
        attachment: "přílohu",
        test : "test"
    },
    uiLog : {
        caption : "Záznam zpráv z uživatelského rozhraní",
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
        pluginConfigurationHint : "hodnoty parametrů pluginu oddělené středníkem: ",
        descriptionHint : "konce řádků budou zachovány",
        pluginHasNoArguments : "plugin nemá žádné parametry",
        noPlugin : "[bez automatické opravy]"
    },
    lectures : {
        caption : "Přednášky",
        name : "Jméno",
        description : "Popis",
        showProblems : "zobrazit problémy z této přednášky",
        editCaption : "Přidat nebo upravit přednášku",
        lectureName : "Jméno přednášky",
        lectureNameHint : "jedinečné jméno přednášky",
        showQuestions : "zobrazit otázky z této přednášky",
        showAttachments : "zobrazit přílohy z této přednášky",
        showTests : "zobrazit testy s otázkami z této přednášky"
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
        confirmSubscriptionCancellationText : "Skutečně chcete zrušit své členství v této skupině?",
        subscriptionRequests : "Žádosti o členství",
        realName : "Uživatel",
        email : "E-mail",
        permitRequest : "povolit členství",
        prohibitRequest : "zamítnout členství"
    },
    usertypes : {
        removalMessage : "Všem uživatelům tohoto typu bude přiřazen typ STUDENT.",
        editCaption : "Přidat nebo upravit typ uživatele",
        name : "Jméno",
        nameHint : "zadejte jedinečné jméno typu uživatele",
        caption: "Druhy uživatelů a jejich práva",
        users : "Uživatelé",
        subscriptions : "Členství ve skupinách",
        plugins : "Pluginy",
        assignments : "Úkoly",
        correction : "Známkování",
        lectures : "Přednášky",
        groups : "Skupiny",
        other : "Jiné",
        users_add : "přidat uživatele",
        users_explore : "zobrazit uživatele",
        users_editUsers : "upravovat uživatele",
        users_remove : "odstraňovat uživatele",
        usertypes_edit : "upravovat druhy uživatelů",
        subscriptions_joinpublic : "připojovat se k veřejným skupinám",
        subscriptions_requestprivate : "žádat o členství u soukromých skupin",
        subscriptions_joinprivate : "připojovat se k soukromým skupinám bez povolení",
        plugins_add : "přidat pluginy",
        plugins_explore : "zobrazovat pluginy",
        plugins_edit : "upravovat pluginy",
        plugins_remove : "odstraňovat pluginy",
        plugins_test: "spouštět testy pluginů",
        assignments_submit : "odevzdávat řešení úkolů",
        submissions_grade : "známkovat úkoly",
        submissions_viewAuthors : "zobrazovat autory řešení",
        submissions_regrade : "měnit počet bodů již oznámkovaných úkolů",
        lectures_add : "vytvářet přednášky",
        lectures_editOwn : "upravovat vlastní přednášky",
        lectures_editAll : "upravovat libovolné přednášky",
        groups_add : "vytvářet skupiny",
        groups_editOwn: "upravovat vlastní skupiny",
        groups_editAll : 'upravovat libovolné skupiny',
        other_administration : 'provádět jiné administrativní úkony'
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
        submissionFileHint : "archiv ZIP podle popisu úkolu",
        yourSubmissionsCaption : "Vaše řešení",
        gradedSubmissionsCaption : "Oznámkovaná řešení",
        problem : "Problém",
        deadline : "Termín",
        success : "%",
        uploaded : "Nahráno",
        details : "Podrobnosti",
        downloadSubmission : "stáhnout řešení",
        downloadOutput : "stáhnout výstup",
        handsOff : "upozornit cvičícího (klikněte, pokud chcete, aby tento úkol byl oznámkován i před termínem)",
        status : "Stav",
        statusNormal : "normální",
        statusLatest : "nejnovější",
        statusRequestingGrading : "učitel upozorněn",
        statusGraded : "oznámkováno",
        points : "Body",
        note : "Poznámka",
        handsOffCaption : "Ruce pryč",
        handsOffWarning : "Obyčejně by váš cvičící oznámkoval vaše nejnovější řešení a udělal by to někdy po termínu. Pokud ovšem chcete mít toto řešení oznámkováno již dříve, můžete cvičícího na tento fakt upozornit. Tím dáte právo cvičícímu váš úkol oznámkovat. Jakmile to udělá, již nemůžete svoje řešení změnit. <b>Je toto vaše finální řešení?</b>"
    },
    users : {
        caption : "Uživatelé",
        lastLogin: "Poslední přihlášení",
        editCaption : 'Přidat nebo upravit uživatele',
        username : "Uživatelské jméno",
        usernameHint : "jedinečné, alfanumerické, " + asm.ui.constants.usernameMinLength + ' až ' + asm.ui.constants.usernameMaxLength + " znaků",
        type : "Typ",
        typeHint : "určuje práva uživatele",
        realName : "Celé jméno",
        realNameHint : 'křestní jméno a příjmení oddělená mezerou',
        email : "E-mail",
        password : "Heslo",
        passwordHint : 'nechat prázdné pro zachování stávajícího hesla; alespoň ' + asm.ui.constants.passwordMinLength +" znaků",
        retypePassword : "Heslo (znovu)",
        retypePasswordHint: 'musí se shodovat s heslem výše',
        passwordTooShort : 'Heslo musí mít alespoň ' + asm.ui.constants.passwordMinLength  + ' znaků.',
        passwordTooLong : 'Heslo nesmí mít více než ' + asm.ui.constants.passwordMaxLength + ' znaků.',
        passwordRetypeError : 'Hesla se neshodují.'
    },
    userRatings : {
        id : "ID",
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
    },
    grading : {
        absolutelyAllCaption : "Úplně všechna řešení",
        legacyAwaitingGradingCaption : "Neoznámkovaná řešení",
        legacyGradedCaption : "Oznámkovaná řešení",
        downloadSubmission : "stáhnout řešení",
        downloadOutput : "stáhnout vygenerovaný výstup",
        gradeSubmission : "oznámkovat řešení",
        regradeSubmission : "změnit počet bodů oznámkovaného řešení",
        getPlagiarismInfo : "zobrazit informace o podobnosti s jinými domácími úkoly",
        problem: "Problém",
        group: "Skupina",
        fulfillment: "%",
        uploaded : "Nahráno",
        details: "Podrobnosti",
        author: "Autor",
        points: "Body",
        gradeSubmissionCaption: "Oznámkovat řešení",
        rating: "Počet bodů",
        noteToStudent: "Poznámka studentovi",
        rateButton: "Přidělit body",
        changeSubmissionRatingCaption : "Změnit přidělený počet bodů",
        changeButton : "Změnit",
        submittedLate : "Odevzdáno pozdě",
        submittedLateHint_1: 'Toto řešení bylo odevzdáno pozdě.\nTermín: ',
        submittedLateHint_2: "\nNahráno: ",
        submittedLateHint_3: "."
    },
    questions : {
        caption : "Otázky",
        text : "Text otázky",
        type : "Druh",
        options : "Možnosti",
        lecture : "Přednáška",
        generateNewTestCaption : "Vygenerovat nový test",
        description : "Popis",
        numberOfQuestions : "Počet otázek",
        questionsList : "Otázky",
        selectAndFilterQuestionsAbove : "Stiskněte na zaškrtávací tlačítko vedle každé otázky, která má být v testu.",
        editCaption : "Přidat nebo upravit otázku",
        textAnswer : "s otevřenou odpovědí",
        singleChoice : "jedna správná odpověď",
        multipleChoice : "více správných odpovědí",
        attachments : "Přílohy",
        firstCharacterWillBeUsedAsOptionSeparator : "první znak bude použit jako oddělovač možných odpovědí",
        questionBound : "otázka bude navždy spojená s touto přednáškou",
        check : "ano"
    },
    attachments : {
        caption : "Přílohy",
        name : "Jméno",
        type : "Druh",
        lecture : "Přednáška",
        editCaption : "Přidat nebo změnit přílohu",
        attachmentBound : "příloha bude navždy spojená s touto přednáškou",
        file : "Soubor",
        text : "text",
        image : "obrázek",
        code : "zdrojový kód",
        useImagesHint : 'nahrát lze soubory GIF, PNG, JPEG, JPG nebo BMP'
    },
    tests : {
        caption : "Testy",
        description : "Popis testu",
        lecture : "Přednáška",
        createNewTest : "vytvořit nový test",
        printTest : "vytisknout test",
        regenerateTest : "vygenerovat test znovu",
        testGeneratedSuccessfully : "Test byl úspěšně vygenerován."
    },
    otherAdministration: {
        reloadManifestsCaption : "Akce: Obnovení z manifestů",
        reloadManifestsButton : "Znovu načíst popisy pluginů z manifestů",
        reloadManifestsLabel: "O akci",
        reloadManifestsDescription: "Informace o pluginech se načítá ze souboru manifestu, když je plugin poprvé nahrán do systému. Pak, i když se soubor manifestu změní, v databázi (a tedy i v uživatelském rozhraní) zůstává popis starý. Použijte tuto akci pro znovunačtení popisů pluginů z manifestů do databáze."
    },
    submissionDetails: {
        formCaption: "O tomto řešení",
        realName: "Jméno studenta",
        email: "E-mail studenta",
        submissionStatus: "Stav řešení",
        pointsAwarded: "Přidělené body",
        autoCorrectDetails: "Výsledky automatického hodnocení",
        submissionDate: "Nahráno",
        infoLabel: "Nápověda",
        downloadLinkLabel : "Odkaz ke stažení",
        downloadLink : "Stáhnout toto řešení",
        info: "Tabulka na této stránce ukazuje řešení jiných studentů, kterým se toto řešení podobá. Fakt, že tabulka není prázdná, neznamená nutně, že student opisuje. Řešení, o nichž si systém myslí, že z nich bylo toto řešení pravděpodobně opsáno, jsou označená jako \"podezřelá\" and mají vysoké skóre podobnosti.",

        tableCaption: "Řešení, kterým se toto řešení podobá",

        downloadOlderSubmission: "stáhnout toto řešení",
        goToSubmission: "prozkoumat toto řešení",

        similarityScore : "Podobnost",
        similarityReport : "Podrobnosti",
        suspicious : "Podezřelá shoda",
        oldSubmissionStatus : "Stav",
        oldRealName : "Autor",
        oldDate : "Nahráno"

    }
};