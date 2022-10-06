<?php

namespace Ixdf\Postmark\Enums;

enum TrackLinksEnum: string
{
    case NONE = 'None';
    case HTML_AND_TEXT = 'HtmlAndText';
    case HTML_ONLY = 'HtmlOnly';
    case TEXT_ONLY = 'TextOnly';
}
