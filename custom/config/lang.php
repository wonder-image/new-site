<?php

    use Wonder\Localization\{ LanguageContext, TranslationProvider };

    # Imposto le lingue
    LanguageContext::addLangPath($ROOT.'/lang/')
        ::setLang('it');

    TranslationProvider::setGlobals([
        'path_privacy_policy' => __r('legal.privacy-policy'),
        'path_cookie_policy' => __r('legal.cookie-policy'),
        'path_terms_conditions' => __r('legal.terms-conditions'),
    ]);
