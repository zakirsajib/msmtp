# MSMTP Configuration in Mac Monterey 12.3.1 :reminder_ribbon: :reminder_ribbon:

This documents provides information:

1. how to send email from **google account** (i.e. youremail@gmail.com)
    using `msmtp`.
2. how to send email from **xxx account** (i.e.
    youremail@xxx.net) using `msmtp`.



> Change **youremail** and **xxx** to your own email address. :grinning:

# Table of Contents

1. [PHP Install](#php-install)
2. [Run PHP Server](#run-php-server)
3. [Install MSMTP](#install-msmtp)
4. [Download tls trust file](#download-tls-trust-file)
5. [Create password in Google account](#create-password-in-google-account)
6. [Test msmtp configuration with command](#test-msmtp-configuration-with-command)
7. [Configure php ini and run php application](#configure-php-ini-and-run-php-application)
8. [Password management](#password-management)


## PHP Install

**PHP is not available in mac Monterey!**

> So we need to download and install first.

we can use **Homebrew**.

> :warning: If we dont have Homebrew installed in machine then we can install it.

Copy this code and paste into terminal:

`/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`

Then Enter your system password.

It may also ask to install **xCode**. Allow it.

To verify **Homebrew** installed successfully, run

`brew help`

Now Add the **PHP formulae**:

`brew tap shivammathur/php`

Choose the PHP version – this example uses 7.4

`brew install shivammathur/php/php@7.4`

Link the PHP Version

`brew link --overwrite --force php@7.4`

And then verify

`php -v`

## Run PHP server

`php -s 127.0.0.1:8000`

It should start the PHP server in your system.

Go to `http://127.0.0.1:8000`


## Install MSMTP

Now Install `msmtp`.

`brew install msmtp`

Then the rest is just a matter of setting up the related configuration files

:information_source:

> System configuration file location is: `/usr/local/Cellar/msmtp/1.8.20/etc/msmtprc`
>
> If this file does not exist, you can create or create inside your root which is like this:

    /Users/zakirimac/.msmtprc


![location msmtprc](/images/msmtprc.jpg "location msmtprc")


Lets edit this file:  `/Users/zakirimac/.msmtprc`

Copy and paste following :

    # Begin msmtprc
    # Set default values for all following accounts.
    defaults
    tls on
    logfile ~/.msmtp.log

    # A first gmail address
    account youremail@gmail.com
    host smtp.gmail.com
    port 587
    protocol smtp
    auth on
    from youremail@gmail.com
    user youremail@gmail.com
    tls on
    tls_starttls on

    # Another Third party mail server
    account youremail@xxx.net
    host mail.xx.net
    port xxx
    protocol smtp
    auth on
    from youremail@xxx.net
    user youremail@xxx.net
    tls on
    tls_starttls off

    # this next line is crucial: you have to point to the correct security certificate.
    # If this doesn't work, check the mstmp documentation
    # at http://msmtp.sourceforge.net/documentation.html for help
    # This next line should all be on one long line:

    tls_trust_file /etc/ssl/certs/roots.cer

    # Set a default account
    # You need to set a default account for Mail
    account default : youremail@gmail.com

    # end msmtprc


Then **save** it.

> Please note: `msmtp` will use `account default : youremail@gmail.com` option. But if we want to use **Third party mail server** then we need to edit above `.msmtprc` file and use:

`account default : youremail@xxx.net`

## Download tls trust file

You can download Google Roots file from here:

    https://pki.google.com/roots.pem
After downloading into computer, it will be saved as `roots.cer` and then copy and paste in this location:

    /etc/ssl/certs/roots.cer


![location roots.cer file](/images/rootscer.jpg "location roots.cer")


You may follow this tutorial How to install the Securly SSL certificate on Mac OSX
https://support.securly.com/hc/en-us/articles/206058318-How-to-install-the-Securly-SSL-certificate-on-Mac-OSX-

## Create password in Google account

Read this tutorial to create App Passwords for sending email via msmtp.

https://support.google.com/accounts/answer/185833?hl=en
or
https://pi3g.com/2020/10/15/gmail-workspace-gmail-suite-send-e-mail-from-server-using-msmtp/
or follow this:

1.  Go to your  [Google Account](https://myaccount.google.com/).
2.  Select  **Security**.
3.  Under "Signing in to Google," select  **App Passwords**. You may need to sign in. If you don’t have this option, it might be because:
    1.  2-Step Verification is not set up for your account.
    2.  2-Step Verification is only set up for security keys.
    3.  Your account is through work, school, or other organization.
    4.  You turned on Advanced Protection.
4.  At the bottom, choose  **Select app**  and choose the app you using  ![and then](https://lh3.googleusercontent.com/3_l97rr0GvhSP2XV5OoCkV2ZDTIisAOczrSdzNCBxhIKWrjXjHucxNwocghoUa39gw=w36-h36) **Select device**  and choose the device you’re using  ![and then](https://lh3.googleusercontent.com/3_l97rr0GvhSP2XV5OoCkV2ZDTIisAOczrSdzNCBxhIKWrjXjHucxNwocghoUa39gw=w36-h36) **Generate**.
5.  Follow the instructions to enter the App Password. The App Password is the 16-character code in the yellow bar on your device.
6.  Tap  **Done**.

> Save this password in safe place. We need this later.


## Test msmtp configuration with command

    echo -e "Subject: Hey Zakir?\r\n\r\nHey Zakir did you receive this email? If yes then msmtp works in my mac." |msmtp --debug --from=default -t youremail@xxx.net

When you run this command, **it will ask you password.**

**Use the password you just generated from Google.**

**After entering password, press Enter button and email should sent.**

You can see `.msmtp.log` to see whats going on after that command. In `.msmtp.log` file you should see something like this:

    Jul 30 16:36:43 host=smtp.gmail.com tls=on auth=on user=youremail@gmail.com from=default recipients=youremail@xxx.net mailsize=146 smtpstatus=250 smtpmsg='250 2.0.0 OK  1659177403 f3-20020a170902ce8300b0016e2309bcf1sm2624652plg.13 - gsmtp' exitcode=EX_OK


So we can send email to anyone from our google email. But we did this by using the command in terminal:

    echo -e "Subject: Hey Zakir?\r\n\r\nHey Zakir did you receive this email? If yes then msmtp works in my mac." |msmtp --debug --from=default -t youremail@xxx.net


Now we want to send email from our php application.

## Configure php ini and run php application

First we need to tell `php.ini` where our `msmtp` is located.  Our `msmtp` is located here:

    /usr/local/bin/msmtp

You can run following command in terminal  to find out where is your `php.ini` file is located in your mac.

    php -i | grep php.ini

It will tell you something like this:

    Configuration File (php.ini) Path => /usr/local/etc/php/7.4
    Loaded Configuration File => /usr/local/etc/php/7.4/php.ini


![location php.ini file](/images/phpini.jpg "location php.ini")

Open the file and find this `sendmail_path`

And edit:

    sendmail_path ="/usr/local/bin/msmtp"

make sure `;` is removed before `sendmail_path ="/usr/local/bin/msmtp"`

And now go to `http://127.0.0.1:8000/` and enter.

In your terminal, it will ask the Google password. **Use the password you just generated from Google.**

If everything is configured correctly then email will be sent, otherwise you will see some error message.

If you see this: **Message could not be sent...** it means either your `msmtp` configuration was incorrect or something else. Your terminal window might show error message.

:heavy_exclamation_mark: Typical error message could be something like this: 

`msmtp: the server sent an empty reply`
`msmtp: could not send mail (account default from /Users/zakirimac/.msmtprc)
`

`Jul 30 19:29:16 host=mail.xxx.net tls=on auth=on user=youremail@xxx.net from=youremail@xxx.net recipients=youremail@xxx.net errormsg='the server sent an empty reply' exitcode=EX_PROTOCOL`

## Password management

We are not storing any password in `.msmtprc`. We will use `GnuPG` and will use `passwordeval`.

To do this, set up [GnuPG](https://www.gnupg.org/download/index.html), including `gpg-agent` to avoid having to enter the password every time. Then, create an encrypted password file for `msmtp`, as follows.

Create a secure directory with 700 permissions located on a tmpfs to avoid writing the unencrypted password to the disk. In that directory create a plain text file with the mail account password. Then, encrypt the file with your private key:

`$ gpg --default-recipient-self -e /path/to/plain/password`

Remove the plain text file and move the encrypted file to the final location, e.g. `~/.mail/.msmtp-credentials.gpg`.

Now in `~/.msmtprc` add:

`passwordeval  "gpg --quiet --for-your-eyes-only --no-tty --decrypt ~/.mail/.msmtp-credentials.gpg"`

Normally this is sufficient for a GUI password prompt to appear when sending a message.

For further details, please refer [this](https://wiki.archlinux.org/title/msmtp#Password_management).


Love from :bangladesh:
