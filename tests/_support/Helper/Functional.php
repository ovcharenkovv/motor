<?php
namespace Helper;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{
    /**
     * @param int $status
     * @param null $body
     * @param array $headers
     * @param string $version
     * @param null $reason
     * @return \GuzzleHttp\Client
     */
    public function mockGuzzle(
        $status = 200,
        $body = null,
        array $headers = [],
        $version = '1.1',
        $reason = null
    )
    {

        $container = [];
        $history = Middleware::history($container);
        $guzzleMock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response($status, $headers, $body, $version, $reason),
        ]);

        $stack = HandlerStack::create($guzzleMock);
        $stack->push($history);
        return new \GuzzleHttp\Client(['handler' => $stack]);
    }

}
