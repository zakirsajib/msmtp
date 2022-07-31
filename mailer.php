<?php
/*********************
 *
 *  Mailer Functions
 *
 *********************/


function send_email($to_name, $to_email, $subject, $body)
{

    $success = mail(

        $to_name . " <" . $to_email . ">",

        // Subject
        $subject,

        // Body
        $body,



        '', // Additional headers

        $to_email

      
    );

    if (!$success) {
      echo "Message could not be sent...";
    } else {
      echo "Email successfully sent.";
    }

}

?>
