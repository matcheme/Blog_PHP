<?php
     $to      = 'matchemee@yahoo.fr';
     $subject = "Confirmation d'inscription";
     $message = "Message de Confirmation d'inscription!";
     $headers = 'From: eliematcheme@gmail.com' . "\r\n" .
     'Reply-To: eliematcheme@gmail.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();

     mail($to, $subject, $message, $headers);
     echo "Inscription reussi!!..";
 ?>