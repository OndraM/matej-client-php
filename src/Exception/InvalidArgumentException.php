<?php declare(strict_types=1);

namespace Lmc\Matej\Exception;

/**
 * Exception represents error in the program logic.
 */
class InvalidArgumentException extends \InvalidArgumentException implements MatejExceptionInterface
{
    public static function forClassNotExtendingOtherClass($class, $wantedClass)
    {
        return new self(sprintf('Class %s has to be either instance of, or subclass of %s', $class, $wantedClass));
    }
}
