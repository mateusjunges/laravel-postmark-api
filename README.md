# Postmark API Client for Laravel apps

- [Installation](#installation)
  - [Configuration](#configuration)
- [Postmark API](#postmark-api)
  - [Emails API](#email-api)
    - [Sending single emails](#sending-single-emails)
    - [Sending batch emails](#sending-batch-emails)
    - [Sending single emails with template](#sending-single-messages-with-template)
    - [Sending batch emails with template](#sending-batch-messages-with-template)
  - [Templates API](#templates-api)
    - [Create template](#create-template)
    - [Search for specific template](#search-a-specific-template)
    - [List all templates](#get-all-templates)

## Installation
You can install this package using composer:

```bash
composer require mateusjunges/laravel-postmark-api
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
\Junges\Postmark\Facades\Postmark::messages();
```
This returns a `MessageApi` contract, which is responsible for handling emails.

#### Sending single emails
To send single emails, you should use the `send` method, which accepts a `$message` argument, that must be an instance of `Junges\Postmark\Api\Message\Requests\Message`:


```php
use Junges\Postmark\Facades\Postmark;
use Junges\Postmark\Api\Message\Requests\Message;
use Junges\Postmark\Api\Message\Requests\Address;

$message = (new Message())
    ->setFromAddress(new Address('from@example.com', 'From Name'))
    ->addToAddress(new Address('recipient@example.com'))
    ->setSubject('Email subject')
    ->setTextBody('This is the body of the email, in text format')
    ->setHtmlBody('<html>This is the body of the email, in html format</html>')
    ->setTrackLinks(\Junges\Postmark\Enums\TrackLinksEnum::HTML_AND_TEXT) // Determine which type of links should be tracked
    ->setOpenTracking(true) // Determine that the openings should be tracked
    ->addTag('Email tag');
 

$response = Postmark::messages()->send($message); // Returns an instance of `\Junges\Postmark\Models\Message\SendResponse`
```

#### Sending batch emails
To send batch emails you just need to use a different method from the `MessageApi` class, passing a `Batch` containing all of your messages (up to 500 max) as parameter:

```php
use Junges\Postmark\Api\Message\Requests\Message;
use Junges\Postmark\Api\Message\Requests\Batch;
use Junges\Postmark\Facades\Postmark;
use Junges\Postmark\Api\Message\Requests\Address;

$message1 = (new Message())
    ->setFromAddress(new Address('from@example.com', 'From Name'))
    ->addToAddress(new Address('recipient@example.com'))
    ->setSubject('Email subject')
    ->setTextBody('This is the body of the email, in text format')
    ->setHtmlBody('<html>This is the body of the email, in html format</html>')
    ->setTrackLinks(\Junges\Postmark\Enums\TrackLinksEnum::HTML_AND_TEXT) // Determine which type of links should be tracked
    ->setOpenTracking(true) // Determine that the openings should be tracked
    ->addTag('Email tag');

$message2 = (new Message())
    ->setFromAddress(new Address('from@example.com', 'From Name'))
    ->addToAddress(new Address('recipient2@example.com'))
    ->setSubject('Email subject 2')
    ->setTextBody('This is the body of the second email, in text format')
    ->setHtmlBody('<html>This is the body of the second email, in html format</html>')
    ->setTrackLinks(\Junges\Postmark\Enums\TrackLinksEnum::HTML_AND_TEXT) // Determine which type of links should be tracked
    ->setOpenTracking(true) // Determine that the openings should be tracked
    ->addTag('Email tag');

$batch = new Batch();
$batch->push($message1);
$batch->push($message2);

$response = Postmark::messages()->sendBatch($batch); // Returns an Junges\Postmark\Models\Message\SendBatchResponse instance
```

#### Sending single messages with Template
To send single messages using a template, use the `sendWithTemplate` method, which accepts an instance of `Junges\Postmark\Api\Message\Requests\EmailWithTemplate` as parameter:

```php
use Junges\Postmark\Facades\Postmark;
use Junges\Postmark\Api\Message\Requests\EmailWithTemplate;
use Junges\Postmark\Api\Message\Requests\Address;

$message = (new EmailWithTemplate())
    ->setTemplateId(1234) // The ID of the template to be used 
    ->setTemplateAlias('Alias_1234') // The Alias of the template to be used (not necessary when using `setTemplateId`
    ->setFromAddress(new Address('from@example.com', 'From Name'))
    ->addToAddress(new Address('recipient@example.com'))
    ->addTag('Message tag');
    
Postmark::messages()->sendWithTemplate($message); // Returns an instance of `Junges\Postmark\Models\Message\SendWithTemplateResponse`
```

#### Sending batch messages with template
To send single messages using a template, use the `sendBatchWithTemplate` method, which accepts an instance of `Junges\Postmark\Api\Message\Requests\BatchWithTemplate` as parameter:

```php
use Junges\Postmark\Facades\Postmark;
use Junges\Postmark\Api\Message\Requests\EmailWithTemplate;
use Junges\Postmark\Api\Message\Requests\BatchWithTemplate;
use Junges\Postmark\Api\Message\Requests\Address;

$message1 = (new EmailWithTemplate())
    ->setTemplateId(1234) // The ID of the template to be used 
    ->setTemplateAlias('Alias_1234') // The Alias of the template to be used (not necessary when using `setTemplateId`
    ->setFromAddress(new Address('from@example.com', 'From Name'))
    ->addToAddress(new Address('recipient@example.com'))
    ->addTag('Message tag');
    
$message2 = (new EmailWithTemplate())
    ->setTemplateId(1234) // The ID of the template to be used 
    ->setTemplateAlias('Alias_1234') // The Alias of the template to be used (not necessary when using `setTemplateId`
    ->setFromAddress(new Address('from@example.com', 'From Name'))
    ->addToAddress(new Address('recipient2@example.com'))
    ->addTag('Message tag 2');
    
$batch = new BatchWithTemplate();
$batch->push($message1);
$batch->push($message2);

Postmark::messages()->sendBatchWithTemplate($batch); // Returns an instance of `Junges\Postmark\Models\Message\SendBatchWithTemplateResponse`
```

### Templates API
This API lets you manage templates for a specific server.

> **Warning**
> 
> A server may have up to 100 templates. Requests that exceed this limit won't be processed. Please [contact support](https://postmarkapp.com/contact) if you need mor templates within a Server.

To have access to the `templates` API, you must use the `templates` method, available with the `Postmark` facade:

```php
\Junges\Postmark\Facades\Postmark::templates();
```

This returns a `TemplateApi` contract, responsible for handling template API calls.

#### Create template
To create a template, you must use the `create` method, which accepts a `Junges\Postmark\Api\Template\Requests\Template` parameter:

```php
use Junges\Postmark\Facades\Postmark;
use Junges\Postmark\Api\Template\Requests\Template;

$template = (new Template())
    ->setHtmlBody('<html></html>') //The content to use for the HtmlBody when this template is used to send email.
    ->setTextBody('text') //The content to use for the TextBody when this template is used to send email.
    ->setSubject('Email subject')
    ->setAlias('The alias of the template')
    ->setName('The name of the template');

Postmark::templates()->create($template); // Returns an instance of `Junges\Postmark\Models\Template\CreateResponse`
```

#### Search a specific template
You may search for a specific template using the `find` method, which accepts the template id or alias as parameter:

```php
use Junges\Postmark\Facades\Postmark;

Postmark::templates()->find($templateIdOrAlias); // Returns an instance of `Junges\Postmark\Models\Template\ShowResponse`
```

#### Get all templates
To get a collection with all of your stored templates, use the `all` method:

```php
use Junges\Postmark\Facades\Postmark;

Postmark::templates()->all(); // Returns an instance of `Junges\Postmark\Models\Template\IndexResponse`
```

