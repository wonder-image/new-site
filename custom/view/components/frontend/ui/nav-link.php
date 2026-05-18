<?php
    /**
     * Singolo link di navigazione.
     */

    $item = $item ?? [];
    $cssClass = $cssClass ?? 'tx-none';

    if (!empty($item['external'])) {
        $href = $item['url'] ?? '';
    } elseif (!empty($item['route'])) {
        $href = __r($item['route']);
    } else {
        $href = __u($item['url'] ?? '');
    }

    $rel = !empty($item['external']) ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
<a href="<?=$href?>" class="<?=$cssClass?>"<?=$rel?>>
    <?=__t("components.navigation.{$item['key']}")?>
</a>
