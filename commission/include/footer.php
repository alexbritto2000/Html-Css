
	<div class="row1">
		<div class="wrapper">
			<div class="column2">
			<h4>NAVIGATION</h4>
			<ul>
				<li class='first2'><a href="#" class="first_high" style="color:#00ab50">Home</a></li>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Services</a></li>
				<li><a href="#">Projects</a></li>
				<li><a href="#">FAQ</a></li>
				<li><a href="#" class="last1">Contact Us</a></li>
			</ul>
			</div>
			<div class="column2">
			<div class="call">
				<h4>GET IN TOUCH</h4>
				<div class="callus"><img src="images/Location_Icon.png" class="im"/><p>&nbsp;<?=get_symbol($res_site_settings[0]['site_address']);?></p></div>
				<div class="callus"><br>
					<img src="images/Phone-icon.png"  class="im"/><a href="tel:801-946-3312"><p>&nbsp;801-946-3312</p></a></div><br>
				<div class="callus"><img src="images/mail-icon.png"  class="im"/><a href="mailto:info@mycommissionbridge.com"><p>&nbsp;<?=get_symbol($res_site_settings[0]['site_email']);?></p></a></div>
				</div>
			</div>
			<div class="column2">
			<h4>CONNECT ONLINE</h4>
				<ul>
				<div class="socialicons">
				<li><a href="#" target="_blank">
					<img alt="save energy" src="images/facebook.png"></li></a>
				<li><a href="#" target="_blank">
					<img alt="save energy" src="images/twitter.png"></li></a>
				<li><a href="#" target="_blank">
					<img alt="save energy" src="images/googleplus.png"></li></a>
				<li><a href="#" target="_blank">
					<img alt="save energy" src="images/instagrame.png"></li></a>
				</ul>
				</div>
			</div> 
			<div class="clear"></div>
		</div> 
	</div> 
</body>
<footer><?=get_symbol($res_site_setting[0]['site_copyright']);?></footer>
</html>