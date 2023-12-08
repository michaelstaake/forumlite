@foreach($report as $r) @php ($pageTitle = 'Reported ' . $r->type)  @endforeach
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item"><a href="/controlpanel/reports">Reports</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reported {{ $r->type }}</li>
  </ol>
</nav>

<div class="page-title">
  Reported {{ $r->type }}
  @if ($r->status == "new")
    <div class="float-sm-end"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportHandleModal"><i class="bi bi-check-circle"></i> Mark as Handled</button></div><br>
  @else
    <div class="float-sm-end"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportDeleteModal"><i class="bi bi-trash"></i> Delete</button></div><br>
  @endif
</div>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        @if ($r->status == "new")
          Reported: <strong>{{ $r->created_at }}</strong>
        @else
          Reported: <strong>{{ $r->created_at }}</strong>&nbsp; &nbsp; &nbsp; Handled: <strong>{{ $r->updated_at }}</strong>
        @endif
      </div>
    </div>
  </div>
</div>

<br>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        {{ $r->summary }}
      </div>
      <div class="card-body">
        {!! $r->content !!}
      </div>
    </div>
  </div>
</div>

@if ($r->status == "new")
  <!-- #reportHandleModal -->
  <div class="modal modal-lg fade" id="reportHandleModal" tabindex="-1" aria-labelledby="reportHandleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('controlpanel.reportHandle') }}" class="">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="reportHandleLabel">Mark Report {{ $r->id }} as Handled</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Reports marked as handled are still accessible under the Handled tab on the Reports page. From there you may delete them.</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="report_id" value="{{ $r->id }}" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@else
  <!-- #reportDeleteModal -->
  <div class="modal modal-lg fade" id="reportDeleteModal" tabindex="-1" aria-labelledby="reportDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('controlpanel.reportDelete') }}" class="">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="reportDeleteLabel">Delete Report {{ $r->id }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Report deletion is permanent.</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="report_id" value="{{ $r->id }}" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endif


@include('includes.footer')