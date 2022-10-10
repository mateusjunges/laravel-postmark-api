<?php declare(strict_types=1);

namespace Ixdf\Postmark\Tests\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\App;
use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Api\Message\Requests\Message;
use Ixdf\Postmark\Hydrator\ModelHydrator;
use Ixdf\Postmark\Models\Message\ErrorResponse;
use Ixdf\Postmark\Models\Message\SendBatchResponse;
use Ixdf\Postmark\Models\Message\SendResponse;
use Ixdf\Postmark\Postmark;
use Ixdf\Postmark\Tests\TestCase;

final class MessageTest extends TestCase
{
    use HasMessageMocks;

    /** @test */
    public function it_can_send_single_messages(): void
    {
        $this->mockOneRequest('request', $this->sendMock());

        $client = $this->getPostmarkClient();

        $message = (new Message())
            ->setFromAddress('test@example.com', ['full_name' => 'Test'])
            ->addToAddress('receiver@example.com')
            ->setSubject('Subject');

        $response = $client->messages()->send($message);

        $this->assertInstanceOf(SendResponse::class, $response);

        $this->assertEquals('receiver@example.com', $response->getTo());
    }

    /** @test */
    public function it_returns_a_error_response_when_a_client_error_is_detected()
    {
        $this->mockThrowException('request', 'Message', 422, new ClientException(
            'Error',
            new Request('POST', '/email'),
            new Response(422, ['Content-Type' => 'application/json'], $this->errorFromAddressIsNotSenderSignature()),
        ));

        $message = (new Message())
            ->setFromAddress('test@example.com', ['full_name' => 'Test'])
            ->addToAddress('receiver@example.com')
            ->setSubject('Subject');

        $response = $this->getPostmarkClient()->messages()->send($message);

        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->assertEquals(400, $response->getErrorCode());
    }

    /** @test */
    public function it_can_send_batch_messages()
    {
        $message1 = (new Message())
            ->setFromAddress('test@example.com', ['full_name' => 'Test'])
            ->addToAddress('receiver@example.com')
            ->setSubject('Subject');

        $message2 = (new Message())
            ->setFromAddress('test2@example.com', ['full_name' => 'Test 2'])
            ->addToAddress('receiver2@example.com')
            ->setSubject('Subject 2');

        $batch = new Batch();
        $batch->push($message1);
        $batch->push($message2);

        $this->mockOneRequest('request', $this->sendBatchMock());

        $response = $this->getPostmarkClient()->messages()->sendBatch($batch);

        $this->assertInstanceOf(SendBatchResponse::class, $response);

        $this->mockOneRequest('request', $this->sendBatchWithPartialErrorMock());

        $response = $this->getPostmarkClient()->messages()->sendBatch($batch);

        $this->assertInstanceOf(SendBatchResponse::class, $response);

        $this->assertInstanceOf(ErrorResponse::class, $response->getResponse()[1]);
    }

    private function getPostmarkClient(): Postmark
    {
        return new Postmark(
            App::make(Client::class),
            new ModelHydrator()
        );
    }
}
