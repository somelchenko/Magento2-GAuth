# Magento 2 Google Authenticator Login
Magento 2 Two-factor authentication uses Google Authenticator OTP.


Google Authenticator works with 2-Step Verification for your Google Account to provide an additional layer of security when signing in. 

Enable  Two-factor authentication for admin customer
![610fead922](https://user-images.githubusercontent.com/3199042/34573601-18e36418-f18e-11e7-92be-f727be42a504.png)

Enter your OTP code on login page
![0fe335dd2c](https://user-images.githubusercontent.com/3199042/34572305-80692450-f18a-11e7-97d7-c1c531d2ba5e.png)

## Installation

Install module. Run in masgetno root follder

`composer require somelchenko/gauthenticator`

`bin/magento setup:upgrade`

## Console

Disable two-factor authentication for customer

`bin/magento admin:user:disable-google-otp`

## Google Authenticator Apps

[Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2)

[iPhone](https://itunes.apple.com/us/app/google-authenticator/id388497605)

There are also older open source versions of the Google Authenticator app for both [iPhone](https://github.com/google/google-authenticator) and [Android](https://github.com/google/google-authenticator-android).
