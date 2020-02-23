@push('scripts')
<script>
  $(document).ready(function () {
    document.querySelectorAll('[data-type="active"]').forEach(item => {
      item.addEventListener('click', event => {
        $(event.target).toggleClass('glyphicon-ok-circle text-success');
        $(event.target).toggleClass('glyphicon-ban-circle text-danger');
        $.ajax({
          type: "POST",
          url: "{!! $url !!}",
          data: {
            "_token": "{{ csrf_token() }}",
            "{!! $idName !!}": event.target.dataset.id
          },
          error: function (response) {
            alert('Could not enable/disable the route.');
          },
          dataType: 'json'
        });
      })
    })
  });
</script>
@endpush
