<?php

    $BACKEND = true;
    $PRIVATE = true;
    $PERMIT = [];

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    require_once $ROOT."/vendor/wonder-image/app/wonder-image.php";

    require_once "set-up.php";

    $FILE_NAME = "Form-".date('Y-m-d-H-i');
    $ARRAY = [["Nome", "Cognome", "Telefono", "Email", "Iscrizione"]];

    $SQL = sqlSelect('rsvp', ['deleted' => 'false']);

    foreach ($SQL->row as $key => $row) {

        $eventi = "";

        $FORM = info('form', 'id', $row['id']);

        array_push($ARRAY, [
            $FORM->name,
            $FORM->surname,
            prettyPhone($FORM->phone),
            $FORM->email,
            $FORM->creation
        ]);

    }

    if ($_GET['file'] == 'csv') {
        arrayToCsv($ARRAY, $FILE_NAME);
    } else if ($_GET['file'] == 'xls') {
        arrayToXls($ARRAY, $FILE_NAME);
    }

?>