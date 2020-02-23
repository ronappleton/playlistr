<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApiRouteRequest;
use App\Http\Requests\UpdateApiRouteRequest;
use App\Models\ApiRoute;
use App\Repositories\ApiRouteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ApiRouteController extends AppBaseController
{
    /** @var  ApiRouteRepository */
    private $apiRouteRepository;

    public function __construct(ApiRouteRepository $apiRouteRepo)
    {
        $this->apiRouteRepository = $apiRouteRepo;
    }

    /**
     * Display a listing of the ApiRoute.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $apiRoutes = $this->apiRouteRepository->all();

        return view('api_routes.index')
            ->with('apiRoutes', $apiRoutes);
    }

    /**
     * Show the form for creating a new ApiRoute.
     *
     * @return Response
     */
    public function create()
    {
        return view('api_routes.create');
    }

    /**
     * Store a newly created ApiRoute in storage.
     *
     * @param CreateApiRouteRequest $request
     *
     * @return Response
     */
    public function store(CreateApiRouteRequest $request)
    {
        $input = $request->all();

        $apiRoute = $this->apiRouteRepository->create($input);

        Flash::success('Api Route saved successfully.');

        return redirect(route('apiRoutes.index'));
    }

    /**
     * Display the specified ApiRoute.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $apiRoute = $this->apiRouteRepository->find($id);

        if (empty($apiRoute)) {
            Flash::error('Api Route not found');

            return redirect(route('apiRoutes.index'));
        }

        return view('api_routes.show')->with('apiRoute', $apiRoute);
    }

    /**
     * Show the form for editing the specified ApiRoute.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $apiRoute = $this->apiRouteRepository->find($id);

        if (empty($apiRoute)) {
            Flash::error('Api Route not found');

            return redirect(route('apiRoutes.index'));
        }

        return view('api_routes.edit')->with('apiRoute', $apiRoute);
    }

    /**
     * Update the specified ApiRoute in storage.
     *
     * @param int $id
     * @param UpdateApiRouteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApiRouteRequest $request)
    {
        $apiRoute = $this->apiRouteRepository->find($id);

        if (empty($apiRoute)) {
            Flash::error('Api Route not found');

            return redirect(route('apiRoutes.index'));
        }

        $apiRoute = $this->apiRouteRepository->update($request->all(), $id);

        Flash::success('Api Route updated successfully.');

        return redirect(route('apiRoutes.index'));
    }

    /**
     * Remove the specified ApiRoute from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $apiRoute = $this->apiRouteRepository->find($id);

        if (empty($apiRoute)) {
            Flash::error('Api Route not found');

            return redirect(route('apiRoutes.index'));
        }

        $this->apiRouteRepository->delete($id);

        Flash::success('Api Route deleted successfully.');

        return redirect(route('apiRoutes.index'));
    }

    public function toggle(Request $request)
    {
        $this->validate($request,
          [
            'routeId' => 'required|integer|exists:api_routes,id'
          ]);

        ApiRoute::find($request->routeId)->toggleActive()->save();

        return response()->json(['success']);
    }
}
