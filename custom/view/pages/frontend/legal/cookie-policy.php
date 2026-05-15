<?php

    $key = 'cookie_policy';

    $SQL = sqlSelect( 'legal_documents', [ 'doc_type' => $key, 'language_code' => __l(), 'active' => 'true' ], 1, 'published_at DESC, id', 'DESC' );

    if (!$SQL->exists) { exit; }

    $DOCUMENT = infoLegalDocument($SQL->id);

    $SEO->title = $DOCUMENT->name;
    $SEO->description = $DOCUMENT->name;
    $SEO->url = __u('legal/cookie-policy');

    \Wonder\View\View::layout('frontend.main');

?>

<section class="intro">
    <div class="content">

        <?= $DOCUMENT->renderContent ?>

    </div>
</section>

<?php \Wonder\View\View::end(); ?>
