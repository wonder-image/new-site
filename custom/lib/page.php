<?php

    /**
     * Factory per pagine frontend del progetto.
     *
     * Centralizza il boilerplate che oggi si ripete in ogni file index.php / demo.php
     * (require di wonder-image.php, set di $FRONTEND/$PRIVATE/$PERMIT, SEO defaults,
     * include head/body-start/header/footer/body-end).
     *
     * STATUS: 2a — additivo. Le pagine attuali non lo usano ancora.
     * Vedi custom/pages/_example.php per la sintassi.
     *
     * @param array $config {
     *     @type string $key          Chiave pagina (es. 'home', 'contact'). Default: 'home'.
     *                                Usata per leggere SEO da lang/{locale}/pages.json (pages.{key}.seo.*).
     *     @type bool   $frontend     Default: true.
     *     @type bool   $private      Default: false.
     *     @type array  $permit       Default: [].
     *     @type string $url_path     Path per __u(). Default: '' (homepage).
     *     @type array  $seo          Override SEO: ['title' => ..., 'description' => ..., 'url' => ...].
     *     @type array  $breadcrumb   Override breadcrumb. Default: [SEO->url => __t("components.navigation.{key}")].
     *     @type callable $render     Closure che stampa il contenuto della pagina.
     * }
     */
    function renderPage(array $config = []): void
    {
        $key = $config['key'] ?? 'home';

        $GLOBALS['FRONTEND'] = $config['frontend'] ?? true;
        $GLOBALS['PRIVATE']  = $config['private']  ?? false;
        $GLOBALS['PERMIT']   = $config['permit']   ?? [];

        if (!isset($GLOBALS['ROOT']) || empty($GLOBALS['ROOT'])) {
            $GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'];
        }

        require_once $GLOBALS['ROOT'].'/vendor/wonder-image/app/wonder-image.php';

        // I template inclusi (head.php, body-start.php, header.php, footer.php,
        // body-end.php) sono nati per essere caricati a TOP-LEVEL: leggono
        // direttamente $SEO, $SOCIETY, $PATH, $DEFAULT, $ANALYTICS, $DB,
        // $MYSQLI_CONNECTION, $USER, $ALERT, ecc. senza `global` declaration.
        //
        // Quando `renderPage()` è invocata da una route (cioè dentro a una
        // funzione), quei simboli sono globals che NON entrano automaticamente
        // nello scope della funzione: head.php farebbe `$PATH->css` su null,
        // crash.
        //
        // Importo tutti i legacy-globals registrati in `LegacyGlobals` (l'unica
        // fonte di verità sulla lista dei nomi) come variabili locali, by-ref,
        // così le modifiche fatte nei template (es. `$SEO->title = ...`) si
        // propagano correttamente al global.
        foreach (\Wonder\App\LegacyGlobals::names() as $__legacyKey) {
            if (array_key_exists($__legacyKey, $GLOBALS)) {
                $$__legacyKey = &$GLOBALS[$__legacyKey];
            }
        }

        // Variabili setup-globali NON registrate in LegacyGlobals ma usate
        // dai template (statistiche head.php, ecc.).
        foreach ([
            'ACTIVE_STATISTICS',
            'VISITOR_ID',
            'SESSION_ID',
            'REGISTERED_USER',
            'USER_ID',
            'NAV_BACKEND',
            'PAGE_KEY',
        ] as $__extraKey) {
            if (array_key_exists($__extraKey, $GLOBALS)) {
                $$__extraKey = &$GLOBALS[$__extraKey];
            }
        }

        $ROOT     = $GLOBALS['ROOT'];
        $ROOT_APP = $GLOBALS['ROOT_APP'];
        $SEO      = $GLOBALS['SEO'] ?? (object) [];
        $GLOBALS['PAGE_KEY'] = $key;
        $PAGE_KEY = $key;

        // SEO defaults (override possibile via $config['seo'])
        $SEO->title       = $config['seo']['title']       ?? __t("pages.{$key}.seo.title");
        $SEO->description = $config['seo']['description'] ?? __t("pages.{$key}.seo.description");
        $SEO->url         = $config['seo']['url']         ?? __u($config['url_path'] ?? '');
        $SEO->breadcrumb  = $config['breadcrumb']         ?? [
            $SEO->url => __t("components.navigation.{$key}"),
        ];

        $GLOBALS['SEO'] = $SEO;

        $renderContent = $config['render'] ?? null;

        ?>
        <!DOCTYPE html>
        <html lang="<?=__l()?>">
        <head>
            <?php include $ROOT_APP.'/utility/frontend/head.php'; ?>
        </head>
        <body>

            <?php include $ROOT_APP.'/utility/frontend/body-start.php'; ?>
            <?php include $ROOT.'/custom/utility/frontend/header.php'; ?>

            <?php if (is_callable($renderContent)) { $renderContent(); } ?>

            <?php include $ROOT.'/custom/utility/frontend/footer.php'; ?>
            <?php include $ROOT_APP.'/utility/frontend/body-end.php'; ?>

        </body>
        </html>
        <?php
    }
