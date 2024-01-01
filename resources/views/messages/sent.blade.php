@php ($pageTitle = "Sent")

@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/messages">Messages</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sent</li>
  </ol>
</nav>

<div class="page-title">
  Sent
  <div class="float-sm-end"><a class="btn btn-primary" href="/message/new" role="button"><i class="bi bi-send"></i> New Message</a></div><br>
</div>

<div class="row">
	<div class="col-3">
    @include('messages.sidebar')
	</div>
	<div class="col-9">
    <div class="card messages-list">
      <div class="card-header">
        Sent
      </div>
      <ul class="list-group list-group-flush">
        @forelse($messages as $m)
          <a href="/message/{{ $m->id }}" class="list-group-item list-group-item-action">
            <h6>{{ $m->subject }}</h6>
            <p>{{ $m->content }}</p>
            <span>To: 
              @foreach ($m['user'] as $mu)
                {{ $mu->username }}
              @endforeach
            </span><span timestamp="{{ $m->created_at }}"></span>
          </a>
        @empty
          No messages exist in this folder.
        @endforelse
      </ul>
    </div>
    <div class="forum-pagination">
			{{ $messages->links() }}
		</div>
	</div>
</div>

@include('includes.footer')