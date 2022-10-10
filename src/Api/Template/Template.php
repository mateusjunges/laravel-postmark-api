<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Template;

use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Api\Api;
use Ixdf\Postmark\Api\Template\Requests\Template as TemplateRequest;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\TemplateApi;
use Ixdf\Postmark\Models\Template\ShowResponse;
use Ixdf\Postmark\Models\Template\IndexResponse;
use Ixdf\Postmark\Models\Template\DeletedResponse;
use Ixdf\Postmark\Models\Template\CreateResponse;

final class Template extends Api implements TemplateApi
{
    /**
     * Create a new template with the given data.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(TemplateRequest $template): ApiResponse
    {
        return $this->parseResponse(
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
        return $this->parseResponse(
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
        return $this->parseResponse(
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
        return $this->parseResponse(
            $this->client->request('DELETE', "/templates/$templateIdOrAlias"),
            DeletedResponse::class
        );
    }
}
