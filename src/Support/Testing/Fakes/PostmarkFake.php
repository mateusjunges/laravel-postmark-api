<?php declare(strict_types=1);

namespace Ixdf\Postmark\Support\Testing\Fakes;

use BadMethodCallException;
use Illuminate\Support\Collection;
use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;
use Ixdf\Postmark\Contracts\MessageApi;
use Ixdf\Postmark\Contracts\PostmarkService;
use Ixdf\Postmark\Contracts\TemplateApi;
use PHPUnit\Framework\Assert as PHPUnit;

final class PostmarkFake implements PostmarkService
{
    private array $singleMailables = [];

    private array $batches = [];

    private array $sentWithTemplate = [];

    private array $batchesWithTemplates = [];

    public function messages(): MessageApi
    {
        return (new MessagesApiFake())
            ->sendSingleMessageUsing(fn ($message) => $this->singleMailables[] = $message)
            ->sendBatchesUsing(fn (Batch $batch) => $this->batches[] = $batch)
            ->sendBatchTemplatesUsing(fn (BatchWithTemplate $batchWithTemplate) => $this->batchesWithTemplates[] = $batchWithTemplate)
            ->sendTemplatesUsing(fn (EmailWithTemplate $emailWithTemplate) => $this->sentWithTemplate[] = $emailWithTemplate);
    }

    public function templates(): TemplateApi
    {
        throw new BadMethodCallException('Not supported yet.');
    }

    public function assertMessageSent(callable $callback = null): void
    {
        PHPUnit::assertTrue(
            $this->sent($callback, $this->singleMailables)->count() > 0,
            "The expected message was not sent."
        );
    }

    public function assertNothingSent(): void
    {
        PHPUnit::assertEmpty($this->singleMailables, "Messages were sent unexpectedly.");
        PHPUnit::assertEmpty($this->batches, "Batch emails were sent unexpectedly.");
        PHPUnit::assertEmpty($this->batchesWithTemplates, "Batches with templates were sent unexpectedly.");
        PHPUnit::assertEmpty($this->sentWithTemplate, "Emails with template were sent unexpectedly.");
    }

    public function assertMessageSentWithTemplate(callable $callback = null): void
    {
        PHPUnit::assertTrue(
            $this->sent($callback, $this->sentWithTemplate)->count() > 0,
            "The expected email with template was not sent."
        );
    }

    public function assertBatchSent(callable $callback = null): void
    {
        PHPUnit::assertTrue(
            $this->sent($callback, $this->batches)->count() > 0,
            "The expected batch was not sent."
        );
    }

    public function assertBatchSentWithTemplate(callable $callback = null)
    {
        PHPUnit::assertTrue(
            $this->sent($callback, $this->batchesWithTemplates)->count() > 0,
            "The expected batch with template was not sent."
        );
    }

    private function sent(callable $callback, array $sent): Collection
    {
        if (empty($sent)) {
            return collect();
        }

        $callback = $callback ?: fn () => true;

        return collect($sent)->filter(fn ($message) => $callback($message));
    }
}
