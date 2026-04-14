<?php

    $LEGAL = (object) array();
    $LEGAL->name = $SOCIETY->legal_name;
    $LEGAL->cf = $SOCIETY->cf;
    $LEGAL->pi = $SOCIETY->pi;
    $LEGAL->office = empty($SOCIETY->legal_street) ? $SOCIETY->address : $SOCIETY->addressLegal;
    $LEGAL->email = $SOCIETY->email;
    $LEGAL->phone = prettyPhone($SOCIETY->tel);
    $LEGAL->domain = $SOCIETY->domain;