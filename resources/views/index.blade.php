@php ($pageTitle = "Home")
@include('includes.header')

<div class="page-title">
	{{ config('app.name'); }}
	@auth
        <div class="float-sm-end"><a class="btn btn-primary" href="newdiscussion" role="button"><i class="bi bi-pencil-square"></i> New Discussion</a></div><br>
    @endauth
</div>

<div class="row">
	<div class="col-9">
		@foreach($sections as $s)
			<div class="card forum-category-card" id="{{ $s->slug }}">
				<div class="card-header">
					{{ $s->name }}
				</div>
				<ul class="list-group list-group-flush">
					@foreach($categories as $c)
						@if ($c->section === "$s->id")
						<a href="/category/{{ $c->slug }}" class="list-group-item list-group-item-action">
						<h6>{{ $c->name }}</h6>
						<p>{{ $c->description }}</p>
						<span>
			              {{ $c->numDiscussions }}
			              @if ($c->numDiscussions == 1)
			                discussion
			              @else
			                discussions
			              @endif
			            </span>
						<span>
			              {{ $c->numComments }}
			              @if ($c->numComments == 1)
			                comment
			              @else
			                comments
			              @endif
			            </span>
						<!--<span>Most recent post X</span>-->
						@endif
					</a>
					@endforeach
					
				</ul>
			</div>
		@endforeach
	</div>
	<div class="col-3">
        @include('includes.sidebar')
	</div>
</div>

@include('includes.footer')