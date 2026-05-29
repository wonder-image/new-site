<?php
    /**
     * 
     * Sezione form contatto.
     *
     * Argomenti opzionali:
     * - title
     * - subtitle
     * - showMap
     *
     */

    use App\Resources\Request\RequestResource;
    use Wonder\Elements\Form\Components\Submit;

    $title    = $title    ?? __t('components.forms.contact.title');
    $subtitle = $subtitle ?? __t('components.forms.contact.subtitle');
    $showMap  = $showMap  ?? true;

    $requestUrl = isset($PAGE) && is_object($PAGE) ? (string) ($PAGE->url ?? '') : '';

?>
<section id="contact-form">
    <div class="content mh-12 <?= !$showMap ? 'content-little' : '' ?>">
        <div class="d-grid <?= !$showMap ? 'col-2' : 'col-5' ?> col-p-1 gap-5 w-100">

            <?php if ($showMap) : ?>
                <div class="col-3 col-p-1 b-r-5 f-p-3-2 o-hidden">
                    <iframe class="bg bg-cover skeleton" title="Google Maps" src="https://www.google.com/maps/embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            <?php endif; ?>

            <div class="col-2 col-p-1">

                <div class="a-c mb-4">
                    <div class="subtitle"><?= $title ?></div>
                    <div class="text mt-3"><?= $subtitle ?></div>
                </div>

                <form id="contact-form-el" action="" method="post" enctype="multipart/form-data" class="wi-form d-grid col-2 gap-5 w-100">

                    <?= RequestResource::getInput('request_url') ?>

                    <?= RequestResource::getInput('name') ?>
                    <?= RequestResource::getInput('surname') ?>

                    <div class="col-2">
                        <?= RequestResource::getInput('phone') ?>
                    </div>
                    <div class="col-2">
                        <?= RequestResource::getInput('email') ?>
                    </div>
                    <div class="col-2">
                        <?= RequestResource::getInput('request') ?>
                    </div>
                    <div class="col-2">
                        <?=RequestResource::getInput('accept_privacy_policy') ?>
                    </div>
                    <div class="col-2">
                        <?= RequestResource::getInput('recaptcha') ?>
                    </div>
                    <div class="col-2">
                        <?=  (new Submit('send'))
                            ->label(__t('components.buttons.send'))
                            ->class('btn btn-primary f-end')
                            ->onclick("formSubmit(this.form, '".__e('api.resource.requests.store')."', contactFormSubmitResponse)")
                            ->render(); 
                        ?>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script>

    function contactFormSubmitResponse(data) {

        var message = '<?= addslashes(__t('notifications.649.text')) ?>';

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
            return '<?= addslashes(__t('components.buttons.retry')) ?>';
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

        return '<?= addslashes(__t('components.buttons.retry')) ?>';

    }

</script>
