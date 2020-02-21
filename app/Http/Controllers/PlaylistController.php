<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Repositories\PlaylistRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PlaylistController extends AppBaseController
{
    /** @var  PlaylistRepository */
    private $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepo)
    {
        $this->playlistRepository = $playlistRepo;
    }

    /**
     * Display a listing of the Playlist.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $playlists = $this->playlistRepository->all();

        return view('playlists.index')
            ->with('playlists', $playlists);
    }

    /**
     * Show the form for creating a new Playlist.
     *
     * @return Response
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created Playlist in storage.
     *
     * @param CreatePlaylistRequest $request
     *
     * @return Response
     */
    public function store(CreatePlaylistRequest $request)
    {
        $input = $request->all();

        $playlist = $this->playlistRepository->create($input);

        Flash::success('Playlist saved successfully.');

        return redirect(route('playlists.index'));
    }

    /**
     * Display the specified Playlist.
     *
     * @param int $id
     *
     * @return Response
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
     *
     * @return Response
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
     *
     * @return Response
     */
    public function update($id, UpdatePlaylistRequest $request)
    {
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            Flash::error('Playlist not found');

            return redirect(route('playlists.index'));
        }

        $playlist = $this->playlistRepository->update($request->all(), $id);

        Flash::success('Playlist updated successfully.');

        return redirect(route('playlists.index'));
    }

    /**
     * Remove the specified Playlist from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
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
