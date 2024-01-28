<?php

namespace Junges\Postmark\Contracts;

interface PostmarkService
{
    public function messages(): MessageApi;

    public function templates(): TemplateApi;
}
