<html>

   <head>
      <title>Sending email using Msmtp</title>
   </head>

   <body>

      <?php
         require('mailer.php');
         send_email('Zakir', 'zakir@xxx.net', 'Hey Zakir? ', 'Hey Zakir did you receive this email? If yes then msmtp works in my mac.');

      /*

      this command works in terminal:
      echo -e "Subject: Hey Zakir?\r\n\r\nHey Zakir did you receive this email? If yes then msmtp works in my mac." |msmtp --debug --from=default -t zakir@xxx.net

      */

      ?>

   </body>
</html>
