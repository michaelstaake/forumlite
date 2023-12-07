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
		<button class="nav-link active" id="new-tab" data-bs-toggle="tab" data-bs-target="#new-tab-pane" type="button" role="tab" aria-controls="new-tab-pane" aria-selected="true">New Reports <span class="badge bg-secondary">7</span></button>
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
					<a href="/controlpanel/report/1" class="list-group-item list-group-item-action notifications-item">
						<h6>Reported User</h6>
						<p>Test has reported user example.</p>
						<span>August 11th, 2023 at 4:44PM</span>
					</a>
					<a href="/controlpanel/report/1" class="list-group-item list-group-item-action">
						<h6>Reported Discussion</h6>
						<p>Test has reported Discussion by example.</p>
						<span>August 11th, 2023 at 4:44PM</span>
					</a>
				</ul>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="handled-tab-pane" role="tabpanel" aria-labelledby="handled-tab" tabindex="0">
		<div class="row">
			<div class="col">
				<ul class="list-group list-group-flush reports-all">
					<a href="/controlpanel/report/1" class="list-group-item list-group-item-action">
						<h6>Reported Comment</h6>
						<p>Test has reported a comment by example.</p>
						<span>August 11th, 2023 at 4:44PM</span>
					</a>
					<a href="/controlpanel/report/1" class="list-group-item list-group-item-action">
						<h6>Reported Message</h6>
						<p>a_user has reported a message from example..</p>
						<span>August 11th, 2023 at 4:44PM</span>
					</a>
				</ul>
			</div>
		</div>
	</div>
</div>



@include('includes.footer')