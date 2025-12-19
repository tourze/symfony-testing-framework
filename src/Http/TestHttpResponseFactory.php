<?php

declare(strict_types=1);

namespace SymfonyTestingFramework\Http;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Mock HTTP response factory for test environment.
 *
 * This factory returns successful mock responses to prevent actual HTTP requests
 * during tests. This ensures:
 * - Tests are deterministic and fast
 * - No external dependencies required
 * - No memory exhaustion from real HTTP operations
 *
 * For tests that need specific HTTP response behavior, the test can inject
 * its own MockHttpClient with custom responses.
 */
class TestHttpResponseFactory
{
    /**
     * Creates a mock response for any HTTP request.
     *
     * @param string               $method  HTTP method
     * @param string               $url     Request URL
     * @param array<string, mixed> $options Request options
     */
    public function __invoke(string $method, string $url, array $options = []): ResponseInterface
    {
        // Return a successful JSON response by default
        return new MockResponse(
            json_encode([
                'success' => true,
                'mock' => true,
                'method' => $method,
                'url' => $url,
            ], JSON_THROW_ON_ERROR),
            [
                'http_code' => 200,
                'response_headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }
}
