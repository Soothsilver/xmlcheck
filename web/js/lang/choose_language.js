if (cookies.exists('language'))
{
    var displayLanguage = cookies.get('language');
    if (displayLanguage === 'cs')
    {
        asm.lang = $.extend(true, asm.lang, asm.otherlangs.cs);
    }
};
asm.lang.setLanguage = function(languageCode) {
  cookies.set('language', languageCode);
};