<?php declare(strict_types=1);

namespace Junges\Postmark;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\App;
use Junges\Postmark\Contracts\Hydrator;
use Junges\Postmark\Contracts\MessageApi;
use Junges\Postmark\Contracts\PostmarkService;
use Junges\Postmark\Contracts\TemplateApi;

final class Postmark implements PostmarkService
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly Hydrator $hydrator
    ) {
    }

    public function messages(): MessageApi
    {
        return App::make(MessageApi::class, [
            'client' => $this->client,
            'hydrator' => $this->hydrator
        ]);
    }

    public function templates(): TemplateApi
    {
        return App::make(TemplateApi::class, [
            'client' => $this->client,
            'hydrator' => $this->hydrator
        ]);
    }
}
