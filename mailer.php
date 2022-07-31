<?php
/*********************
 *
 *  Mailer Functions
 * This function is to be used by a variety of other scripts that power the business (marketing, invoicing, etc.)
 *
 *********************/


function send_email($to_name, $to_email, $subject, $body)
{

    $success = mail(

        // To (email must be repeated in additional params)
        $to_name . " <" . $to_email . ">",

        // Subject
        $subject,

        // Body
        $body,



        '', // Additional headers

        $to_email

      
    );

    if (!$success) {
      //echo error_get_last()['message'];
      echo "Message could not be sent...";
    } else {
      echo "Email successfully sent.";
    }

}

?>
