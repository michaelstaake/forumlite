@php ($pageTitle = "Backup")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Backup</li>
  </ol>
</nav>

<div class="page-title">
	Backup
</div>

<p>Note: Backup does not include passwords, so if you restore a backup your users will need to reset their passwords.</p>

@include('includes.footer')