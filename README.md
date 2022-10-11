# Postmark API Client for Laravel apps

## Installation
You can install this package using composer:

```bash
composer require ixdf/laravel-postmark-api
```

### Configuration
All requests to Postmark’s API require you to authenticate yourself to the service. In order to do this you must send the correct HTTP header with the correct API token. So, once the package is installed, you need to add a `POSTMARK_TOKEN` key to your `.env` file. You can get your API Token from the [Postmark API Tokens tab](https://account.postmarkapp.com/api_tokens).


## Postmark API
At this moment, this package provides two APIs: [`emails`](https://postmarkapp.com/developer/api/email-api) and [`templates`](https://postmarkapp.com/developer/api/templates-api).

All API calls are managed by the `Postmark` facade.


### Email API
This API is responsible for sending emails with Postmark through a specific server.

To get access to the `emails` API, you must use the `messages` method, available with the `Postmark` facade:

```php
\Ixdf\Postmark\Facades\Postmark::messages();
```
This returns a `MessageApi` contract, which is responsible for handling emails.

#### Sending single emails
To send single emails, you should use the `send` method, which accepts a `$message` argument, that must be an instance of `Ixdf\Postmark\Api\Message\Requests\Message`:


```php
use Ixdf\Postmark\Facades\Postmark;
use Ixdf\Postmark\Api\Message\Requests\Message;

$message = (new Message())
    ->setFromAddress('from@example.com', ['full_name' => 'From Example'])
    ->addToAddress('recipient@example.com')
    ->setSubject('Email subject')
    ->setTextBody('This is the body of the email, in text format')
    ->setHtmlBody('<html>This is the body of the email, in html format</html>')
    ->setTrackLinks(\Ixdf\Postmark\Enums\TrackLinksEnum::HTML_AND_TEXT) // Determine which type of links should be tracked
    ->setOpenTracking(true) // Determine that the openings should be tracked
    ->addTag('Email tag');
 

$response = Postmark::messages()->send($message); // Returns an instance of `\Ixdf\Postmark\Models\Message\SendResponse`
```

#### Sending batch emails
To send batch emails you just need to use a different method from the `MessageApi` class, passing a `Batch` containing all of your messages (up to 500 max) as parameter:

```php
use Ixdf\Postmark\Api\Message\Requests\Message;
use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Facades\Postmark;

$message1 = (new Message())
    ->setFromAddress('from@example.com', ['full_name' => 'From Example'])
    ->addToAddress('recipient@example.com')
    ->setSubject('Email subject')
    ->setTextBody('This is the body of the email, in text format')
    ->setHtmlBody('<html>This is the body of the email, in html format</html>')
    ->setTrackLinks(\Ixdf\Postmark\Enums\TrackLinksEnum::HTML_AND_TEXT) // Determine which type of links should be tracked
    ->setOpenTracking(true) // Determine that the openings should be tracked
    ->addTag('Email tag');

$message2 = (new Message())
    ->setFromAddress('from@example.com', ['full_name' => 'From Example'])
    ->addToAddress('recipient2@example.com')
    ->setSubject('Email subject 2')
    ->setTextBody('This is the body of the second email, in text format')
    ->setHtmlBody('<html>This is the body of the second email, in html format</html>')
    ->setTrackLinks(\Ixdf\Postmark\Enums\TrackLinksEnum::HTML_AND_TEXT) // Determine which type of links should be tracked
    ->setOpenTracking(true) // Determine that the openings should be tracked
    ->addTag('Email tag');

$batch = new Batch();
$batch->push($message1);
$batch->push($message2);

$response = Postmark::messages()->sendBatch($batch); // Returns an Ixdf\Postmark\Models\Message\SendBatchResponse instance
```

#### Sending single messages with Template
To send single messages using a template, use the `sendWithTemplate` method, which accepts an instance of `Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate` as parameter:

```php
use Ixdf\Postmark\Facades\Postmark;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;

$message = (new EmailWithTemplate())
    ->setTemplateId(1234) // The ID of the template to be used 
    ->setTemplateAlias('Alias_1234') // The Alias of the template to be used (not necessary when using `setTemplateId`
    ->setFromAddress('from@example.com', ['full_name' => 'From Example'])
    ->addToAddress('receiver@example.com')
    ->addTag('Message tag');
    
Postmark::messages()->sendWithTemplate($message); // Returns an instance of `Ixdf\Postmark\Models\Message\SendWithTemplateResponse`
```

#### Sending batch messages with template
To send single messages using a template, use the `sendBatchWithTemplate` method, which accepts an instance of `Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate` as parameter:

```php
use Ixdf\Postmark\Facades\Postmark;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate;
$message1 = (new EmailWithTemplate())
    ->setTemplateId(1234) // The ID of the template to be used 
    ->setTemplateAlias('Alias_1234') // The Alias of the template to be used (not necessary when using `setTemplateId`
    ->setFromAddress('from@example.com', ['full_name' => 'From Example'])
    ->addToAddress('receiver@example.com')
    ->addTag('Message tag');
    
$message2 = (new EmailWithTemplate())
    ->setTemplateId(1234) // The ID of the template to be used 
    ->setTemplateAlias('Alias_1234') // The Alias of the template to be used (not necessary when using `setTemplateId`
    ->setFromAddress('from@example.com', ['full_name' => 'From Example'])
    ->addToAddress('receiver_2@example.com')
    ->addTag('Message tag 2');
    
$batch = new BatchWithTemplate();
$batch->push($message1);
$batch->push($message2);

Postmark::messages()->sendBatchWithTemplate($batch); // Returns an instance of `Ixdf\Postmark\Models\Message\SendBatchWithTemplateResponse`
```

