<?php

namespace Ixdf\Postmark\Exceptions;

use Ixdf\Postmark\Contracts\Exception;
use RuntimeException;

class TooManyRecipients extends RuntimeException implements Exception
{

}
