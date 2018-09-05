<?php
    $filename = public_path()."/reports/report1.pdf";
    header("Content-type: application/pdf");
    header("Content-Length: " . filesize($filename));
    readfile($filename);
    exit;
?>

