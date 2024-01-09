@php ($pageTitle = "Notifications")

@include('includes.header')

<div class="page-title">
	Notifications
  <div class="float-sm-end"><a class="btn btn-secondary" href="/notifications/clear" role="button"><i class="bi bi-x-circle"></i> Clear</a></div><br>
</div>

<ul class="list-group list-group-flush notifications-all">
  @forelse($notifications as $n)
    <a href="/notification/{{ $n->id }}" class="list-group-item list-group-item-action notifications-item">
      <h6>
        @if ($n->status == "unread")
          <strong>{{ $n->typeFriendly }} <i class="bi bi-bell-fill"></i></strong>
        @else
          {{ $n->typeFriendly }} <i class="bi bi-bell"></i>
        @endif
      </h6>
      <p>{{ $n->content }}</p>
      <span timestamp="{{ $n->created_at }}"></span>
    </a>
  @empty
    No notifications.
  @endforelse
</ul>

<div class="forum-pagination">
  {{ $notifications->links() }}
</div>

@include('includes.footer')