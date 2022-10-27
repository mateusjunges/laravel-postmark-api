<?php

namespace InteractionDesignFoundation\Postmark\Facades;

use Illuminate\Support\Facades\Facade;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\Batch;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\BatchWithTemplate;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\EmailWithTemplate;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\Message;
use InteractionDesignFoundation\Postmark\Contracts\PostmarkService;
use InteractionDesignFoundation\Postmark\Support\Testing\Fakes\PostmarkFake;

/**
 * @method static \InteractionDesignFoundation\Postmark\Contracts\MessageApi messages
 * @method static \InteractionDesignFoundation\Postmark\Contracts\TemplateApi templates
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
