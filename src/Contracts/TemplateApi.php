<?php

namespace Ixdf\Postmark\Contracts;

use Ixdf\Postmark\Models\Template\Template;

interface TemplateApi
{
    public function create(Template $template): ApiResponse;

    public function find(string $templateIdOrAlias): ApiResponse;

    public function all(): ApiResponse;

    public function delete(string $templateIdOrAlias): ApiResponse;
}
