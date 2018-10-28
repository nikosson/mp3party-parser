<?php

namespace App\Console\Commands\Mp3Party;

use App\Jobs\Mp3Party\DownloadTrackJob;
use App\Models\Track;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadParsedTracksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp3party:download-parsed-tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download parsed tracks, which were still not downloaded yet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        /* @var Track[] $tracks */
        $tracks = Track::notDownloaded()->get();

        foreach ($tracks as $track) {
            $this->info("Adding to download queue track #{$track->id}");

            try {
                dispatch(new DownloadTrackJob($track, Storage::disk('local')));
            } catch (Exception $exception) {
                $this->error("Error while downloading track #{$track->id}: {$exception->getMessage()}");
            }
        }
    }
}
