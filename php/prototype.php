<?php
// lees het config-bestand
require_once 'config.inc.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if (isset($_POST['Submit']))
{
    $naam  = $_POST['naam'];
    $email = $_POST['email'];
    $aantal = $_POST['aantalpersonen'];
    $datum = $_POST['datum'];
    $tijd  = $_POST['tijd'];
    $telefoon = $_POST['telefoon'];
    $opmerking = $_POST['opmerking'];

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

    if(empty($errors))
    {
        // Now this data can be stored in de database
            $check1 = strtotime($datum);
            if (date('Y-m-d', $check1) == $datum) {
                $query = "INSERT INTO reservering (naam, email, aantalpersonen, datum, tijd, telefoon, opmerking)
                VALUES ('$naam', '$email', '$aantal', '$datum', '$tijd', '$telefoon', '$opmerking')";

                $result = mysqli_query($mysqli, $query);

                if ($result)
                {
                    $body = file_get_contents('./templates/contact-mail.html');
                    $body = str_replace('{naam}', $_POST['naam'], $body);
                    $body = str_replace('{datum}', $_POST['datum'], $body);
                    $body = str_replace('{tijd}', $_POST['tijd'], $body);
                    $body = str_replace('{aantal}', $_POST['aantalpersonen'], $body);
                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {

                        $mail->SMTPDebug = 2;

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'hrstudent768@gmail.com';
                        $mail->Password = 'E^14DD9gYqDa';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;

                        //Recipients
                        $mail->setFrom('hrstudent768@gmail.com', 'Mailer');
                        $mail->addAddress($_POST['email'], $_POST['naam'] );     // Add a recipient
                        //$mail->addAddress('ellen@example.com');               // Name is optional
                        $mail->addReplyTo('hrstudent768@gmail.com');

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Bedankt voor uw reservering.';
                        $mail->Body    = $body;
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                    header("Location:prototype.php");
                    exit;
                }
                else
                {
                    echo "Er ging iets mis bij het toevoegen!";
                }
            }
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Prototype</title>
</head>

<style>
.errors {
    color: red;
}
</style>
<body>

    <?php if(isset($errors)) { ?>

    <ul class="errors">
    <?php foreach ($errors as $error) { ?>
        <li><?= $error ?></li>
    <?php } ?>
    </ul>

    <?php } ?>

<form action="" method="post">

    <p> Voeg een reservering toe </p>
    <label for="naam">Naam:</label>
    <input name="naam" id="naam" type="text" placeholder="Vul hier je naam in" value="<?= isset($naam) ? htmlentities($naam) : '' ?>"> <br> <br>
    <label for="email">E-mail adres:</label>
    <input name="email" id="email" type="email" placeholder="Vul hier je e-mail adres in" value="<?= isset($email) ? htmlentities($email) : '' ?>"> <br> <br>
    <label for="aantalpersonen">Aantal Personen:</label>
    <input name="aantalpersonen" id="aantalpersonen" type="number" min="0" placeholder="Vul hier de aantal personen in" value="<?= isset($aantal) ? htmlentities($aantal) : '' ?>"> <br> <br>
    <label for="datum">Datum:</label>
    <input name="datum" id="datum" type="date" placeholder="" min="<?php echo date('Y-m-d'); ?>"/> <br> <br>
    <label for="tijd">Tijd:</label>
    <select name="tijd" size="1" id="choice">
        <option value="12:00 - 13:00">12:00-13:00</option>
        <option value="13:00 - 14:00">13:00-14:00</option>
        <option value="14:00 - 15:00">14:00-15:00</option>
        <option value="15:00 - 16:00">15:00-16:00</option>
    </select> <br> <br>
    <label for="telefoon">Telefoonnummer:</label>
    <input name="telefoon" id="telefoon" type="text" placeholder="Vul hier telefoonnummer in" value="<?= isset($telefoon) ? htmlentities($telefoon) : '' ?>"> <br> <br>
    <label for="opmerking">Opmerking:</label>
    <input name="opmerking" id="opmerking" type="text" placeholder="Vul hier je opmerking in" value="<?= isset($opmerking) ? htmlentities($opmerking) : '' ?>"> <br> <br>
    <input name="Submit" id="Submit" type="submit" placeholder="Voeg toe">

</form>


</body>
</html>
