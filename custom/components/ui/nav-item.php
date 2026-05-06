<?php
    /**
     * Voce di navigazione (con eventuali figli).
     *
     * Wrapper attorno a `nav-link.php` che gestisce la subnav statica:
     * se la voce ha `children` (array di altre voci), produce un blocco
     * `<div class="nav-has-children">` con il link parent + un contenitore
     * `<div class="nav-children">` che ricicla questo stesso componente per
     * renderizzare ogni figlio (la struttura supporta sub-sub-nav).
     *
     * Se la voce NON ha children, delega direttamente a `nav-link.php`.
     *
     * Lo stile (dropdown desktop, accordion mobile, ecc.) è responsabilità
     * del designer: si può targettizzare via le classi `.nav-has-children`,
     * `.nav-children`, e la classe del link passata in `$args['cssClass']`.
     *
     * Argomenti (in $args):
     * - item     : array   voce nav { key, url, external?, children? } (richiesto)
     * - cssClass : string  classe CSS del link (default: 'tx-none')
     *
     * Convenzione children:
     * Ogni figlio è una voce con la stessa struttura del parent (key, url,
     * external?, children?). La ricorsione è intenzionale.
     */
    $args     = $args ?? [];
    $item     = $args['item'];
    $cssClass = $args['cssClass'] ?? 'tx-none';

    $hasChildren = !empty($item['children']) && is_array($item['children']);
?>
<?php if ($hasChildren) : ?>
<div class="nav-has-children">
    <?php
        $args = ['item' => $item, 'cssClass' => $cssClass];
        include __DIR__.'/nav-link.php';
    ?>
    <div class="nav-children">
        <?php foreach ($item['children'] as $child) :
            $args = ['item' => $child, 'cssClass' => $cssClass];
            include __DIR__.'/nav-item.php';
        endforeach; ?>
    </div>
</div>
<?php else : ?>
<?php
    $args = ['item' => $item, 'cssClass' => $cssClass];
    include __DIR__.'/nav-link.php';
?>
<?php endif; ?>
