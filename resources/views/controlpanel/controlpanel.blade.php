@php ($pageTitle = "Control Panel")
@include('includes.header')

<div class="page-title">
	<center>Control Panel</center>
</div>

@if (auth()->user()->group === "mod")

    <div class="row">
        <div class="col-6 control-panel-item">
            <a href="/controlpanel/reports">
                <center><h2><i class="bi bi-flag"></i></h2></center>
                <center><h3>Reports <span class="badge text-bg-danger" id="reports-badge"></span></h3></center>
            </a>
        </div>
        <div class="col-6 control-panel-item">
            <a href="/controlpanel/users">
                <center><h2><i class="bi bi-people-fill"></i></h2></center>
                <center><h3>Users</h3></center>
            </a>
        </div>
    </div>

@endif

@if (auth()->user()->group === "admin")

    <div class="row">
        <div class="col-3 control-panel-item">
            <a href="/controlpanel/reports">
                <center><h1><i class="bi bi-flag"></i></h1></center>
                <center><h4>Reports <span class="badge text-bg-danger" id="reports-badge"></span></h4></center>
            </a>
        </div>
        <div class="col-3 control-panel-item">
            <a href="/controlpanel/users">
                <center><h1><i class="bi bi-people-fill"></i></h1></center>
                <center><h4>Users</h4></center>
            </a>
        </div>
        <div class="col-3 control-panel-item">
            <a href="/controlpanel/categories">
                <center><h1><i class="bi bi-list-ol"></i></h1></center>
                <center><h4>Categories and Sections</h4></center>
            </a>
        </div>
        <div class="col-3 control-panel-item">
            <a href="/controlpanel/settings">
                <center><h1><i class="bi bi-gear"></i></h1></center>
                <center><h4>Settings</h4></center>
            </a>
        </div>
    </div>

@endif

<p><center><em>Forumlite {{ $version }}</em></center></p>

@include('includes.footer')