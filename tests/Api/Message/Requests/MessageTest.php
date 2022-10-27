<?php declare(strict_types=1);

namespace Ixdf\Postmark\Tests\Api\Message\Requests;

use Ixdf\Postmark\Api\Message\Requests\Address;
use Ixdf\Postmark\Api\Message\Requests\Attachment;
use Ixdf\Postmark\Api\Message\Requests\Message;
use Ixdf\Postmark\Enums\TrackLinksEnum;
use Ixdf\Postmark\Tests\TestCase;

final class MessageTest extends TestCase
{
    /** @test */
    public function it_sets_data_correctly(): void
    {
        $sut = new Message();

        $sut->setHtmlBody('<html>Hi!</html>');
        $sut->setTextBody('Hi!');
        $sut->setSubject('Subject');
        $sut->setMessageStream('test-message-stream');
        $sut->setMetadata('key', 'value');
        $sut->setFromAddress(new Address('from@from.com', 'From'));
        $sut->setOpenTracking(true);
        $sut->addTag('my-tag');
        $sut->addToAddress(new Address('to@to.com', 'To'));
        $sut->addCc(new Address('cc@cc.com', 'Cc'));
        $sut->addBcc(new Address('bcc@bcc.com', 'Bcc'));
        $sut->addReplyTo(new Address('reply-to@example.com', 'Reply To'));
        $sut->setHeaders($headers = ['Test' => 'Test Value']);
        $sut->setTrackLinks(TrackLinksEnum::HTML_AND_TEXT);

        $this->assertEquals('<html>Hi!</html>', $sut->getHtmlBody());
        $this->assertEquals('Hi!', $sut->getTextBody());
        $this->assertEquals('Subject', $sut->getSubject());
        $this->assertEquals('test-message-stream', $sut->getMessageStream());
        $this->assertEquals(['key' => 'value'], $sut->getMetadata());
        $this->assertTrue($sut->isTrackOpens());
        $this->assertEquals('my-tag', $sut->getTag());
        $this->assertEquals(["To <to@to.com>"], $sut->getToAddress());
        $this->assertEquals("From <from@from.com>", $sut->getFrom());
        $this->assertEquals(["Bcc <bcc@bcc.com>"], $sut->getBcc());
        $this->assertEquals(["Cc <cc@cc.com>"], $sut->getCc());
        $this->assertEquals(["Reply To <reply-to@example.com>"], $sut->getReplyTo());
        $this->assertEquals([[ 'Name' => 'Test',  'Value' => 'Test Value']], $sut->getPreparedHeaders());
        $this->assertEquals($headers, $sut->getHeaders());
        $this->assertEquals(TrackLinksEnum::HTML_AND_TEXT, $sut->getTrackLinks());
    }

    /** @test */
    public function it_can_attach_files(): void
    {
        $sut = new Message();

        $sut->addAttachment(new Attachment(
            'test',
            base64_encode('Test'),
            'text/plain',
            'test-content-id',
        ));

        $expected[] = [
            "Name" => "test",
            "Content" => "VGVzdA==",
            "ContentType" => "text/plain",
            "ContentId" => "test-content-id",
        ];

        $this->assertEquals($expected, $sut->getAttachments());
    }
}