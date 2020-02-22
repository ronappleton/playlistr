<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Helpers\m3u;
use App\Models\PlaylistItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class StoreM3uJob
 *
 * @package App\Jobs
 */
class StoreM3uJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private int $playlistId;

    /**
     * @var string
     */
    private string $source;

    /**
     * Create a new job instance.
     *
     * @param int    $playlistId
     * @param string $source
     */
    public function __construct(int $playlistId, string $source)
    {
        $this->playlistId = $playlistId;
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $media = new m3u($this->source);
        foreach ($media->yieldMedia() as $m3u) {
            $this->storeMedia($this->playlistId, $m3u);
        }
    }

    /**
     * @param int $playlistId
     * @param m3u $media
     */
    private function storeMedia(int $playlistId, m3u $media): void
    {
        foreach ($media->yieldMedia() as $playlistItem) {
            PlaylistItem::updateOrCreate(
              [
                'playlist_id' => $playlistId,
                'name' => $playlistItem['tvtitle'],
                'url' => $playlistItem['tvmedia'],
              ]
            );
        }
    }
}
