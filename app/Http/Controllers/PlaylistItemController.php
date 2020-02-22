<?php

namespace App\Http\Controllers;

use App\Helpers\m3u;
use App\Http\Requests\CreatePlaylistItemRequest;
use App\Http\Requests\UpdatePlaylistItemRequest;
use App\Http\Requests\UploadM3uFileRequest;
use App\Http\Requests\UploadM3uUrlRequest;
use App\Models\PlaylistItem;
use App\Repositories\PlaylistItemRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Flash;
use Illuminate\View\View;
use Response;

class PlaylistItemController extends AppBaseController
{
    /** @var  PlaylistItemRepository */
    private $playlistItemRepository;

    public function __construct(PlaylistItemRepository $playlistItemRepo)
    {
        $this->playlistItemRepository = $playlistItemRepo;
    }

    /**
     * Display a listing of the PlaylistItem.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $playlistItems = $this->playlistItemRepository->all();

        return view('playlist_items.index')
          ->with('playlistItems', $playlistItems);
    }

    public function items($playlistId)
    {
        $playlistItems = $this->playlistItemRepository->allQuery(['playlist_id' => $playlistId])->get();

        return view('playlist_items.index')
          ->with('playlistItems', $playlistItems)
          ->with('playlistId', $playlistId);
    }

    /**
     * Show the form for creating a new PlaylistItem.
     *
     * @return Response
     */
    public function create()
    {
        return view('playlist_items.create');
    }

    /**
     * Store a newly created PlaylistItem in storage.
     *
     * @param CreatePlaylistItemRequest $request
     * @return Response
     */
    public function store(CreatePlaylistItemRequest $request)
    {
        $input = $request->all();

        $playlistItem = $this->playlistItemRepository->create($input);

        Flash::success('Playlist Item saved successfully.');

        return redirect(route('playlistItems.index'));
    }

    public function storeBulkUrl(UploadM3UUrlRequest $m3URequest)
    {
        $media = new m3u($m3URequest->get('m3uUrl'));
        $this->storeMedia($m3URequest->get('playlist_id'), $media);
    }

    public function storeBulkFile(UploadM3UFileRequest $m3URequest)
    {
        $media = new m3u($m3URequest->file('m3uFile')->getPathname());
        $this->storeMedia($m3URequest->get('playlist_id'), $media);
    }

    private function storeMedia($playlistId, $media)
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

    /**
     * Display the specified PlaylistItem.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $playlistItem = $this->playlistItemRepository->find($id);

        if (empty($playlistItem)) {
            Flash::error('Playlist Item not found');

            return redirect(route('playlistItems.index'));
        }

        return view('playlist_items.show')->with('playlistItem', $playlistItem);
    }

    /**
     * Show the form for editing the specified PlaylistItem.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $playlistItem = $this->playlistItemRepository->find($id);

        if (empty($playlistItem)) {
            Flash::error('Playlist Item not found');

            return redirect(route('playlistItems.index'));
        }

        return view('playlist_items.edit')->with('playlistItem', $playlistItem);
    }

    /**
     * Update the specified PlaylistItem in storage.
     *
     * @param int                       $id
     * @param UpdatePlaylistItemRequest $request
     * @return Response
     */
    public function update($id, UpdatePlaylistItemRequest $request)
    {
        $playlistItem = $this->playlistItemRepository->find($id);

        if (empty($playlistItem)) {
            Flash::error('Playlist Item not found');

            return redirect(route('playlistItems.index'));
        }

        $playlistItem = $this->playlistItemRepository->update($request->all(), $id);

        Flash::success('Playlist Item updated successfully.');

        return redirect(route('playlistItems.index'));
    }

    /**
     * Remove the specified PlaylistItem from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $playlistItem = $this->playlistItemRepository->find($id);

        if (empty($playlistItem)) {
            Flash::error('Playlist Item not found');

            return redirect(route('playlistItems.index'));
        }

        $this->playlistItemRepository->delete($id);

        Flash::success('Playlist Item deleted successfully.');

        return redirect(route('playlistItems.index'));
    }
}
