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
	            	if (badgeData.numNotifications > 0) {
	            		$('span#notifications-badge').html(badgeData.numNotifications);
	            	}
	            	if (badgeData.numMessages > 0) {
	            		$('span#messages-badge').html(badgeData.numMessages);
	            	}
	            	if (badgeData.numReports > 0) {
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

<script type="text/javascript">
	const dateTimeOptions = {
		weekday: 'long',
		year: 'numeric',
		month: 'long',
		day: 'numeric',
		hour: 'numeric',
		minute: '2-digit'
	};

	const formatter = new Intl.RelativeTimeFormat(undefined, {
		numeric: "auto",
	})

	const DIVISIONS = [
		{ amount: 60, name: "seconds" },
		{ amount: 60, name: "minutes" },
		{ amount: 24, name: "hours" },
		{ amount: 7, name: "days" },
		{ amount: 4.34524, name: "weeks" },
		{ amount: 12, name: "months" },
		{ amount: Number.POSITIVE_INFINITY, name: "years" },
	]

	function formatTimeAgo(date) {
		let duration = (date - new Date()) / 1000

		for (let i = 0; i < DIVISIONS.length; i++) {
			const division = DIVISIONS[i]
			if (Math.abs(duration) < division.amount) {
			return formatter.format(Math.round(duration), division.name)
			}
			duration /= division.amount
		}
	}
	
	function updateTimestamps(){
		document.querySelectorAll("[timestamp]").forEach((timeElement) => {
			let timestampContents = "";
			let absoluteTimestamp = "";
			let timestamp = new Date(timeElement.getAttribute("timestamp")+" UTC");
			if(((Math.abs(new Date().getTime() - timestamp.getTime())) / (1000*60*60)) <= 48){
				timestampContents = formatTimeAgo(timestamp);
				absoluteTimestamp = timestamp.toLocaleDateString(undefined, dateTimeOptions);
			}else{
				timestampContents = timestamp.toLocaleDateString(undefined, dateTimeOptions);
				absoluteTimestamp = timestampContents;
			}
			if(timeElement.querySelectorAll("div.timestampContents").length == 0){
				const timestampContentsElem = document.createElement("div");
				timestampContentsElem.style.display = "inline-block";
				timestampContentsElem.textContent = timestampContents;
				timestampContentsElem.classList.add("timestampContents");
				timeElement.insertAdjacentElement("beforeend", timestampContentsElem);
			}else{
				timeElement.querySelector("div.timestampContents").textContent = timestampContents;
			}
			timeElement.setAttribute("absolute-timestamp", absoluteTimestamp);
		});
	}

	setInterval(() => {
		updateTimestamps();
	}, 60*1000);
	updateTimestamps();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>