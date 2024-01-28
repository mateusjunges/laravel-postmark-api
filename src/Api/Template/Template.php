<?php declare(strict_types=1);

namespace Junges\Postmark\Api\Template;

use GuzzleHttp\RequestOptions;
use Junges\Postmark\Api\Api;
use Junges\Postmark\Api\Template\Requests\Template as TemplateRequest;
use Junges\Postmark\Contracts\ApiResponse;
use Junges\Postmark\Contracts\TemplateApi;
use Junges\Postmark\Responses\Template\ShowResponse;
use Junges\Postmark\Responses\Template\IndexResponse;
use Junges\Postmark\Responses\Template\DeletedResponse;
use Junges\Postmark\Responses\Template\CreateResponse;

final class Template extends Api implements TemplateApi
{
    /**
     * Create a new template with the given data.
     */
    public function create(TemplateRequest $template): ApiResponse
    {
        return $this->request('POST', '/templates', CreateResponse::class, [
            RequestOptions::BODY => $template->toJson(),
        ]);
    }

    /**
     * Search for a specific template via ID or Alias.
     */
    public function find(string $templateIdOrAlias): ApiResponse
    {
        return $this->request('GET', "/templates/$templateIdOrAlias",ShowResponse::class);
    }

    /**
     * Fetch all templates.
     */
    public function all(): ApiResponse
    {
        return $this->request('GET', '/templates', IndexResponse::class);
    }

    /**
     * Delete the given template.
     */
    public function delete(string $templateIdOrAlias): ApiResponse
    {
        return $this->request('DELETE', "/templates/$templateIdOrAlias", DeletedResponse::class);
    }
}
