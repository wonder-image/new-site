<header class="bg-primary">
    <div class="content">

        <a href="<?=$PATH->site?>" class="p-r f-start h-80 c-h">
            <img src="<?=$PATH->logoWhite?>" alt="Logo <?=$SOCIETY->name?>" class="h-100">
        </a>

        <div class="nav-list tx-white phone-none pl-4">
            <a href="<?=$PATH->site?>" class="nav">Home</a>
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

<section id="nav-mobile">
    <div class="bg" onclick="menuMobile()"></div>
    <div class="content bg-white">

        <div class="nav-list">
            <a href="<?=$PATH->site?>" class="nav">Home</a>
        </div>

    </div>
</section>