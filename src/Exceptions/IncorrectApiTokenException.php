<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Exceptions;

use InvalidArgumentException;
use InteractionDesignFoundation\Postmark\Contracts\Exception;

final class IncorrectApiTokenException extends InvalidArgumentException implements Exception
{

}
