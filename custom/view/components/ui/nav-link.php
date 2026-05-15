<?php
    /**
     * Singolo link di navigazione, riusato in header desktop e nav mobile.
     *
     * Argomenti (in $args):
     * - item     : array   voce nav { key, url?, route?, external? } (richiesto)
     * - cssClass : string  classe CSS del link (default: 'tx-none')
     *
     * La label viene letta da lang/{locale}/components.json
     * (chiave: components.navigation.{key}).
     */
    $args     = $args ?? [];
    $item     = $args['item'];
    $cssClass = $args['cssClass'] ?? 'tx-none';

    if (!empty($item['external'])) {
        $href = $item['url'] ?? '';
    } elseif (!empty($item['route'])) {
        $href = __r($item['route']);
    } else {
        $href = __u($item['url'] ?? '');
    }

    $rel  = !empty($item['external']) ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
<a href="<?=$href?>" class="<?=$cssClass?>"<?=$rel?>>
    <?=__t("components.navigation.{$item['key']}")?>
</a>
