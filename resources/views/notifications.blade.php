@php ($pageTitle = "Notifications")

@include('includes.header')

<div class="page-title">
	Notifications
  <div class="float-sm-end"><a class="btn btn-secondary" href="/notifications/clear" role="button"><i class="bi bi-x-circle"></i> Clear</a></div><br>
</div>

  <ul class="list-group list-group-flush notifications-all">
    @foreach($notifications as $n)
      <a href="{{ $n->link }}" class="list-group-item list-group-item-action notifications-item">
        <h6>{{ $n->typeFriendly }}</h6>
        <p>{{ $n->content }}</p>
        <span timestamp="{{ $n->created_at }}"></span>
      </a>
    @endforeach
  </ul>

@include('includes.footer')