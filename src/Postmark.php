<?php declare(strict_types=1);

namespace Ixdf\Postmark;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\App;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Contracts\MessageApi;
use Ixdf\Postmark\Contracts\PostmarkService;
use Ixdf\Postmark\Contracts\TemplateApi;

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
