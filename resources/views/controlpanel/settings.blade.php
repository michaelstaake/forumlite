@php ($pageTitle = "Settings")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
  </ol>
</nav>

<div class="page-title">
	Settings
</div>

<ul class="nav nav-tabs" id="userTabs" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">General Settings</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages-tab-pane" type="button" role="tab" aria-controls="pages-tab-pane" aria-selected="false">Pages</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="integration-tab" data-bs-toggle="tab" data-bs-target="#integration-tab-pane" type="button" role="tab" aria-controls="integration-tab-tab-pane" aria-selected="false">Integration</button>
	</li>
</ul>

<div class="tab-content" id="userTabsContent">
	<div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
		<p>maintenance mode, allow signatures, allow registration, contact link</p>
	</div>
	<div class="tab-pane fade" id="pages-tab-pane" role="tabpanel" aria-labelledby="pages-tab" tabindex="0">
		<p>Terms and rules, privacy policy</p>
	</div>
	<div class="tab-pane fade" id="integration-tab-pane" role="tabpanel" aria-labelledby="integration-tab" tabindex="0">
		<p>header, footer</p>
	</div>
</div>

@include('includes.footer')