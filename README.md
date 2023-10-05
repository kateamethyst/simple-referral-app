# About
This is a referrals application app that is similar with Dropbox's referral https://www.dropbox.com/referrals.For every successful referral (meaning you get a user to sign up using your referral link), you will get one point. This app is built on Laravel 8 and React.

#### Video
> https://www.loom.com/share/03fa88b7de034432a7a4ce01e6439d36

##### User Dashboard
![https://imgur.com/sZQwCC3](https://i.imgur.com/sZQwCC3.png)

##### Admin Dashboard

![https://imgur.com/QOR65CJ](https://i.imgur.com/QOR65CJ.png)


# Installation Instruction
#### Backend Setup
Run `composer install`
Update `.env` to configure email and database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=<port>
DB_DATABASE=coding_challenge
DB_USERNAME=<username>
DB_PASSWORD=<password>

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<username>
MAIL_PASSWORD=<password>
MAIL_ENCRYPTION=tls
```
Run `php artisan migrate --sed`
Run `php artisan serve`

#### Frontend Setup
Run `npm install`
Run `npm run dev`
Go to `http://127.0.0.1:8000/` to test the app.
Login as an admin with this credentials
```
admin@admin.com
password
```

#### Applicant
Ma. Angelica Concepcion
concepcionmaangelica@gmail.com


