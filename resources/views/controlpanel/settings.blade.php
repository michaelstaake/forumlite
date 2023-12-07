@php ($pageTitle = "Settings")
@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/controlpanel">Control Panel</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
  </ol>
</nav>

<div class="page-title">
	Settings
</div>

<ul class="nav nav-tabs" id="settingsTabs" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">General Settings</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages-tab-pane" type="button" role="tab" aria-controls="pages-tab-pane" aria-selected="false">Pages</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="integration-tab" data-bs-toggle="tab" data-bs-target="#integration-tab-pane" type="button" role="tab" aria-controls="integration-tab-tab-pane" aria-selected="false">Integration</button>
	</li>
</ul>

<form method="post" action="{{ route('controlpanel.settingsSubmit') }}" class="">

<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="tab-content" id="settingsTabsContent">
	<div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
		<br>
		<p><strong>General Settings</strong></p>
		<div class="mb-3 form-check">
			<input type="checkbox" class="form-check-input" id="can_register" name="can_register" value="yes" 
			@if($can_register == 'yes')
			checked
			@endif
			>
			<label class="form-check-label" for="can_register">Allow Registration</label>
		</div>
		<div class="mb-3 form-check">
			<input type="checkbox" class="form-check-input" id="can_signature" name="can_signature" value="yes" 
			@if($can_signature == 'yes')
			checked
			@endif
			>
			<label class="form-check-label" for="can_signature">Allow Signatures</label>
		</div>
		<p><strong>Maintenance Mode</strong></p>
		<p><select class="form-select" name="maintenance_mode" style="max-width:300px;">
			<option value="enabled" 
			@if($maintenance_mode == 'enabled')
			selected
			@endif
			>Enabled</option>
			<option value="disabled" 
			@if($maintenance_mode == 'disabled')
			selected
			@endif
			>Disabled</option>
		</select></p>
		<div class="mb-3">
			<label for="maintenance_message" class="form-label">Maintenance Mode Message</label>
			<input type="text" class="form-control" id="maintenance_message" aria-describedby="maintenance_message_help" name="maintenance_message" value="{{ $maintenance_message }}">
			<div id="maintenance_message_help" class="form-text">You can add a custom message here that will display if maintenance mode is enabled.</div>
		</div>
		<p><strong>Contact Link</strong></p>
		<p><select class="form-select" name="contact_type" style="max-width:300px;">
			<option value="default" 
			@if($contact_type == 'default')
			selected
			@endif
			>Default Contact Page</option>
			<option value="custom"
			@if($contact_type == 'custom')
			selected
			@endif 
			>Custom Contact Link</option>
		</select></p>
		<div class="mb-3">
			<label for="contact_link" class="form-label">Custom Contact Link</label>
			<input type="text" class="form-control" id="contact_link" aria-describedby="contact_link_help" name="contact_link" value="{{ $contact_link }}">
			<div id="contact_link_help" class="form-text">If you wish to use a Custom Contact Link, enter the complete URL here, like https://www.example.com/contact.php</div>
		</div>
	</div>
	<div class="tab-pane fade" id="pages-tab-pane" role="tabpanel" aria-labelledby="pages-tab" tabindex="0">
		<br>
		<p>Here you can set the content for your <a href="/terms-rules" target="_blank">Terms and Rules</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a> pages. Forumlite requires users to check they agree to both upon registering and these links are always displayed in the footer as well.</p>
		<p><strong>Terms and Rules</strong></p>
		<p><textarea class="form-control" rows="10" name="terms_content">{{ $terms_content }} </textarea></p>
		<p><strong>Privacy Policy</strong></p>
		<p><textarea class="form-control" rows="10" name="privacy_content">{{ $privacy_content }}</textarea></p>
	</div>
	<div class="tab-pane fade" id="integration-tab-pane" role="tabpanel" aria-labelledby="integration-tab" tabindex="0">
		<br>
		<p>Use the default header and footer or replace them with your own code to easily integrate your forum with the rest of your website or customize it.</p>
		<p><strong>Header</strong></p>
		<p><select class="form-select" style="max-width:300px;" name="header">
			<option value="default" 
			@if($header == 'default')
			selected
			@endif
			>Default</option>
			<option value="custom" 
			@if($header == 'custom')
			selected
			@endif
			>Custom</option>
		</select></p>
		<p><textarea class="form-control" rows="10" name="header_content">{{ $header_content }}</textarea></p>
		<p><strong>Footer</strong></p>
		<p><select class="form-select" style="max-width:300px;" name="footer">
			<option value="default" 
			@if($footer == 'default')
			selected
			@endif
			>Default</option>
			<option value="custom" 
			@if($footer == 'custom')
			selected
			@endif
			>Custom</option>
		</select></p>
		<p><textarea class="form-control" rows="10" name="footer_content" disabled>{{ $footer_content }}</textarea></p>
	</div>
</div>
<hr>
<p><button class="btn btn-primary" type="submit">Save</button></p>

</form>
	

@include('includes.footer')