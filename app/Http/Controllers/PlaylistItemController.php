<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlaylistItemRequest;
use App\Http\Requests\UpdatePlaylistItemRequest;
use App\Http\Requests\UploadM3uFileRequest;
use App\Http\Requests\UploadM3uUrlRequest;
use App\Jobs\StoreM3uJob;
use App\Models\PlaylistItem;
use App\Repositories\PlaylistItemRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Response;

/**
 * Class PlaylistItemController
 *
 * @package App\Http\Controllers
 */
class PlaylistItemController extends AppBaseController
{
    /**
     * @var  PlaylistItemRepository
     */
    private PlaylistItemRepository $playlistItemRepository;

    /**
     * PlaylistItemController constructor.
     *
     * @param PlaylistItemRepository $playlistItemRepo
     */
    public function __construct(PlaylistItemRepository $playlistItemRepo)
    {
        $this->playlistItemRepository = $playlistItemRepo;
    }

    /**
     * Display a listing of the PlaylistItem.
     *
     * @return Factory|View
     */
    public function index()
    {
        $playlistItems = $this->playlistItemRepository->paginate(50);

        return view('playlist_items.index')
          ->with('playlistItems', $playlistItems);
    }

    /**
     * @param $playlistId
     * @return Factory|View
     */
    public function items($playlistId)
    {
        $playlistItems = PlaylistItem::where('playlist_id', $playlistId)->with('playlist')->paginate(50);
        $playlistItems = $this->playlistItemRepository->allQuery(['playlist_id' => $playlistId])->paginate(50);

        return view('playlist_items.index')
          ->with('playlistItems', $playlistItems)
          ->with('playlistId', $playlistId);
    }

    /**
     * Show the form for creating a new PlaylistItem.
     *
     * @return Factory|View|Response
     */
    public function create()
    {
        return view('playlist_items.create');
    }

    /**
     * Store a newly created PlaylistItem in storage.
     *
     * @param CreatePlaylistItemRequest $request
     * @return RedirectResponse|Redirector|Response
     */
    public function store(CreatePlaylistItemRequest $request)
    {
        $input = $request->all();

        $this->playlistItemRepository->create($input);

        Flash::success('Playlist Item saved successfully.');

        return redirect(route('playlistItems.index'));
    }

    /**
     * @param UploadM3uUrlRequest $m3URequest
     * @return RedirectResponse|Redirector
     */
    public function storeBulkUrl(UploadM3UUrlRequest $m3URequest)
    {
        StoreM3uJob::dispatchAfterResponse(
          $m3URequest->get('playlist_id'),
          $m3URequest->get('m3uUrl')
        );

        Flash::success('Playlist Items upload process started.');
        return redirect(route('playlist.items', [$m3URequest->get('playlist_id')]));
    }

    /**
     * @param UploadM3uFileRequest $m3URequest
     * @return RedirectResponse|Redirector
     */
    public function storeBulkFile(UploadM3UFileRequest $m3URequest)
    {
        StoreM3uJob::dispatchAfterResponse(
          $m3URequest->get('playlist_id'),
          $m3URequest->file('m3uFile')->getPathname()
        );

        Flash::success('Playlist Items upload process started.');
        return redirect(route('playlist.items', [$m3URequest->get('playlist_id')]));
    }

    /**
     * Display the specified PlaylistItem.
     *
     * @param int $id
     * @return RedirectResponse|Redirector|Factory|View
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
     * @return Factory|RedirectResponse|Redirector|View
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
     * @return RedirectResponse|Redirector
     */
    public function update($id, UpdatePlaylistItemRequest $request)
    {
        $playlistItem = $this->playlistItemRepository->find($id);

        if (empty($playlistItem)) {
            Flash::error('Playlist Item not found');

            return redirect(route('playlistItems.index'));
        }

        $this->playlistItemRepository->update($request->all(), $id);

        Flash::success('Playlist Item updated successfully.');

        return redirect(route('playlistItems.index'));
    }

    /**
     * Remove the specified PlaylistItem from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     * @throws Exception
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


    public function toggle(Request $request)
    {
        $this->validate(
          $request,
          [
            'itemId' => 'required|integer|exists:playlists,id',
          ]
        );

        $this->playlistItemRepository->find($request->itemId)->toggleActive()->save();

        return response()->json(['success']);
    }
}
