<footer>
    <div class="content mh-10 mh-p-0">
        <div class="w-100 d-grid col-3 col-p-1 gap-12">

            <div>
                <?=__ri($SOCIETY->logoBlack)
                    ->alt("Logo Nero $SOCIETY->name")
                    ->addClass('p-r f-start w-60')
                    ->skeleton(false)
                    ->size(480)
                    ->render()?>
                <div class="text w-100 mt-6">
                    <b><?=$SOCIETY->legal_name?></b> <br>
                    <?=__t('components.terms.pi')?>: <b class="tx-none"><?=$SOCIETY->pi?></b>
                </div>
            </div>

            <div>
                <div class="w-100">
                    <div class="subtitle"><?=strtoupper(__t('components.terms.address'))?></div>
                    <div class="text mt-1">
                        <a href="<?=$SOCIETY->gmaps?>" target="_blank" rel="noopener noreferrer" class="tx-none">
                            <?=$SOCIETY->prettyAddress?>
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <div class="w-100">
                    <div class="subtitle"><?=strtoupper(__t('components.terms.contact'))?></div>
                    <div class="text mt-1">
                        <?=__t('components.terms.tel')?> <a href="tel:<?=$SOCIETY->tel?>" class="tx-none"><?=prettyPhone($SOCIETY->tel)?></a> <br>
                        <?=__t('components.terms.mail')?> <a href="mailto:<?=$SOCIETY->email?>" class="tx-none"><?=$SOCIETY->email?></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-small w-100 mt-10">
            <div class="w-50 w-p-100">
                <a href="<?=__r('legal.privacy-policy')?>" class="tx-none"><?=__t('components.navigation.privacy_policy')?></a> -
                <a href="<?=__r('legal.cookie-policy')?>" class="tx-none"><?=__t('components.navigation.cookie_policy')?></a> -
                <a href="<?=__r('legal.terms-conditions')?>" class="tx-none"><?=__t('components.navigation.terms_conditions')?></a>
            </div>
            <div class="w-50 a-r w-p-100 mt-p-10">
                <?=__t('components.terms.credit_by')?> <a href="https://www.wonderimage.it/" target="_blank" rel="noopener noreferrer">Wonder Image</a>
            </div>
        </div>

    </div>
</footer>
