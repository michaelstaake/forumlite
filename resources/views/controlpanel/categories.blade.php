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
</div>

@foreach($sections as $s)
	<div class="card cp-category-card" id="{{ $s->slug }}">
		<div class="card-body">
			<h4>Section: {{ $s->name }} <button type="button" class="btn btn-primary btn-sm">Edit Section</button> <button type="button" class="btn btn-primary btn-sm">Add Section</button></h4>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col"></th>
			      <th scope="col">Category</th>
			      <th scope="col">Slug</th>
			      <th scope="col">Description</th>
			      <th scope="col"></th>

			    </tr>
			  </thead>
			  <tbody>
			   @foreach($categories as $c)
					@if ($c->section === "$s->id")
						<tr>
					      <td><i class="bi bi-arrows-move"></i></td>
					      <th scope="row">
					      	{{ $c->name }}
					      	@if ($c->is_readonly != NULL)
					      		<i class="bi bi-lock"></i>
					      	@endif
					      	@if ($c->is_hidden != NULL)
					      		<i class="bi bi-eye-slash"></i>
					      	@endif
					      </th>
					      <td>{{ $c->slug }}</td>
					      <td>{{ $c->description }}</td>
					      <td><button type="button" class="btn btn-primary btn-sm">Edit</button></td>
					    </tr>
					@endif
				</a>
				@endforeach
			  </tbody>
			</table>
			<button type="button" class="btn btn-primary">Save</button>
		</div>
	</div>
@endforeach

@include('includes.footer')