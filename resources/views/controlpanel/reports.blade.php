@php ($pageTitle = "Reports")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reports</li>
  </ol>
</nav>

<div class="page-title">
	Reports
</div>

<ul class="nav nav-tabs" id="reportsTabs" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="new-tab" data-bs-toggle="tab" data-bs-target="#new-tab-pane" type="button" role="tab" aria-controls="new-tab-pane" aria-selected="true">New Reports</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="handled-tab" data-bs-toggle="tab" data-bs-target="#handled-tab-pane" type="button" role="tab" aria-controls="handled-tab-pane" aria-selected="false">Handled Reports</button>
	</li>
</ul>

<div class="tab-content" id="reportsTabsContent">
	<div class="tab-pane fade show active" id="new-tab-pane" role="tabpanel" aria-labelledby="new-tab" tabindex="0">
		<div class="row">
			<div class="col">
				<ul class="list-group list-group-flush reports-all">
					@foreach($rn as $rn)
						<a href="/controlpanel/report/{{ $rn->id }}" class="list-group-item list-group-item-action">
							<h6>Reported {{ $rn->type }}</h6>
							<p>{{ $rn->summary }}</p>
							<span>Reported: {{ $rn->created_at }}</span>
						</a>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="handled-tab-pane" role="tabpanel" aria-labelledby="handled-tab" tabindex="0">
		<div class="row">
			<div class="col">
				<ul class="list-group list-group-flush reports-all">
					@foreach($rh as $rh)
						<a href="/controlpanel/report/{{ $rh->id }}" class="list-group-item list-group-item-action">
							<h6>Reported {{ $rh->type }}</h6>
							<p>{{ $rh->summary }}</p>
							<span>Reported: {{ $rh->created_at }}</span><span>Handled: {{ $rh->updated_at }}</span>
						</a>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>



@include('includes.footer')