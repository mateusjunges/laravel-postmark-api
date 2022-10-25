<?php

namespace Ixdf\Postmark\Facades;

use Illuminate\Support\Facades\Facade;
use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\Message;
use Ixdf\Postmark\Contracts\PostmarkService;
use Ixdf\Postmark\Support\Testing\Fakes\PostmarkFake;

/**
 * @method static \Ixdf\Postmark\Contracts\MessageApi messages
 * @method static \Ixdf\Postmark\Contracts\TemplateApi templates
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
