@php ($pageTitle = "Watched Discussions")
@include('includes.header')

<div class="page-title">
	Watched Discussions
</div>
<p>You receive notifications for watched discussions, and depending on <a href="/settings">settings</a>, may receive an email as well.</p>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Category</th>
      <th scope="col">Author</th>
      <th scope="col">Watched since</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  	@foreach($watched as $w)
  	<tr>
      <td scope="row">
      	@foreach ($w->discussion as $wd)
      		<a href="/discussion/{{ $wd->slug }}">{{ $wd->title }}</a>
      	@endforeach
      </a></td>
      <td>
	  	@foreach ($w->category as $wc)
      		<a href="/category/{{ $wc->slug }}">{{ $wc->name }}</a>
      	@endforeach
	  </td>
      <td>
      	@if($w->type === "my")
      		You
      	@else
			@foreach ($w->author as $wa)
      			<a href="/member/{{ $wa->username }}">{{ $wa->username }}</a>
      		@endforeach
      	@endif
      </td>
      <td>{{ $w->created_at }}</td>
      @if($w->type === "watched")
      	<td><button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#unwatchModal-{{ $w->id }}">Unwatch</button></td>
      @endif
      
    </tr>
  	@endforeach
    
  </tbody>
</table>

@foreach($watched as $w)
  	@if($w->type === "watched")
  	<!-- #unwatchModal -->
  	<div class="modal fade" id="unwatchModal-{{ $w->id }}" tabindex="-1" aria-labelledby="unwatchLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	    	<form method="post" action="{{ route('watched.unwatch') }}" class="">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="unwatchLabel">Unwatch Discussion</h1>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<p>Are you sure you want to unwatch this discussion?</p>
		      	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="mb-3">
				    <input type="hidden" id="watch_id" name="watch_id" value="{{ $w->id }}">
				 </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-danger">Unwatch</button>
		      </div>
		  	</form>
	    </div>
	  </div>
	</div>
  	@endif
@endforeach



@include('includes.footer')