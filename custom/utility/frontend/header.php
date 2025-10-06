<header class="bg-primary">
    <div class="content">

        <a href="<?=__u()?>" class="p-r f-start h-80 c-h">
            <img src="<?=$PATH->logoWhite?>" alt="Logo <?=$SOCIETY->name?>" class="h-100">
        </a>

        <div class="center phone-none">
            <div class="d-flex tx-white gap-4 tx-upper">
            <a href="<?=__u()?>" class="tx-none"> <?=__t("components.navigation.home")?> </a>
            <a href="<?=__u('contact')?>/contact/" class="tx-none"> <?=__t("components.navigation.contact")?> </a>
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
            <a href="<?=__u()?>" class="nav"> <?=__t("components.navigation.home")?> </a>
            <a href="<?=__u('contact')?>" class="nav"> <?=__t("components.navigation.contact")?> </a>
        </div>

    </div>
</section>