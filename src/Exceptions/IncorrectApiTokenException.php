<?php declare(strict_types=1);

namespace Junges\Postmark\Exceptions;

use InvalidArgumentException;
use Junges\Postmark\Contracts\Exception;

final class IncorrectApiTokenException extends InvalidArgumentException implements Exception
{

}
