# Mailer
A simple mailer which you can quickly apply in your batch life.

# License
Mailer is released under the MIT license.

# Usage

### Preparation #1
As preparation for usage, please build a phar app by Laravel Zero command:

```php
cd mailer # open the app directory
php mailer app:build
```

### Preparation #2
After build, please set up your email settings:

```php
./mailer set email "your.address@email.com"
./mailer set name "Your Name"
./mailer set username "your.smtp.username"
./mailer set password "your.smtp.password"
./mailer set host "your.smtp.server.host"
./mailer set port "587" # optional
```

### Prepatation #3
You need to create a template file for the email subject and body.
You can get example files by the below command:

```php
./mailer init
ls .
# you will see:
#   body.txt    body.html    subject.txt    mailer    recipients.csv
```

A template can use variables according to a csv with decoration of `<%` - `%>` (e.g. `<%name%>`, `<%email%>`)
You can add any variables directly on a csv, whose first row should be a list of variable names.

### Preparation #4
Create cache files of messages to be sent.
Caches will be created according to each recipient from a csv

```php
./mailer task
# or you can give a csv file name
./mailer task my-recipients.csv
```

### Send emails
Once you create message cache files, you have been ready to send mails.

```php
./mailer send
```

