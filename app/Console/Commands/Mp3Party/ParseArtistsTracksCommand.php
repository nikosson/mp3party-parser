<?php

namespace App\Console\Commands\Mp3Party;

use App\Service\Mp3PartyService;
use Exception;
use Illuminate\Console\Command;

class ParseArtistsTracksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp3party:parse-artists-tracks {artistId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse tracks for given artists and sync that information with local DB';

    /**
     * @var Mp3PartyService
     */
    private $mp3PartyService;

    /**
     * Create a new command instance.
     * @param Mp3PartyService $mp3PartyService
     */
    public function __construct(Mp3PartyService $mp3PartyService)
    {
        parent::__construct();
        $this->mp3PartyService = $mp3PartyService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $artistId = $this->argument('artistId');

        if ($artistId) {
            $this->handleArtist($artistId);
        } else {
            foreach ($this->getTestArtistsIds() as $artistId) {
                $this->handleArtist($artistId);
                $this->info("\n");
            }
        }
    }

    private function handleArtist(int $artistId): void
    {
        $this->info("Working with artist #{$artistId}");

        try {
            $newTracksAdded = $this->mp3PartyService->parseAndSyncTracks($artistId);
            $this->info(sprintf('Parsed and synced %s new tracks for this artist', count($newTracksAdded)));
        } catch (Exception $exception) {
            $this->error("Something went wrong. Error: {$exception->getMessage()}");
        }
    }

    private function getTestArtistsIds(): array
    {
        return [
            1275, //Muse
            1233, //Blur
            4488, //Swedish House Mafia
            1361, //The Prodigy
            2150  //Daft Punk
        ];
    }
}
