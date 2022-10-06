<?php declare(strict_types=1);

namespace Ixdf\Postmark;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use http\Env\Request;
use Ixdf\Postmark\Api\Message\Message;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Hydrator\ModelHydrator;

final class Postmark
{
    private const AUTH_HEADER = 'X-Postmark-Server-Token';

    public static $VERIFY_SSL = true;

    private string $apiToken;
    private string $baseUrl;

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
                self::AUTH_HEADER => $apiToken
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
}