<?php

namespace Tounaf\Exception\Exception;

interface DecoratorExceptionHandlerInterface extends ExceptionHandlerInterface
{
    public function decoratesHandler(ExceptionHandlerInterface $decoratedExceptionHandler): void;
}
