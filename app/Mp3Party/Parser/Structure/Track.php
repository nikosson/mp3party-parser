<?php

namespace App\Mp3Party\Parser\Structure;

class Track
{
    /**
     * @var string
     */
    public $artist;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $trackId;

    /**
     * @var string|null
     */
    public $sourcePath;

    public function __construct(string $name, string $artist, int $trackId, ?string $sourcePath)
    {
        $this->name = $name;
        $this->artist = $artist;
        $this->trackId = $trackId;
        $this->sourcePath = $sourcePath;
    }
}