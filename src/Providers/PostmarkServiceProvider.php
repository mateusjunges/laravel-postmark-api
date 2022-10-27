<?php

namespace InteractionDesignFoundation\Postmark\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use InteractionDesignFoundation\Postmark\Api\Message\Message;
use InteractionDesignFoundation\Postmark\Api\Template\Template;
use InteractionDesignFoundation\Postmark\Contracts\MessageApi;
use InteractionDesignFoundation\Postmark\Contracts\PostmarkService;
use InteractionDesignFoundation\Postmark\Contracts\TemplateApi;
use InteractionDesignFoundation\Postmark\Hydrator\ModelHydrator;
use InteractionDesignFoundation\Postmark\Postmark;

class PostmarkServiceProvider extends ServiceProvider
{
    private const AUTH_HEADER = 'X-Postmark-Server-Token';

    public function register()
    {
        $this->app->bind(PostmarkService::class, function () {
            return new Postmark($this->getPostmarkClient(), new ModelHydrator());
        });

        $this->app->bind(MessageApi::class, function (Application $app, array $options) {
            return new Message($options['client'], $options['hydrator']);
        });

        $this->app->bind(TemplateApi::class, function (Application $app, array $options) {
            return new Template($options['client'], $options['hydrator']);
        });
    }

    private function getPostmarkClient(): ClientInterface
    {
        return new Client([
            'base_uri' => $this->app['config']->get('services.postmark.base_url'),
            RequestOptions::VERIFY => $this->app['config']->get('services.postmark.verify_ssl'),
            RequestOptions::TIMEOUT => $this->app['config']->get('services.postmark.request_timeout'),
            RequestOptions::HEADERS => [
                self::AUTH_HEADER => $this->app['config']->get('services.postmark.token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }
}
