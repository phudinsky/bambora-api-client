<?php
namespace Bambora\Test;

use Bambora\Request\AuthorizeTransactionRequest;
use PHPUnit\Framework\TestCase;

class AuthorizeRequestTest extends TestCase
{
    public function testSetAuthorize()
    {
        /** @var AuthorizeTransactionRequest $class */
        $class = $this->createPartialMock(AuthorizeTransactionRequest::class, []);

        $authorizeStub = $this->createMock(AuthorizeRequest\Authorize::class);

        $class->setAuthorize($authorizeStub);
        self::assertEquals($authorizeStub, $class->getAuthorize());
    }
}
