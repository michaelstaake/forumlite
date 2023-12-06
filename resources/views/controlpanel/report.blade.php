@foreach($report as $r) @php ($pageTitle = $r->id)  @endforeach
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item"><a href="/controlpanel/reports">Reports</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $r->id }}</li>
  </ol>
</nav>

<div class="page-title">
    {{ $r->id }}
</div>


@include('includes.footer')