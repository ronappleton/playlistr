<div class="table-responsive">
  <table class="table" id="apiRoutes-table">
    <thead>
    <tr>
      <th style="width: 8em;">Active (click)</th>
      <th>Route</th>
      <th>Regex</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($apiRoutes as $apiRoute)
      <tr>
        <td>
          @activator(['active' => $apiRoute->active, 'id' => $apiRoute->id])@endactivator
        </td>
        <td>{{ $apiRoute->route }}</td>
        <td>{{ $apiRoute->regex}}</td>
        <td>{{ $apiRoute->description }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
@activatorScript(['url' => 'apiRoutes/toggle', 'idName' => 'routeId'])
@endactivatorScript
