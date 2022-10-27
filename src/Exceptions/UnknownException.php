<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Exceptions;

use InteractionDesignFoundation\Postmark\Contracts\Exception;
use RuntimeException;

final class UnknownException extends RuntimeException implements Exception
{

}
