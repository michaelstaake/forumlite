@foreach($category as $c) @php ($pageTitle = $c->name)  @endforeach
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/index">Home</a></li>
    @foreach ($c['section'] as $cs)
      <li class="breadcrumb-item"><a href="/#{{ $cs->slug }}">{{ $cs->name }}</a></li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page">{{ $c->name }}</li>
  </ol>
</nav>

<div class="page-title">
	{{ $c->name }}
	@auth
    @if ($c->is_readonly == FALSE)
      <div class="float-sm-end"><a class="btn btn-primary" href="/newdiscussion/{{ $c->slug }}" role="button"><i class="bi bi-pencil-square"></i> New Discussion</a></div><br>
    @else
      @if (auth()->user()->group === "admin" || auth()->user()->group === "mod")
        <div class="float-sm-end"><a class="btn btn-primary" href="/newdiscussion/{{ $c->slug }}" role="button"><i class="bi bi-pencil-square"></i> New Discussion</a></div><br>
      @endif
    @endif
  @endauth
</div>

    <!--<nav class="page-navigation">
      <ul class="pagination pagination-sm justify-content-center">
        <li class="page-item disabled">
          <a class="page-link">&laquo;</a>
        </li>
        <li class="page-item"><a class="page-link active" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">&raquo;</a>
        </li>
      </ul>
    </nav> -->

    <ul class="forum-discussion-list">
      @foreach($results as $r)
        <li class="forum-discussion-li">
          <div class="forum-discussion-li-left">
            @foreach ($r['user'] as $ru)
              <img class="forum-discussion-li-avatar" src="{{asset('storage/avatars')}}/{{ $ru->avatar }}" />
            @endforeach
          </div>
          <div class="forum-discussion-li-right">
            <h6>
              <a href="/discussion/{{ $r->slug }}">{{ $r->title }}</a>
              @if ($r->is_locked == TRUE)
                <span class="badge bg-secondary" style="color:#FFFFFF;">Closed</span>
              @endif
            </h6>
            <span>Started by <a href="/member/{{ $ru->username }}">{{ $ru->username }}</a> on {{ $r->datetime }}</span>
            <span>
              {{ $r->views }}
              @if ($r->views == 1)
                view
              @else
                views
              @endif
            </span>
            <span>
              {{ $r->comments }}
              @if ($r->comments == 1)
                comment
              @else
                comments
              @endif
            </span>
            <span>Most recent reply <a href="/discussion/{{ $r->slug }}#lastreply">{{ $r->datetime2 }}</a></span>
          </div>
          <div class="clear"></div>
          
        </li>
      @endforeach
    </ul>
		



@include('includes.footer')