<aside class="widget widget_meta">
<h3 class="widget-title">Calculate Your Bandwidth</h3>
	<form name="reviewpon" id="reviewpon-form" method="post" action="#">
		<ul>
			<li><input type="url" name="website" id="website" placeholder="Website URL" autocomplete="on" value="http://" tabindex="3" style="margin-bottom: 5px;" style="width: 170px;"></li>
			<li><input type="people" name="visitors" id="visitors" placeholder="Monthly Page View?" tabindex="4" class="txtinput" style="margin-bottom: 5px;" style="width: 170px;"></li>
		</ul>
		<ul>
			<li><input type="submit" name="submit" id="submitbtn" class="submitbtn" tabindex="7" value="Calculate My Bandwidth!" style="width: 170px;"></li>
			<li id="bandwidthInfo">Your monthly usage is <br/><strong><span id="bandwidth"></span> Mbytes</strong></li>
			<li><span id="errorMsg"></span></li>
		<ul>
	</form>
</aside>