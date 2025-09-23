<?php

    $PAGE_KEY ??= null;

    if ($PAGE_KEY != null) {
        
        $QUERY = sqlSelect('popup', "pages LIKE '%\"$PAGE_KEY\"%' AND visible = 'true' AND deleted = 'false'", 1, 'position', 'ASC', 'id, view');

        if ($QUERY->exists) {

            $sessionKey = "popup_$QUERY->id";

            if (!isset($_SESSION[$sessionKey])) {
                $_SESSION[$sessionKey] = 0;
            }

            if ($_SESSION[$sessionKey] < $QUERY->row['view'] || $QUERY->row['view'] == '') {
                
                $_SESSION[$sessionKey]++;

                $POPUP = info('popup', 'id', $QUERY->id);

                $imageHTML = empty(json_decode($POPUP->images, true)) ? '' : "<img src=\"{$POPUP->images[0]}\" alt=\"$POPUP->title\" class=\"p-r f-start w-100\">";
                $urlLabel = empty($POPUP->url_label) ? 'Scopri di più' : $POPUP->url_label;
                $urlHTML = empty($POPUP->url) ? '' : "<div class=\"wi-modal-footer b-0\"><div class=\"btn-group j-content-end\"><a class=\"btn btn-primary btn-arrow wi-close-modal\" href=\"$POPUP->url\"> $urlLabel  <i class=\"bi bi-chevron-right\"></i></a> </div></div>";

                echo "<section id=\"popup\" class=\"wi-modal no-interaction\">

                    <div class=\"bg wi-close-modal\"></div>

                    <div class=\"content wi-modal-content\">
                        <div class=\"wi-modal-header b-0\">
                            <div class=\"wi-modal-title subtitle\"> $POPUP->title </div>
                            <div class=\"wi-modal-close wi-close-modal\"> <i class=\"bi bi-x-lg\"></i> </div>
                        </div>
                        <div class=\"wi-modal-body no-scrollbar\"> 
                            $imageHTML
                        </div>
                        $urlHTML
                    </div>

                </section>
                <script> window.addEventListener('load', (event) => { modal('#popup'); }) </script>";

            }

        }

    }
