<?php
    /**
     * Singolo link di navigazione, riusato in header desktop e nav mobile.
     *
     * Argomenti (in $args):
     * - item     : array   voce nav { key, url, external? } (richiesto)
     * - cssClass : string  classe CSS del link (default: 'tx-none')
     *
     * La label viene letta da lang/{locale}/components.json
     * (chiave: components.navigation.{key}).
     */
    $args     = $args ?? [];
    $item     = $args['item'];
    $cssClass = $args['cssClass'] ?? 'tx-none';

    $href = !empty($item['external']) ? $item['url'] : __u($item['url']);
    $rel  = !empty($item['external']) ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
<a href="<?=$href?>" class="<?=$cssClass?>"<?=$rel?>>
    <?=__t("components.navigation.{$item['key']}")?>
</a>
