<?php 

    $id ??= null;
    $title ??= null;
    $text ??= null;
    $footerText ??= null;
    $method ??= 'POST';

    \Wonder\View\View::layout('frontend.minimal'); 
    
?>

    <section>
        <div class="content content-little">

            <?php if (!empty($title)) { echo '<div class="subtitle">'.$title.'</div>'; } ?>
            <?php if (!empty($text)) { echo '<div class="text mt-3">'.$text.'</div>'; } ?>
            
            <form id="<?= $id ?>" method="<?= $method ?>" class="p-r f-start w-100 d-grid gap-6 gap-p-3 mt-p-3 col-4 col-p-2" method="post" onsubmit="loadingSpinner()">
                
                <?=$PAGE_CONTENT?>

            </form>

            <?php if (!empty($footerText)) { echo '<div class="text-small b-r-5 bg-light p-5 a-c mt-6 mt-p-3">'.$footerText.'</div>'; } ?>

        </div>
    </section>
    
<?php \Wonder\View\View::end(); ?>
