@php ($pageTitle = "Watched Discussions")
@include('includes.header')

<div class="page-title">
	Watched Discussions
</div>
<p>You receive notifications for watched discussions, and depending on <a href="/settings">settings</a>, may receive an email as well.</p>

<ul class="forum-discussion-list">
@foreach($watched as $w)
	<li class="forum-discussion-li">
		<div class="forum-discussion-li-left">
		@if($w->type === "my")
		<img class="forum-discussion-li-avatar" src="{{asset('storage/avatars')}}/{{auth()->user()->avatar}}" />
      	@else
			@foreach ($w->author as $wa)
			<img class="forum-discussion-li-avatar" src="{{asset('storage/avatars')}}/{{ $wa->avatar }}" />
      		@endforeach
      	@endif
		</div>
		<div class="forum-discussion-li-right">
		<h6>
			 @foreach ($w->discussion as $wd)
			 	<a href="/discussion/{{ $wd->slug }}">{{ $wd->title }}</a>
			@endforeach
		</h6>
		<span timestamp="{{ $w->created_at }}">Started by
			@foreach ($w->author as $wa)
      			<a href="/member/{{ $wa->username }}">{{ $wa->username }}</a>
      		@endforeach
			@foreach ($w->category as $wc)
      			in <a href="/category/{{ $wc->slug }}">{{ $wc->name }}</a>
      		@endforeach
			on </span>
		@if($w->type === "watched")
		<span timestamp="{{ $w->created_at }}">Watched since </span><span><a href="#" data-bs-toggle="modal" data-bs-target="#unwatchModal-{{ $w->id }}">Unwatch</a></span>
    	@endif
			
		</div>
		<div class="clear"></div>
		
	</li>
	@endforeach
</ul>

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