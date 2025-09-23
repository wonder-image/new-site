<?php 

    if (!isset($FOOTER_CONTACT) || (isset($FOOTER_CONTACT) && $FOOTER_CONTACT == true)) : 
    
        $FOOTER_CONTACT_MAP = !isset($FOOTER_CONTACT_MAP) || (isset($FOOTER_CONTACT_MAP) && $FOOTER_CONTACT_MAP == true) ? true : false;

?>
<section id="contact-form">
    <div class="content mh-12 <?=!$FOOTER_CONTACT_MAP ? 'content-little' : ''?>">
        <div class="d-grid <?=!$FOOTER_CONTACT_MAP ? 'col-2' : 'col-5'?> col-p-1 gap-5 w-100">

            <?php if ($FOOTER_CONTACT_MAP) : ?>
                <div class="col-3 col-p-1 b-r-5 f-p-3-2 o-hidden">
                    <iframe class="bg bg-cover skeleton" title="Google Maps" src="https://www.google.com/maps/embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            <?php endif; ?>

            <div class="col-2 col-p-1">
                <form class="w-100 d-grid col-2 gap-5 gap-p-3 r-gap-p-5">
                    <input type="hidden" name="request_url" value="<?=$PAGE->url?>">
                    <div class="col-2">
                        <div class="subtitle a-c">
                            <?=$FOOTER_CONTACT_TITLE ?? __t('components.forms.contact.title')?>
                        </div>
                        <div class="text mt-3 a-c">
                            <?=$FOOTER_CONTACT_SUBTITLE ?? __t('components.forms.contact.subtitle')?>
                        </div>
                    </div>
                    <?=text(__t('components.forms.fields.name.label'), 'name', '', 'required')?>
                    <?=text(__t('components.forms.fields.surname.label'), 'surname', '', 'required')?>
                    <div class="col-2">
                        <?=phone(__t('components.forms.fields.phone.label'), 'phone', '', 'required')?>
                    </div>
                    <div class="col-2">
                        <?=text(__t('components.forms.fields.email.label'), 'email', '', 'required')?>
                    </div>
                    <div class="col-2">
                        <?=textarea(__t('components.forms.fields.request.label'), 'request', '', 'required')?>
                    </div>
                    <div class="col-2">
                        <?=checkbox('', 'privacy', ["true" => ["label" => __t('components.forms.fields.privacy.label'), "attribute" => "required"]], 'checkbox', '');?>
                    </div>
                    <div class="col-2">
                        <?=inputRecaptcha()?>
                    </div>
                    <div class="col-2">
                        <?=submit(__t('components.buttons.send'), 'send', 'btn-primary f-end', "formSubmit(this.form)")?>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<?php endif; ?>

<footer>
    <div class="content mh-10 mh-p-0">
        <div class="w-100 d-grid col-3 col-p-1 gap-12">

            <div>
                <img src="<?=$PATH->logoWhite?>" alt="Logo <?=$SOCIETY->name?>" class="p-r f-start w-80">
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

    </div>
</footer>