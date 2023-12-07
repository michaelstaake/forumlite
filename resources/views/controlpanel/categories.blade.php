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
			<div class="float-sm-end">
				<div class="dropdown">
					<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-three-dots"></i>
					</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="#">Manage Section</a></li>
						<li><a class="dropdown-item" href="#">Delete Section</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">New Category</a></li>
					</ul>
				</div>
			</div>
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
					      <td>
						  	<div class="float-sm-end">
						  		<div class="dropdown">
									<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="bi bi-three-dots"></i>
									</button>
									<ul class="dropdown-menu">
										<li><a class="dropdown-item" href="#">Manage Category</a></li>
										<li><a class="dropdown-item" href="#">Delete Category</a></li>
									</ul>
								</div>
							</div>
						  </td>
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