<?php
    /**
     * Footer del sito (puro layout, senza form contatto).
     *
     * Variabili disponibili in scope: $SOCIETY (set dal framework).
     *
     * Per il form contatto vedi: custom/components/sections/contact-form.php
     * Per la barra legale       vedi: custom/components/layout/legal-bar.php
     *
     * STATUS: 2a — additivo. Non ancora incluso da custom/utility/frontend/footer.php.
     */
?>
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

        <?php include __DIR__.'/legal-bar.php'; ?>

    </div>
</footer>
