<?php
    /**
     * Sezione form contatto.
     *
     * Argomenti opzionali:
     * - title
     * - subtitle
     * - showMap
     */

    $title = $title ?? __t('components.forms.contact.title');
    $subtitle = $subtitle ?? __t('components.forms.contact.subtitle');
    $showMap = $showMap ?? true;
    
?>
<section id="contact-form">
    <div class="content mh-12 <?=!$showMap ? 'content-little' : ''?>">
        <div class="d-grid <?=!$showMap ? 'col-2' : 'col-5'?> col-p-1 gap-5 w-100">

            <?php if ($showMap) : ?>
                <div class="col-3 col-p-1 b-r-5 f-p-3-2 o-hidden">
                    <iframe class="bg bg-cover skeleton" title="Google Maps" src="https://www.google.com/maps/embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            <?php endif; ?>

            <div class="col-2 col-p-1">
                <form class="w-100 d-grid col-2 gap-5 gap-p-3 r-gap-p-5">
                    <input type="hidden" name="request_url" value="<?=$PAGE->url ?? ''?>">
                    <div class="col-2">
                        <div class="subtitle a-c"><?=$title?></div>
                        <div class="text mt-3 a-c"><?=$subtitle?></div>
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
                        <?=submit(__t('components.buttons.send'), 'send', 'btn-primary f-end', "formSubmit(this.form, '/resource/forms-contact/', contactFormSubmitResponse)")?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function contactFormSubmitResponse(data) {
        var message = '<?=addslashes(__t('notifications.649.text'))?>';

        if (!data || !data.success) {
            message = contactFormErrorMessage(data);
        }

        loadingResponse({
            success: !!(data && data.success),
            response: message
        });
    }

    function contactFormErrorMessage(data) {
        if (!data || data.response == null) {
            return '<?=addslashes(__t('components.buttons.retry'))?>';
        }

        if (typeof data.response === 'string') {
            return data.response;
        }

        if (data.response.errors && typeof data.response.errors === 'object') {
            var errors = Object.values(data.response.errors).filter(Boolean);

            if (errors.length > 0) {
                return errors[0];
            }
        }

        if (typeof data.response.message === 'string' && data.response.message !== '') {
            return data.response.message;
        }

        return '<?=addslashes(__t('components.buttons.retry'))?>';
    }
</script>

