# Magento2-GAuth
Magento 2 Two-factor authentication uses Google Authenticator OTP.


Google Authenticator works with 2-Step Verification for your Google Account to provide an additional layer of security when signing in. 

Enable  Two-factor authentication for admin customer
![c64c3e9c09](https://user-images.githubusercontent.com/3199042/34572618-4376ba48-f18b-11e7-9f64-afe2f014fc62.png)

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
