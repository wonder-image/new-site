<?php
    /**
     * Popup associato alla pagina corrente.
     */

    $pageKey = $pageKey ?? null;

    if ($pageKey === null) {
        return;
    }

    $query = sqlSelect(
        'popup',
        "pages LIKE '%\"$pageKey\"%' AND visible = 'true' AND deleted = 'false'",
        1,
        'position',
        'ASC',
        'id, view'
    );

    if (!$query->exists) {
        return;
    }

    $sessionKey = "popup_$query->id";
    $_SESSION[$sessionKey] = $_SESSION[$sessionKey] ?? 0;

    $maxView = $query->row['view'];
    if ($maxView !== '' && $_SESSION[$sessionKey] >= (int) $maxView) {
        return;
    }

    $_SESSION[$sessionKey]++;

    $popup = info('popup', 'id', $query->id);
    $images = json_decode($popup->images, true) ?: [];
    $image = $images[0] ?? null;
    $urlLabel = empty($popup->url_label) ? 'Scopri di piu' : $popup->url_label;
?>
<section id="popup" class="wi-modal no-interaction">

    <div class="bg wi-close-modal"></div>

    <div class="content wi-modal-content">
        <div class="wi-modal-header b-0">
            <div class="wi-modal-title subtitle"><?=$popup->title?></div>
            <div class="wi-modal-close wi-close-modal"><i class="bi bi-x-lg"></i></div>
        </div>
        <div class="wi-modal-body no-scrollbar">
            <?php if ($image !== null) : ?>
                <img src="<?=$image?>" alt="<?=$popup->title?>" class="p-r f-start w-100">
            <?php endif; ?>
        </div>
        <?php if (!empty($popup->url)) : ?>
            <div class="wi-modal-footer b-0">
                <div class="btn-group j-content-end">
                    <a class="btn btn-primary btn-arrow wi-close-modal" href="<?=$popup->url?>">
                        <?=$urlLabel?> <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</section>
<script>window.addEventListener('load', () => { modal('#popup'); })</script>
