<?php
namespace Tests;

use Framework\JsonResponse;
use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{
    public function testSendOutputsJson()
    {
        $response = new JsonResponse(['foo' => 'bar'], 200);

        // Zachytíme výstup
        ob_start();
        $response->send();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"foo":"bar"', $output);
    }
}
