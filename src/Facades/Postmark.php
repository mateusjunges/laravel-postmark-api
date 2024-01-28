<?php

namespace Junges\Postmark\Facades;

use Illuminate\Support\Facades\Facade;
use Junges\Postmark\Api\Message\Requests\Batch;
use Junges\Postmark\Api\Message\Requests\BatchWithTemplate;
use Junges\Postmark\Api\Message\Requests\EmailWithTemplate;
use Junges\Postmark\Api\Message\Requests\Message;
use Junges\Postmark\Contracts\PostmarkService;
use Junges\Postmark\Support\Testing\Fakes\PostmarkFake;

/**
 * @method static \Junges\Postmark\Contracts\MessageApi messages
 * @method static \Junges\Postmark\Contracts\TemplateApi templates
 * @method static void assertMessageSent(Message $message, callable $callback = null)
 * @method static void assertBatchSent(\Closure $callback = null)
 * @method static void assertMessageSentWithTemplate(\Closure $callback = null)
 * @method static void assertBatchSentWithTemplate(\Closure $callback = null)
 * @method static void assertNothingSent()
 */
class Postmark extends Facade
{
    public static function fake(): PostmarkService
    {
        static::swap($fake = new PostmarkFake());

        return $fake;
    }

    public static function getFacadeAccessor(): string
    {
        return PostmarkService::class;
    }
}
