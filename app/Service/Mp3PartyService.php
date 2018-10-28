<?php

namespace App\Service;

use App\Models\Artist;
use App\Mp3Party\Parser\Mp3PartyParserInterface;
use App\Mp3Party\Parser\Structure\Track;
use Illuminate\Support\Facades\DB;
use App\Models\Track as TrackModel;

class Mp3PartyService
{
    /**
     * @var Mp3PartyParserInterface
     */
    private $mp3PartyParser;

    public function __construct(Mp3PartyParserInterface $mp3PartyParser)
    {
        $this->mp3PartyParser = $mp3PartyParser;
    }

    /**
     * @param int $artistId
     * @return Track[]
     */
    public function parseAndSyncTracks(int $artistId): array
    {
        $tracks = $this->mp3PartyParser->parseArtistsTracks($artistId);

        return DB::transaction(function () use ($tracks, $artistId) {
            $artist = Artist::where('artist_id', $artistId)->first();

            if (!isset($artist)) {
                $artist = Artist::create([
                    'artist_id' => $artistId,
                    'name' => $tracks[0]->artist
                ]);
            }

            return $this->syncTracks($tracks, $artist->id);
        });
    }

    /**
     * @param Track[]
     * @param int $artistId
     * @return array
     */
    private function syncTracks(array $tracks, int $artistId): array
    {
        $newTracks = [];

        foreach ($tracks as $track) {
            $trackExists = TrackModel::where('track_id', $track->trackId)
                ->exists();

            if (!$trackExists && isset($track->sourcePath)) {
                $newTracks[] = TrackModel::create([
                    'name' => $track->name,
                    'track_id' => $track->trackId,
                    'src_path' => $track->sourcePath,
                    'artist_id' => $artistId
                ]);
            }
        }

        return $newTracks;
    }
}