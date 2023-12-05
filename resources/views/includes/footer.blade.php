</div><!-- closes .container from header -->
</div> <!-- closes .content from header -->

<div class="footer">
	<center><p>Copyright &copy; <?php echo date("Y"); ?> {{ config('app.name'); }}<a href="/">Home</a> <a href="/terms-rules">Terms and Rules</a> <a href="/privacy-policy">Privacy Policy</a> <a href="/contact">Contact</a> <a href="http://forumlite.com/" target="_blank">Powered by Forumlite</a> </p></center>
</div>

@auth
	<script type="text/javascript">
	    jQuery(document).ready(function($getBadges){
	    	$getBadges.ajax({
	            type: "GET",
	            url: '/get-badges',
	            dataType: 'json',
	            success: function (badgeData) {
	            	if (badgeData.numNotifications > "0") {
	            		$('span#notifications-badge').html(badgeData.numNotifications);
	            	}
	            	if (badgeData.numMessages > "0") {
	            		$('span#messages-badge').html(badgeData.numMessages);
	            	}
	            	if (badgeData.numMessages > "0") {
	            		$('span#reports-badge').html(badgeData.numReports);
	            	}

	            },
	            error: function (badgeData) {
	                console.log("error:getBadges");
	            }
            });
	    });

	</script>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>