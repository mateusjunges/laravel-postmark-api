<?php declare(strict_types=1);

namespace Junges\Postmark\Exceptions;

use Junges\Postmark\Contracts\Exception;

final class PostmarkUnavailable extends \RuntimeException implements Exception
{

}
