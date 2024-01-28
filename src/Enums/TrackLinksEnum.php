<?php declare(strict_types=1);

namespace Junges\Postmark\Enums;

enum TrackLinksEnum: string
{
    case NONE = 'None';
    case HTML_AND_TEXT = 'HtmlAndText';
    case HTML_ONLY = 'HtmlOnly';
    case TEXT_ONLY = 'TextOnly';
}
