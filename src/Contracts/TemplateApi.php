<?php

namespace InteractionDesignFoundation\Postmark\Contracts;

use InteractionDesignFoundation\Postmark\Api\Template\Requests\Template;

interface TemplateApi
{
    public function create(Template $template): ApiResponse;

    public function find(string $templateIdOrAlias): ApiResponse;

    public function all(): ApiResponse;

    public function delete(string $templateIdOrAlias): ApiResponse;
}
