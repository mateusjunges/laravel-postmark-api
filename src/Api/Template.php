<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Models\Template\Response\SingleTemplateResponse;
use Ixdf\Postmark\Models\Template\Response\TemplateCollection;
use Ixdf\Postmark\Models\Template\Response\TemplateDeletedResponse;
use Ixdf\Postmark\Models\Template\Response\TemplateResponse;
use Ixdf\Postmark\Models\Template\Template as TemplateRequest;

final class Template
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly Hydrator $hydrator
    ) {}

    public function create(TemplateRequest $template): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('POST', '/templates', [
                RequestOptions::BODY => $template->toJson(),
            ]),
            TemplateResponse::class
        );
    }

    public function find(string $templateIdOrAlias): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('GET', "/templates/$templateIdOrAlias"),
            SingleTemplateResponse::class
        );
    }

    public function all(): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('GET', '/templates'),
            TemplateCollection::class
        );
    }

    public function delete(string $templateIdOrAlias): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('DELETE', "/templates/$templateIdOrAlias"),
            TemplateDeletedResponse::class
        );
    }
}