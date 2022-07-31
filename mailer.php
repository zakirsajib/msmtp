<?php
/*********************
 *
 *  Mailer Functions
 * This function is to be used by a variety of other scripts that power the business (marketing, invoicing, etc.)
 *
 *********************/

/* What this script needs to be able to do in 2022
 * -----------------------------------------------
 *
 * - It needs to be able to run in a CLI environment, i.e. you would have a PHP app you run from CLI
 * which includes this file and calls its functions to send emails. This already works.
 * - Email sending should be accomplished using msmtp: https://en.wikipedia.org/wiki/Msmtp. This is a
 * fairly simple SMTP client you can use to send emails from the command line.
 * - It needs to send emails from an address in our Google Workspace org (aaron@commandmedia.dev).
 * - No secrets (i.e. passwords) should be stored in this code or in our repo, they have to come from somewhere
 * else. The script should document where they need to be.
 *
 * Tasks for dev
 * -------------
 *
 * 1. Get this script working on your local to send out an email via your Gmail account. This can be more
 * complicated than it seems, Gmail likes to make it hard [1].
 * 2. Document/provide an example config for getting it to send out email from our Google Workspace accounts
 * (e.g. aaron@commandmedia.dev). In theory this is very similar to sending through Gmail.
 * 3. Create a test case (could be as simple as another php file which includes this one and calls the function
 * with some test arguments).
 *
 * Notes
 * -----
 *
 * [1] https://pi3g.com/2020/10/15/gmail-workspace-gmail-suite-send-e-mail-from-server-using-msmtp/
 * [2] Currently the script attempts to send via aaroncommandmedia@gmail.com, chance that, we're not using that
 * address anymore.
 * [3] To get this working on a machine may require changes to PHP config and some sort of config file
 * (e.g. .msmtprc, I don't remember). It will also require clicking a bunch of settings in Google. Make sure to
 * document that whole process well. Put it in a README.md.
 *
 */


/* Setup steps (Ubuntu):
 *
 * $ sudo apt install msmtp ca-certificates
 * Change php-cli.ini sendmail_path to /usr/bin/msmtp
 * This list is likely incomplete!
 *
 */

/* Gmail server settings from a long time ago
 *
 * imap.gmail.com
 * Requires SSL: Yes
 * Port: 993

 * smtp.gmail.com
 * Requires SSL: Yes
 * Requires TLS: Yes (if available)
 * Requires Authentication: Yes
 * Port for SSL: 465
 * Port for TLS/STARTTLS: 587
 *
 */

// Send an email via Gmail or Google Workspace account using msmtp
// Idea: If configuring php to do this with mail() turns out to be a pain in the ass, maybe it
// would be OK to just exec() msmtp instead
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

        // Additional params
        //'--tls=on --auth=on --tls-trust-file=/etc/ssl/certs/ca-certificates.crt --host=smtp.gmail.com --port=587 --from="Aaron Patterson <aaroncommandmedia@gmail.com>" --user=aaroncommandmedia@gmail.com --passwordeval="echo THE_PASSWORD_WAS_HERE_BUT_SHOULDNT_BE" ' . $to_email


    );

    if (!$success) {
      //echo error_get_last()['message'];
      echo "Message could not be sent...";
    } else {
      echo "Email successfully sent.";
    }

}

// Example function call
// send_email('Johnny English', 'inquiries@commandmedia.net', 'I need some dev dudes');

?>
