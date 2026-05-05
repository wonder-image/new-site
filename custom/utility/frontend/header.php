<?php
    /**
     * Header del sito.
     *
     * Legge le voci nav da custom/config/navigation.php (sorgente unica:
     * desktop + mobile usano lo stesso array).
     *
     * Per aggiungere una voce: aggiungi una entry in custom/config/navigation.php
     * + la label corrispondente in lang/{locale}/components.json sotto
     * components.navigation.{key}.
     *
     * Il rendering del singolo link è delegato a components/ui/nav-link.php.
     */

    $nav = require $_SERVER['DOCUMENT_ROOT'].'/custom/config/navigation.php';
?>
<header class="bg-primary">
    <div class="content">

        <a href="<?=__u()?>" class="p-r f-start h-80 c-h">
            <?=__ri($SOCIETY->logoWhite)
                    ->alt("Logo Bianco $SOCIETY->name")
                    ->addClass('h-100')
                    ->skeleton(false)
                    ->size(480)
                    ->render()?>
        </a>

        <div class="center phone-none">
            <div class="d-flex tx-white gap-4 tx-upper">
                <?php foreach ($nav as $item) :
                    $args = ['item' => $item, 'cssClass' => 'tx-none'];
                    include $_SERVER['DOCUMENT_ROOT'].'/custom/components/ui/nav-link.php';
                endforeach; ?>
            </div>
        </div>

        <div id="hamburger" class="c-h f-end pc-none tablet-none" onclick="menuMobile()">
            <div class="bar bar-1 bg-white"></div>
            <div class="bar bar-2 bg-white"></div>
            <div class="bar bar-3 bg-white"></div>
            <div class="bar bar-4 bg-white"></div>
            <div class="bar bar-5 bg-white"></div>
        </div>

    </div>
</header>

<section id="nav-mobile" class="pc-none tablet-none">
    <div class="bg" onclick="menuMobile()"></div>
    <div class="content bg-white">

        <div class="nav-list">
            <?php foreach ($nav as $item) :
                $args = ['item' => $item, 'cssClass' => 'nav'];
                include $_SERVER['DOCUMENT_ROOT'].'/custom/components/ui/nav-link.php';
            endforeach; ?>
        </div>

    </div>
</section>
