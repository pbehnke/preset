<?php

namespace Tests\App\Controller;

require __DIR__.'/../vendor/../autoload.php';

use Tests\WebTestCase;

class AppControllerTest extends WebTestCase
{
    public function testHome()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello World!', (string) $response->getBody());
    }
}
