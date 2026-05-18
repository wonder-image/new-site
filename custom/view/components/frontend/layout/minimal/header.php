<section class="pb-0 pt-5" style="z-index: 1;">
    <div class="content content-little">
        <a href="<?=$PATH->site?>" class="p-r f-start c-w" style="height: 40px;">
            <?=__ri($SOCIETY->logo)
                    ->alt("Logo $SOCIETY->name")
                    ->addClass('h-100')
                    ->skeleton(false)
                    ->size(480)
                    ->render()?>
        </a>
    </div>
</section>