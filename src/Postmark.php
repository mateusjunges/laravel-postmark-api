<?php declare(strict_types=1);

namespace Ixdf\Postmark;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Api\Message;
use Ixdf\Postmark\Api\Template;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Hydrator\ModelHydrator;

final class Postmark
{
    private const AUTH_HEADER = 'X-Postmark-Server-Token';

    public static $VERIFY_SSL = true;

    private string $apiToken;

    public function __construct(
        private ClientInterface $client,
        private Hydrator $hydrator
    ) {
    }

    public static function create(string $apiToken, string $endpoint = 'https://api.postmarkapp.com/', int $timeout = 30): self
    {
        $client = new Client([
            'base_uri' => $endpoint,
            RequestOptions::VERIFY => self::$VERIFY_SSL,
            RequestOptions::TIMEOUT => $timeout,
            RequestOptions::HEADERS => [
                self::AUTH_HEADER => $apiToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        return (new self($client, new ModelHydrator()))->setApiToken($apiToken);
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function messages(): Message
    {
        return new Message($this->client, $this->hydrator);
    }

    public function templates(): Template
    {
        return new Template($this->client, $this->hydrator);
    }
}
