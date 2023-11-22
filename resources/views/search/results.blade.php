@php ($pageTitle = "Search Results")
@include('includes.header')

<div class="page-title">
	Search Results
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

<ul class="forum-discussion-list">
  @foreach($results as $r)
    <li class="forum-discussion-li">
      <h6><a href="/discussion/{{ $r->slug }}">{{ $r->name }}</a></h6>
      <span>Started by @foreach ($r['user'] as $ru) <a href="/member/{{ $ru->username }}">{{ $ru->username }}</a> @endforeach on August 10th, 2023</span><span>49.1K views</span><span>586 comments</span><span>Most recent reply <a href="discussion#lastreply">Today at 2:25 PM</a></span>
    </li>
  @endforeach
</ul>



@include('includes.footer')