<?php declare(strict_types=1);

namespace Ixdf\Postmark\Tests\Api;

trait HasMessageMocks
{
    public function sendMock(): string
    {
        return <<<JSON
        {
	        "To": "receiver@example.com",
	        "SubmittedAt": "2014-02-17T07:25:01.4178645-05:00",
	        "MessageID": "0a129aee-e1cd-480d-b08d-4f48548ff48d",
	        "ErrorCode": 0,
	        "Message": "OK"
        }
JSON;
    }

    public function errorFromAddressIsNotSenderSignature(): string
    {
        return <<<JSON
        {
            "ErrorCode": 400,
            "Message": "The 'From' address you supplied (test <test@ixdf.com>) is not a Sender Signature on your account. Please add and confirm this address in order to be able to use it in the 'From' field of your messages."
        }
JSON;

    }

    public function sendBatchMock(): string
    {
        return <<<JSON
[
  {
    "ErrorCode": 0,
    "Message": "OK",
    "MessageID": "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
    "SubmittedAt": "2010-11-26T12:01:05.1794748-05:00",
    "To": "receiver1@example.com"
  },
  {
    "ErrorCode": 0,
    "Message": "OK",
    "MessageID": "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
    "SubmittedAt": "2010-11-26T12:01:05.1794748-05:00",
    "To": "receiver2@example.com"
  }
]
JSON;
    }

    public function sendBatchWithPartialErrorMock(): string
    {
        return <<<JSON
[
  {
    "ErrorCode": 0,
    "Message": "OK",
    "MessageID": "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
    "SubmittedAt": "2010-11-26T12:01:05.1794748-05:00",
    "To": "receiver1@example.com"
  },
  {
    "ErrorCode": 406,
    "Message": "You tried to send to a recipient that has been marked as inactive. Found inactive addresses: example@example.com. Inactive recipients are ones that have generated a hard bounce, a spam complaint, or a manual suppression. "
  }
]
JSON;
    }

    public function sendWithTemplateMock(): string
    {
        return <<<JSON
{
  "To": "receiver@example.com",
  "SubmittedAt": "2014-02-17T07:25:01.4178645-05:00",
  "MessageID": "0a129aee-e1cd-480d-b08d-4f48548ff48d",
  "ErrorCode": 0,
  "Message": "OK"
}
JSON;
    }

    public function sendBatchWithTemplateWithPartialErrorMock(): string
    {
        return <<<JSON
[
  {
    "ErrorCode": 0,
    "Message": "OK",
    "MessageID": "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
    "SubmittedAt": "2010-11-26T12:01:05.1794748-05:00",
    "To": "receiver1@example.com"
  },
  {
    "ErrorCode": 406,
    "Message": "You tried to send to a recipient that has been marked as inactive. Found inactive addresses: example@example.com. Inactive recipients are ones that have generated a hard bounce, a spam complaint, or a manual suppression."
  }
]
JSON;
    }

    public function sendBatchWithTemplateMock(): string
    {
        return <<<JSON
[
  {
    "ErrorCode": 0,
    "Message": "OK",
    "MessageID": "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
    "SubmittedAt": "2010-11-26T12:01:05.1794748-05:00",
    "To": "receiver@example.com"
  },
  {
    "ErrorCode": 0,
    "Message": "OK",
    "MessageID": "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
    "SubmittedAt": "2010-11-26T12:01:05.1794748-05:00",
    "To": "receiver2@example.com"
  }
]
JSON;
    }
}
