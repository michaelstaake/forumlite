@php ($pageTitle = "Categories and Sections")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories and Sections</li>
  </ol>
</nav>

<div class="page-title">
	Categories and Sections
	<div class="float-sm-end"><button type="button" class="btn btn-primary">New Section</button></div><br>
</div>

@foreach($sections as $s)
	<div class="card cp-category-card" id="{{ $s->slug }}">
		<div class="card-header">
			<i class="bi bi-arrows-move"></i>&nbsp;&nbsp;&nbsp;Section: <b>{{ $s->name }}</b> <i>({{ $s->slug }})</i>
			<div class="float-sm-end"><button type="button" class="btn btn-secondary btn-sm">Manage Section</button> <button type="button" class="btn btn-primary btn-sm">New Category</button></div>
		</div>
		<div class="card-body">
			
			<table class="table">
			  <tbody>
			   @foreach($categories as $c)
					@if ($c->section === "$s->id")
						<tr>
					      <th scope="row">
						  	<i class="bi bi-arrows-move"></i>
					      	<font style="font-weight:normal;">&nbsp;&nbsp;Category:</font> {{ $c->name }}
					      	@if ($c->is_readonly != NULL)
					      		<i class="bi bi-lock"></i>
					      	@endif
					      	@if ($c->is_hidden != NULL)
					      		<i class="bi bi-eye-slash"></i>
					      	@endif
							 <font style="font-weight:normal;"><i>({{ $c->slug }})</i></font>
					      </th>
					      <td>{{ $c->description }}</td>
					      <td><button type="button" class="float-sm-end btn btn-secondary btn-sm">Manage Category</button></td>
					    </tr>
					@endif
				</a>
				@endforeach
			  </tbody>
			</table>
		</div>
	</div>
	<br>
@endforeach
<p>Drop and drop items to rearrange them, then click Save Order prior to making any other changes such as adding or editing sections or categories.</p>
<button type="button" class="btn btn-primary">Save Order</button>

@include('includes.footer')