<?php
    /**
     * Barra legale del footer.
     * Link a privacy / cookie / terms + credit Wonder Image.
     *
     * STATUS: 2a — additivo.
     */
?>
<div class="text w-100 mt-10">
    <div class="w-50 w-p-100">
        <a href="<?=__u('legal/privacy-policy')?>" class="tx-none"><?=__t('components.navigation.privacy_policy')?></a> -
        <a href="<?=__u('legal/cookie-policy')?>" class="tx-none"><?=__t('components.navigation.cookie_policy')?></a> -
        <a href="<?=__u('legal/terms-conditions')?>" class="tx-none"><?=__t('components.navigation.terms_conditions')?></a>
    </div>
    <div class="w-50 a-r w-p-100 mt-p-10">
        <?=__t('components.terms.credit_by')?> <a href="https://www.wonderimage.it/" target="_blank" rel="noopener noreferrer">Wonder Image</a>
    </div>
</div>
