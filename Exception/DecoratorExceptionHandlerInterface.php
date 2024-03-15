<?php

namespace Tounaf\Exception\Exception;

interface DecoratorExceptionHandlerInterface extends ExceptionHandlerInterface
{
    /**
     * @param  ExceptionHandlerInterface $decoratedExceptionHandler
     * @return bool
     */
    public function decoratesHandler(ExceptionHandlerInterface $decoratedExceptionHandler): void;
}
