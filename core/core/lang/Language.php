<?php
namespace asm\core\lang;

abstract class StringID
{
    const InvalidLogin = 0;
    const InsufficientPrivileges = 1;
    const UploadUnsuccessful = 2;
    const ServerSideRuntimeError = 3;
    const HackerError = 4;

    const MailError = 5;
    const DatabaseError = 6;
    const InvalidInput = 7;
    const FileSystemError = 8;
    const SessionInvalidated = 9;

    const ProblemNameExists = 10;
    const NoPluginUsed = 11;
}

class Language {

    private static function getLanguage()
    {
        if (isset($_COOKIE["language"]))
        {
            return $_COOKIE["language"];
        }
        else
        {
            return "en";
        }
    }
    private static function getCzech($textId)
    {
        switch($textId)
        {
            case StringID::ServerSideRuntimeError: return "Chyba na straně serveru";
            case StringID::InsufficientPrivileges: return "K této akci nemáte dostatečná oprávnění.";
            case StringID::InvalidLogin: return "Neexistující uživatel nebo chybné heslo. Je také možné, že jste ještě neaktivovali svůj účet.";
            case StringID::UploadUnsuccessful: return "Upload selhal. Zkuste uploadovat soubor znovu nebo zkuste uploadovat jiný soubor.";
            case StringID::HackerError: return "Neočekávaná chyba v reakci na vstupní data. Prosím kontaktujte administrátora a předejte mu co nejvíce informací o akci, o kterou jste se pokoušeli.";

            case StringID::MailError: return "E-mail se nepodařilo odeslat.";
            case StringID::DatabaseError: return "Dotaz do databáze se nepodařilo provést.";
            case StringID::InvalidInput: return "Zadaný vstup je neúplný nebo nekorektní. Opravte ho prosím podle zobrazených instrukcí.";
            case StringID::FileSystemError: return "Nepodařilo se provést operaci na souborovém systému. Administrátor by měl zkontrolovat přístupová práva k souborům.";
            case StringID::SessionInvalidated: return "Vaše relace již není platná. Možná jste byli příliš dlouho neaktivní nebo byl program aktualizován na vyšší verzi. Odhlašte se, obnovte stránku (Ctrl+F5) a znovu se přihlašte.";

            case StringID::ProblemNameExists: return "Problém s tímto jménem již existuje.";
            case StringID::NoPluginUsed: return "Není opravováno automaticky.";
        }
        return "TRANSLATION MISSING(" . self::getEnglish($textId) . ")";
    }
    private static function getEnglish($textId)
    {
        switch ($textId)
        {
            case StringID::ServerSideRuntimeError: return "Server-side runtime error";
            case StringID::InsufficientPrivileges: return "You do not have sufficient privileges to perform this action.";
            case StringID::InvalidLogin: return "This user does not exist or is not activated or the password is incorrect.";
            case StringID::UploadUnsuccessful: return "Upload failed. Try again or try submitting another file.";
            case StringID::HackerError: return "Unexpected error in reaction to input data. Please contact the administrator and give him as much information about the action you attempted as possible.";

            case StringID::MailError: return "E-mail could not be sent.";
            case StringID::DatabaseError: return "Database query was not successful.";
            case StringID::InvalidInput: return "Your input is incomplete or invalid. Please modify it in accordance with the displayed instructions.";
            case StringID::FileSystemError: return "A file system operation failed. The administrator should verify that correct access rights are set for relevant directories.";
            case StringID::SessionInvalidated: return "Your session has become invalid. Perhaps you were inactive for too long or the program was updated to a newer version. Please log out, refresh the page (Ctrl+F5) and log in again.";

            case StringID::ProblemNameExists: return "A problem with this name already exists.";
            case StringID::NoPluginUsed: return "This problem has no automatic grading.";
        }
        throw new \Exception("This string (" . $textId . ") does not exist.");
    }
    public static function get($textId)
    {
        $lang = self::getLanguage();
        switch($lang)
        {
            case "en":
                return self::getEnglish($textId);
            case "cs":
                return self::getCzech($textId);
            default:
                return "INVALID LANGUAGE CODE (" . self::getEnglish($textId) . ")";
        }
    }
}