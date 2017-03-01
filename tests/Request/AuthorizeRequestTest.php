<?php
namespace Bambora\Test;

use Bambora\Request\AuthorizeRequest;
use PHPUnit\Framework\TestCase;

class AuthorizeRequestTest extends TestCase
{
    public function testSetAuthorize()
    {
        /** @var AuthorizeRequest $class */
        $class = $this->createPartialMock(AuthorizeRequest::class, []);

        $authorizeStub = $this->createMock(AuthorizeRequest\Authorize::class);

        $class->setAuthorize($authorizeStub);
        self::assertEquals($authorizeStub, $class->getAuthorize());
    }
}
