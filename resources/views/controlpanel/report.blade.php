@foreach($report as $r) @php ($pageTitle = 'Reported ' . $r->type)  @endforeach
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item"><a href="/controlpanel/reports">Reports</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reported Comment</li>
  </ol>
</nav>

<div class="page-title">
  Reported Comment
  @if ($r->status == "new")
    <div class="float-sm-end"><button type="button" class="btn btn-primary"><i class="bi bi-check-circle"></i> Mark as Handled</button></div><br>
  @else
    <div class="float-sm-end"><button type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button></div><br>
  @endif
</div>

<p>Report ID {{ $r->id }}: Reported by X on Y</p>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        {{ $r->content }}
      </div>
    </div>
  </div>
</div>




@include('includes.footer')