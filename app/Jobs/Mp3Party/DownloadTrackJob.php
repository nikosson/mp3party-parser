<?php

namespace App\Jobs\Mp3Party;

use App\Models\Artist;
use App\Models\Track;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadTrackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * @var Track
     */
    private $track;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Create a new job instance.
     *
     * @param Track $track
     * @param Filesystem $filesystem
     */
    public function __construct(Track $track, Filesystem $filesystem)
    {
        $this->track = $track;
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if ($this->track->isDownloaded()) {
            return ;
        }
        /* @var $artist Artist */
        $artist = $this->track->artist;

        $trackPath = $this->generateTrackPath($artist->id, $this->track->id);
        $this->downloadTrack($trackPath, $this->track->src_path);

        $this->track->update([
            'storage_path' => str_replace('public', 'storage', $trackPath)
        ]);
    }

    private function downloadTrack(string $trackPath, string $trackUrl): void
    {
        $this->filesystem->put($trackPath, file_get_contents($trackUrl));
    }

    private function generateTrackPath(int $artistId, int $trackId): string
    {
        return sprintf('public/tracks/%s/%s.mp3', $artistId, $trackId);
    }
}
