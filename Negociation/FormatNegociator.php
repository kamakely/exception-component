<?php

namespace Tounaf\Exception\Negociation;

use Symfony\Component\HttpFoundation\Request;
use Tounaf\Exception\RequestMatcher\MatcherRequestInterface;

class FormatNegociator
{
    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var array
     */
    private $map = [];

    public function add(MatcherRequestInterface $requestMatcherInterface, array $options = [])
    {
        $this->map[] = [$requestMatcherInterface, $options];
    }

    public function getBest(): ?string
    {
        $request = $this->getRequest();
        foreach ($this->map as $elements) {
            // Check if the current RequestMatcherInterface matches the current request
            if (!$elements[0]->matches($request)) {
                continue;
            }

            return $elements[1]['format'];
        }

        return null;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    private function getRequest()
    {
        if(null === $this->request) {
            throw new \RuntimeException("There is no current request");
        }

        return $this->request;
    }
}
