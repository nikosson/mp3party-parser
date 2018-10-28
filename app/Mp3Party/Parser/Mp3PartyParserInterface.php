<?php

namespace App\Mp3Party\Parser;

use App\Mp3Party\Parser\Structure\Track;

interface Mp3PartyParserInterface
{
    /**
     * @param int $artistId
     * @return Track[]
     */
    public function parseArtistsTracks(int $artistId): array;
}