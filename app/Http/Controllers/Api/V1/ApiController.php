<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaylistItemResource;
use App\Http\Resources\PlaylistResource;
use App\Repositories\ApiRouteRepository;
use App\Repositories\PlaylistItemRepository;
use App\Repositories\PlaylistRepository;

class ApiController extends Controller
{
    protected ApiRouteRepository $apiRouteRepository;
    protected PlaylistRepository $playlistRepository;
    protected PlaylistItemRepository $playlistItemRepository;

    public function __construct(
      ApiRouteRepository $apiRouteRepository,
      PlaylistRepository $playlistRepository,
      PlaylistItemRepository $playlistItemRepository
    ) {
        $this->apiRouteRepository = $apiRouteRepository;
        $this->playlistRepository = $playlistRepository;
        $this->playlistItemRepository = $playlistItemRepository;
    }

    public function getLists()
    {
        return PlaylistResource::collection($this->playlistRepository->all());
    }

    public function getPlaylist($playlistId)
    {
        return PlaylistItemResource::collection(
          $this->playlistItemRepository->allQuery(['playlist_id' => $playlistId])->paginate(50)
        );
    }

    public function play($itemId)
    {
        $item = $this->playlistItemRepository->find($itemId);

        if (!$item) {
            return abort();
        }

        return redirect($item->url, 302);
    }
}
