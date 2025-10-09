<?php

    use Wonder\Localization\{ LanguageContext, TranslationProvider };

    # Imposto le lingue
    LanguageContext::addLangPath($ROOT.'/lang/')
        ::setLang('it');