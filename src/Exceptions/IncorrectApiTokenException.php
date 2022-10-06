<?php

namespace Ixdf\Postmark\Exceptions;

use InvalidArgumentException;
use Ixdf\Postmark\Contracts\Exception;

class IncorrectApiTokenException extends InvalidArgumentException implements Exception
{

}
