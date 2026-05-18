<?php include $ROOT_APP.'/view/components/frontend/layout/body-start.php'; ?>

<?=\Wonder\View\View::component('frontend.overlay.popup', [
    'pageKey' => $PAGE_KEY ?? null,
])?>
