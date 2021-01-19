<?php
// Als er een error is dan voegt het aan de errors array toe
$errors = [];
if($naam == '') {
    $errors[] = 'Het veldnaam met naam mag niet leeg zijn.';
}
if($email == '') {
    $errors[] = 'Het veldnaam met e-mail mag niet leeg zijn.';
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Niet geldige email.";
    }
}
if($email == '') {
    $errors[] = 'Het veldnaam met aantal personen mag niet leeg zijn.';
}
if($datum == '') {
    $errors[] = 'Het veldnaam met datum mag niet leeg zijn.';
}
if($tijd == '') {
    $errors[] = 'Het veldnaam met tijd mag niet leeg zijn.';
}