<?php declare(strict_types=1);

namespace Ixdf\Postmark\Exceptions;

use InvalidArgumentException;
use Ixdf\Postmark\Contracts\Exception;

final class IncorrectApiTokenException extends InvalidArgumentException implements Exception
{

}
