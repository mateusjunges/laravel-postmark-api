<?php declare(strict_types=1);

namespace Ixdf\Postmark\Exceptions;

use Ixdf\Postmark\Contracts\Exception;
use RuntimeException;

final class ServerErrorException extends RuntimeException implements Exception
{

}
