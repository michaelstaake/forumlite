@php ($pageTitle = "Search Results")
@include('includes.header')

<div class="page-title">
  @if ($type === "searchUserDiscussions")
    <a href="http://localhost/member/{{ $query }}">{{ $query }}</a>'s Discussions
  @elseif ($type === "searchUserComments")
    <a href="http://localhost/member/{{ $query }}">{{ $query }}</a>'s Comments
  @else
    Search Results for "{{ $query }}"
  @endif
  <div class="float-sm-end"><a class="btn btn-primary" href="/search" role="button"><i class="bi bi-search"></i> New Search</a></div><br>
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
</nav>-->

<ul class="search-result-list">
  @forelse($results as $r)
    @if ($r->type === "discussion")
    <li class="search-result-li">
      <div class="search-result-li-left">
        @foreach ($r['user'] as $ru)
          <img class="search-result-li-avatar" src="{{asset('storage/avatars')}}/{{ $ru->avatar }}" />
        @endforeach
      </div>
      <div class="search-result-li-right">
        <h6>
          <a href="/discussion/{{ $r->slug }}">{{ $r->title }}</a>
        </h6>
        <p>{{ $r->content_summary }}</p>
        <span timestamp="{{ $r->created_at }}">Discussion by <a href="/member/{{ $ru->username }}">{{ $ru->username }}</a> in @foreach ($r['section'] as $rs) <a href="/#{{ $rs->slug }}">{{ $rs->name }}</a> @endforeach / @foreach ($r['category'] as $rc) <a href="/category/{{ $rc->slug }}">{{ $rc->name }}</a> @endforeach on </span>
      </div>
      <div class="clear"></div>
    </li>
    @else
    <li class="search-result-li">
      <div class="search-result-li-left">
        @foreach ($r['user'] as $ru)
          <img class="search-result-li-avatar" src="{{asset('storage/avatars')}}/{{ $ru->avatar }}" />
        @endforeach
      </div>
      <div class="search-result-li-right">
        <h6>
          <a href="/discussion/{{ $r->slug }}#comment-{{ $r->id }}">{{ $r->title }}</a>
        </h6>
        <p>{{ $r->content_summary }}</p>
        <span timestamp="{{ $r->created_at }}">Comment by <a href="/member/{{ $ru->username }}">{{ $ru->username }}</a> in @foreach ($r['section'] as $rs) <a href="/#{{ $rs->slug }}">{{ $rs->name }}</a> @endforeach / @foreach ($r['category'] as $rc) <a href="/category/{{ $rc->slug }}">{{ $rc->name }}</a> @endforeach on </span>
      </div>
      <div class="clear"></div>
    </li>
    @endif
  @empty
    No results found.
  @endforelse
</ul>

@if ($type === "searchUserDiscussions")
  <div class="forum-pagination">
    {{-- $results->links() --}}
  </div>
@elseif ($type === "searchUserComments")
  <div class="forum-pagination">
    {{-- $results->links() --}}
  </div>
@else
  <div class="forum-pagination">
    {{-- $results->links() --}}
  </div>
@endif


@include('includes.footer')