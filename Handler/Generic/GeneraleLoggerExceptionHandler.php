<?php

namespace Tounaf\Exception\Handler\Generic;

use Psr\Log\LoggerInterface;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Tounaf\Exception\Exception\ExceptionHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Tounaf\Exception\Exception\DecoratorExceptionHandlerInterface;
use Tounaf\Exception\Exception\TounafException;

class GeneraleLoggerExceptionHandler implements DecoratorExceptionHandlerInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    private ExceptionHandlerInterface $decoratedExceptionHandlerInterface;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @param  \Throwable $throwable
     * @return Response
     */
    public function handleException(\Throwable $throwable): Response
    {
        $e = FlattenException::createFromThrowable($throwable);
        $this->logException($throwable, sprintf('Uncaught PHP Exception %s: "%s" at %s line %s', $e->getClass(), $e->getMessage(), $e->getFile(), $e->getLine()));
        return $this->decoratedExceptionHandlerInterface->handleException($throwable);
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof TounafException;
    }

    public function decoratesHandler(ExceptionHandlerInterface $decoratedExceptionHandlerInterface): void
    {
        $this->decoratedExceptionHandlerInterface = $decoratedExceptionHandlerInterface;
    }

    protected function logException(\Throwable $exception, $message)
    {
        if (!$exception instanceof HttpExceptionInterface) {
            $this->logger->critical(
                $message,
                ['exception' => $exception]
            );
        } else {
            $this->logger->error(
                $message,
                ['exception' => $exception]
            );
        }
    }

}
