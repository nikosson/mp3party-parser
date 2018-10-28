<?php

namespace App\Mp3Party\Parser;

use App\Mp3Party\Parser\Structure\Track;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Mp3PartyParser implements Mp3PartyParserInterface
{
    const ARTIST_BASE_URL = 'http://mp3party.net/artist/';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $artistId
     * @return Track[]
     */
    public function parseArtistsTracks(int $artistId): array
    {
        $crawler = $this->client->request('GET', self::ARTIST_BASE_URL . $artistId);

        return $crawler->filter('.playlist > .song-item')->each(function (Crawler $crawler) {
            $trackChildItems = $crawler->children();

            $trackInfo = $trackChildItems->filter('.name > a');

            list($artist, $name) = explode(' – ', $trackInfo->text());
            $trackId = (int) str_replace('/music/', '', $trackInfo->attr('href'));
            $source = $trackChildItems->filter('.play-btn')->attr('href');

            return new Track($name, $artist, $trackId, $source);
        });
    }
}