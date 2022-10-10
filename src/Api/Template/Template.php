<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Template;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Api\Template\Requests\Template as TemplateRequest;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Contracts\TemplateApi;
use Ixdf\Postmark\Models\Template\ShowResponse;
use Ixdf\Postmark\Models\Template\IndexResponse;
use Ixdf\Postmark\Models\Template\DeletedResponse;
use Ixdf\Postmark\Models\Template\CreateResponse;

final class Template implements TemplateApi
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly Hydrator $hydrator
    ) {}

    /**
     * Create a new template with the given data.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(TemplateRequest $template): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('POST', '/templates', [
                RequestOptions::BODY => $template->toJson(),
            ]),
            CreateResponse::class
        );
    }

    /**
     * Search for a specific template via ID or Alias.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $templateIdOrAlias): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('GET', "/templates/$templateIdOrAlias"),
            ShowResponse::class
        );
    }

    /**
     * Fetch all templates.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('GET', '/templates'),
            IndexResponse::class
        );
    }

    /**
     * Delete the given template.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $templateIdOrAlias): ApiResponse
    {
        return $this->hydrator->hydrate(
            $this->client->request('DELETE', "/templates/$templateIdOrAlias"),
            DeletedResponse::class
        );
    }
}
