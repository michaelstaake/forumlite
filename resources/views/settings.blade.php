@php ($pageTitle = "Settings")
@include('includes.header')

<div class="page-title">
	Settings
</div>


		<form method="post" action="{{ route('settings.submit') }}" class="">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="row">
				<div class="col">
					<br>
					<p><strong>Avatar</strong></p>
					<p>Your avatar is displayed on your profile and next to your content.</p>
					
					<table class="table table-flush avatar-table">
					  <tbody>
					  	@foreach($avatars as $a)
					  		<tr>
						      <td><input class="form-check-input" type="radio" name="avatar" value="{{ $a->filename }}" id="michael-default"
						      	@if(auth()->user()->avatar === $a->filename )
						      		checked
						      	@endif
						      	></td>
						      <td><img src="{{ asset('storage/avatars/') }}/{{ $a->filename }}" /></td>
						      @if(auth()->user()->avatar === $a->filename)
						      	<td>Current Avatar</td>
						      @else
						      	@if($a->filename != auth()->user()->username.'-default.png')
						      		<td><button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#avatarDeleteModal-{{ $a->filename }}">Delete</button></td>
						      	@endif
						      @endif
						    </tr>
					  	@endforeach
					    <tr>
					      <td><i class="bi bi-cloud-arrow-up"></i></td>
					      <td>Upload Avatar</td>
					      <td><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#avatarUploadModal">Upload</button></td>
					    </tr>
					  </tbody>
					</table>
				</div>
				<div class="col">
					<br>
					<p><strong>Signature</strong></p>
					<p>Your signature is displayed below your content.</p>
					<p><textarea class="form-control" aria-label="signature" name="signature">{{ auth()->user()->signature }}</textarea></p>
					@if ($can_signature == "FALSE")
					<div class="alert alert-warning" role="alert">Signatures are currently disabled. Your signature will not be displayed.</div>
					@endif
					<br>
					<p><strong>Location</strong></p>
					<p>This is displayed on your profile page.</p>
					<p><input type="text" class="form-control" aria-label="location" name="location" style="max-width: 200px;" value="{{ auth()->user()->location }}"></p>
					<br>
					<p><strong>Email Notifications</strong></p>
					<p>Here you can select which notifications alert you via email.</p>
					<p><div class="form-check">
						
					      	<input class="form-check-input" type="checkbox" value="1" name="wants_emails_my_discussions" id="checkReplyMyDiscussions"
					      	@if(auth()->user()->wants_emails_my_discussions == '1')
					      	checked
					    	@endif
					    	>
					    
					  <label class="form-check-label" for="checkReplyMyDiscussions">
					    Replies to my discussions
					  </label>
					</div></p>
					<p><div class="form-check">
					      	<input class="form-check-input" type="checkbox" value="1" name="wants_emails_watched_discussions" id="checkReplyWatchedDiscussions"
					      	@if(auth()->user()->wants_emails_watched_discussions == '1')
					      	checked
					    	@endif
					      	>
					  <label class="form-check-label" for="checkReplyWatchedDiscussions">
					    Replies to watched discussions
					  </label>
					</div></p>
				</div>
			</div>
			<p><button class="btn btn-primary" type="submit">Save</button></p>
		</form>
		<div class="row">
				<div class="col">
					<br>
					<p><strong>Change Email Address</strong></p>
					<p>Your email address is used for notifications and can be used to log in.</p>
					<p><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal">Change Email Address</button></p>
				</div>
				<div class="col">
					<br>
					<p><strong>Change Password</strong></p>
					<p>Your password is used to log in. Please use a unique, strong, password.</p>
					<p><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</button></p>
				</div>
			</div>


@foreach($avatars as $a)
  	@if($a->filename != auth()->user()->username.'-default.png' && @auth()->user()->avatar != $a->filename)
  	<!-- #avatarDeleteModal -->
  	<div class="modal fade" id="avatarDeleteModal-{{ $a->filename }}" tabindex="-1" aria-labelledby="avatarDeleteLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	    	<form method="post" action="{{ route('avatar.delete') }}" class="">
		      <div class="modal-header">
		        <h1 class="modal-title fs-5" id="avatarUploadLabel">Delete Avatar</h1>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<p>Are you sure you want to delete avatar: {{ $a->filename }}</p>
		      	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="mb-3">
				    <input type="hidden" id="avatar" name="avatar" value="{{ $a->filename }}">
				 </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-danger">Delete</button>
		      </div>
		  	</form>
	    </div>
	  </div>
	</div>
  	@endif
@endforeach

<!-- #avatarUploadModal -->
<div class="modal fade" id="avatarUploadModal" tabindex="-1" aria-labelledby="avatarUploadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="{{ route('avatar.upload') }}" class="" enctype="multipart/form-data">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="avatarUploadLabel">Upload Avatar</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="mb-3">
			    <input type="file" id="avatarFile" name="avatarFile">
			 </div>
			<p>Avatars must be a valid image format. Minimum size is 50x50px and maximum size is 500x500px. Avatars not square may be cropped when displayed.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Upload</button>
	      </div>
	  	</form>
    </div>
  </div>
</div>

<!-- #emailModal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="#" class="">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="emailModalLabel">Change Email Address</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
			<div class="mb-3">
			    <label for="newEmail1" class="form-label">New Email Address</label>
			    <input type="email" class="form-control" id="newEmail1" required="required">
			 </div>
			 <div class="mb-3">
			    <label for="newEmail2" class="form-label">Confirm New Email Address</label>
			    <input type="email" class="form-control" id="newEmail2" required="required">
			 </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="button" type="submit" class="btn btn-primary">Submit</button>
	      </div>
	  	</form>
    </div>
  </div>
</div>

<!-- #passwordModal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="#" class="">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="passwordModalLabel">Change Password</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
			<div class="mb-3">
			    <label for="oldPassword" class="form-label">Old Password</label>
			    <input type="password" class="form-control" id="oldPassword" required="required">
			 </div>
			 <div class="mb-3">
			    <label for="newPassword1" class="form-label">New Password</label>
			    <input type="password" class="form-control" id="newPassword1" required="required">
			 </div>
			 <div class="mb-3">
			    <label for="newPassword2" class="form-label">Confirm New Password</label>
			    <input type="password" class="form-control" id="newPassword2" required="required">
			 </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="button" type="submit" class="btn btn-primary">Submit</button>
	      </div>
	  	</form>
    </div>
  </div>
</div>

@include('includes.footer')