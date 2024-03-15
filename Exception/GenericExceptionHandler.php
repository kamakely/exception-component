<?php

namespace Tounaf\Exception\Exception;

use Symfony\Component\HttpFoundation\Response;
use Tounaf\Exception\FormatResponse\FormatResponseCheckerInterface;
use Tounaf\Exception\FormatResponse\FormatResponseInterface;

class GenericExceptionHandler implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    /**
     * @var formatResponseInterface FormatResponseInterface
     */
    private $formatResponseInterface;

    /**
     * @param  \Throwable $throwable
     * @return Response
     */
    public function handleException(\Throwable $throwable): Response
    {
        $messageExeption = $throwable->getMessage();
        return $this->formatResponseInterface->render(
            [
            'message' => $messageExeption,
            'http_message' => 'Erreur interne',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]
        );
    }

    /**
     * @param  \Throwable $throwable
     * @return bool
     */
    public function supportsException(\Throwable $throwable): bool
    {
        return false;
    }

    /**
     * @var FormatResponseInterface $formatResponseInterface
     */
    public function setFormat(FormatResponseInterface $formatResponseInterface): void
    {
        $this->formatResponseInterface = $formatResponseInterface;
    }

}
