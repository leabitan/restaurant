<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/');


        // Debug output
        // dd($client->getResponse()->getContent());

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'cuisine');
    }
    public function testHomePagebutton(): void
    {
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/');


        // Debug output
        // dd($client->getResponse()->getContent());

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        // Check if the button with class 'reserver' exists
        $this->assertGreaterThan(
            0,
            $crawler->filter('input.reserver')->count(),
            'The button with class "reserver" was not found'
        );
    }
}
