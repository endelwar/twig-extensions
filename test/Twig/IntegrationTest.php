<?php

class EndelWar_Twig_Tests_IntegrationTest extends Twig_Test_IntegrationTestCase
{
    public function getExtensions()
    {
        return array(
            new \Endelwar\Twig\ColorExtension(),
            new \Endelwar\Twig\ImageExtension(__DIR__ . '/public/', __DIR__ . '/public/cache'),
            new \Endelwar\Twig\HtmlExtension(),
        );
    }

    public function getFixturesDir()
    {
        return __DIR__ . '/Fixtures/';
    }
}
