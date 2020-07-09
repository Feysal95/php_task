<?php

declare(ticks=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageService implements ImageServiceInterface
{
    /**
     * @var string
     */
    private string $uploads = 'public/uploads/';
    /**
     * @var Filesystem
     */
    private Filesystem $fs;
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * Image constructor.
     * @param Filesystem $fs
     * @param HttpClientInterface $client
     */
    public function __construct(Filesystem $fs, HttpClientInterface $client)
    {
        $this->fs = $fs;
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function save(string $url): string
    {
        $response = $this->client->request('GET', $url, ['timeout' => 10]);
        $content = $response->getContent();
        $name = basename($url);
        $this->fs->appendToFile($this->uploads.$name, $content);
        return $name;
    }
}