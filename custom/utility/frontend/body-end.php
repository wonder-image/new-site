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
