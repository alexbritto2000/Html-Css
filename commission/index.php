<?php
include('lib/config.php');
$pagetitle="Home";
include('include/html.php');
$res_welcome_content=$db_cms->select_query("select * from $table_welcomecontent");
$res_home_banner=$db_cms->select_query("select * from $table_banner");
$res_why_advance=$db_cms->select_query("select * from $table_advance");
$res_testimonials=$db_cms->select_query("select * from $table_testimonials");
$res_partners_section=$db_cms->select_query("select * from $table_partners_section");
$res_site_setting=$db_cms->select_query("select * from $table_site_settings");
$res_socialmedia=$db_cms->select_query("select * from $table_socialmedia");
?>
<?php include('include/header.php');?>
    <div class="slideshow-container">
	<?php foreach($res_home_banner as $res_banner) { ?>
        <div class="mySlides fade">
            <img src="<?php echo $sitepath;?>webuploads/thumb/banner/<?php echo $res_banner['banner_image']?>" alt="commission" style="width:100%"> 
        </div>
	<?php } ?>
			<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
        <br>
        <div style="text-align:center">
          <span class="dot" onclick="currentSlide(1)"></span> 
          <span class="dot" onclick="currentSlide(2)"></span> 
          <span class="dot" onclick="currentSlide(3)"></span> 
        </div>
		
	  <div class="wrapper">
        <div class="head">
            <h6 class="cbridge"><?=get_symbol($res_welcome_content[0]['title']);?></h6>
            <div class="wrapper">
            <div class="con">
            <?=get_symbol($res_welcome_content[0]['description']);?></div>
            </div> 
        </div>
      </div>
	  
	  <div class="row" >
	  <div class="wrapper">
	  <h5 class="wt">When should I get a commission advance?</h5>
	  <?php foreach($res_why_advance as $res_advance) { ?>
	  <div class="column">
	  	<div class="expanse">
	  		<img src="<?php echo $sitepath;?>webuploads/thumb/services/<?php echo $res_advance['content_image']?>" alt="commission">
	  		<div class="content1">
				<p><?php echo $res_advance['content_title']?></p>
	  		</div>
	  	</div>
	  </div>
	  <?php } ?>
	  
	  </div>
	 </div>
<div class="test">
  <h1>Testimonials</h1>
  <img src="images/comma.png" class="comma" alt="comma">
  <div class="wrapper">
    <p class="descrip"><?=get_symbol($res_testimonials[0]['description']);?></div>
      <p class="author"><?=get_symbol($res_testimonials[0]['title']);?></p>
      <div class="bullet">
        <img src="images/bullet_green.png" alt="bull">
        <img src="images/bullet_white.png" alt="bull">
        <img src="images/bullet_white.png" alt="bull">
      </div>
      <div class="clear"></div>
  </div>
</div>
    <div class="partner">
     <div class="wrapper">
        <h3>Our partners</h3>
        <div class="part">
          <ul>
			<?php foreach($res_partners_section as $res_partners_section) { ?>
            <li><a href="#">
              <img alt="save energy" src="<?php echo $sitepath;?>webuploads/thumb/partners/<?php echo $res_partners_section['content_logo']?>"</a></li>
			<?php } ?>
              </div>
              <div class="clear"></div>
          </ul>             
          </div>
        </div>
    </div>
<?php include('include/footer.php');?>     
<script>

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}

</script>