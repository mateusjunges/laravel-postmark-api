<?php declare(strict_types=1);

namespace Junges\Postmark\Exceptions;

use Junges\Postmark\Contracts\Exception;
use RuntimeException;

final class UnknownException extends RuntimeException implements Exception
{

}
