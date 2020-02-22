<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Repositories\PlaylistRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Flash;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Response;

/**
 * Class PlaylistController
 *
 * @package App\Http\Controllers
 */
class PlaylistController extends AppBaseController
{
    /**
     * @var  PlaylistRepository
     */
    private PlaylistRepository $playlistRepository;

    /**
     * PlaylistController constructor.
     *
     * @param PlaylistRepository $playlistRepo
     */
    public function __construct(PlaylistRepository $playlistRepo)
    {
        $this->playlistRepository = $playlistRepo;
    }

    /**
     * Display a listing of the Playlist.
     *
     * @return Factory|View
     */
    public function index()
    {
        $playlists = $this->playlistRepository->paginate(50);

        return view('playlists.index')
            ->with('playlists', $playlists);
    }

    /**
     * Show the form for creating a new Playlist.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created Playlist in storage.
     *
     * @param CreatePlaylistRequest $request
     * @return RedirectResponse|Redirector|Response
     */
    public function store(CreatePlaylistRequest $request)
    {
        $input = $request->all();

        $this->playlistRepository->create($input);

        Flash::success('Playlist saved successfully.');

        return redirect(route('playlists.index'));
    }

    /**
     * Display the specified Playlist.
     *
     * @param int $id
     * @return RedirectResponse|Redirector|Factory|View
     */
    public function show($id)
    {
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            Flash::error('Playlist not found');

            return redirect(route('playlists.index'));
        }

        return view('playlists.show')->with('playlist', $playlist);
    }

    /**
     * Show the form for editing the specified Playlist.
     *
     * @param int $id
     * @return RedirectResponse|Redirector|Factory|View
     */
    public function edit($id)
    {
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            Flash::error('Playlist not found');

            return redirect(route('playlists.index'));
        }

        return view('playlists.edit')->with('playlist', $playlist);
    }

    /**
     * Update the specified Playlist in storage.
     *
     * @param int $id
     * @param UpdatePlaylistRequest $request
     * @return RedirectResponse|Redirector
     */
    public function update($id, UpdatePlaylistRequest $request)
    {
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            Flash::error('Playlist not found');

            return redirect(route('playlists.index'));
        }

        $this->playlistRepository->update($request->all(), $id);

        Flash::success('Playlist updated successfully.');

        return redirect(route('playlists.index'));
    }

    /**
     * Remove the specified Playlist from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy($id)
    {
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            Flash::error('Playlist not found');

            return redirect(route('playlists.index'));
        }

        $this->playlistRepository->delete($id);

        Flash::success('Playlist deleted successfully.');

        return redirect(route('playlists.index'));
    }
}
