<section>
    <div class="content content-medium">
        <div class="w-100 d-grid col-3 col-p-2 gap-6">

            <div class="text a-c col-p-2">
                <a href="<?=__r('home')?>"> <?=__t('components.buttons.back_site')?> </a>
            </div>

            <div class="text a-c">
                <a href="<?=__r('legal.privacy-policy')?>" target="_blank" rel="noopener noreferrer"> <?=__t('components.navigation.privacy_policy')?> </a>
            </div>

            <div class="text a-c">
                <a href="<?=__r('legal.terms-conditions')?>" target="_blank" rel="noopener noreferrer"> <?=__t('components.navigation.terms_conditions')?> </a>
            </div>

        </div>

        <div class="w-100 mt-8">
            <div class="c-w" style="width: 30px;height: 30px;">
                <?=__ri($SOCIETY->icon)
                        ->alt("Icona $SOCIETY->name")
                        ->fitContain()
                        ->skeleton(false)
                        ->size(480)
                        ->render()?>
            </div>
        </div>
    </div>
</section>