<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Helpers\m3u;
use App\Models\PlaylistItem;
use Illuminate\{Bus\Queueable,
  Contracts\Queue\ShouldQueue,
  Foundation\Bus\Dispatchable,
  Queue\InteractsWithQueue,
  Queue\SerializesModels,
  Support\Facades\Log};

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
        foreach ($media->yieldMedia() as $m3u8) {
            $this->storeMedia($this->playlistId, $m3u8);
        }
    }

    /**
     * @param int   $playlistId
     * @param array $m3u8
     */
    private function storeMedia(int $playlistId, array $m3u8): void
    {
        if (config('logging.channels.media.active')) {
            Log::channel('media')->info('Uploaded Media', $m3u8);
        }

        PlaylistItem::updateOrCreate(
          [
            'playlist_id' => $playlistId,
            'name' => $m3u8['tvtitle'],
            'url' => $m3u8['tvmedia'],
            'media_item' => json_encode($m3u8),
          ]
        );
    }
}
