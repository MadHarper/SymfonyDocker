<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('POST', '/api/programmers');

        $res = $client->getResponse();
        $this->assertEquals(200, $res->getStatusCode());

        $content = $res->getContent();
        $x = json_decode($content);
        $this->assertEquals("hello", $x->msg);

    }

    public function testCatch()
    {
        $client = static::createClient();

        $client->request('POST', '/api/catch', $content = ['team' => 'pats']);

        $content = $client->getResponse()->getContent();
        $x = json_decode($content);
        $this->assertEquals('pats', $x->team);
    }
}