<?php
    /**
     * Voce di navigazione con eventuali figli.
     */

    $item = $item ?? [];
    $cssClass = $cssClass ?? 'tx-none';
    $hasChildren = !empty($item['children']) && is_array($item['children']);
?>
<?php if ($hasChildren) : ?>
<div class="nav-has-children">
    <?=\Wonder\View\View::component('frontend.ui.nav-link', [
        'item' => $item,
        'cssClass' => $cssClass,
    ])?>
    <div class="nav-children">
        <?php foreach ($item['children'] as $child) : ?>
            <?=\Wonder\View\View::component('frontend.ui.nav-item', [
                'item' => $child,
                'cssClass' => $cssClass,
            ])?>
        <?php endforeach; ?>
    </div>
</div>
<?php else : ?>
<?=\Wonder\View\View::component('frontend.ui.nav-link', [
    'item' => $item,
    'cssClass' => $cssClass,
])?>
<?php endif; ?>
