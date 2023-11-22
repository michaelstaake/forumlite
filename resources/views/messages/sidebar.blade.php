<div class="card messages-folder-list">
  <div class="card-header">
    Folders
  </div>
  <ul class="list-group list-group-flush">
    
    <a href="/messages/inbox" class="list-group-item list-group-item-action @if ($folder === "inbox")  current-folder  @endif">
      <p>Inbox <span class="badge text-bg-primary" id="messages-badge"></span></p>
    </a>
    <a href="/messages/sent" class="list-group-item list-group-item-action @if ($folder === "sent")  current-folder  @endif">
      <p>Sent</p>
    </a>
  </ul>
</div>