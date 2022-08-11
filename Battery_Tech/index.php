<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title>Home - Battery Tec</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700' rel='stylesheet' type='text/css'>
<link href="css/stylz.css" type="text/css" rel="stylesheet" />
<link href="css/media.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/topmenu.css">
<link rel="stylesheet" type="text/css" href="css/slick.css"/>
<!--<link rel="stylesheet" type="text/css" href="css/slick-theme.css"/>-->
</head>
<body>
<div class="headerbg">
	<div class="wrapper">
    <div class="logo"><a href="index.php"><img src="images/logo.png" alt="Battery Tec" border="0" /></a></div>
    <div class="header_right">
    	<div class="search_bg">
        <div class="search_box">
        <input type="text" class="search_txtbox" onfocus="if (this.value == 'Search') {this.value='';}" onblur="if (this.value == '') {this.value='Search';}" value="Search"/>
        <input type="submit" class="search_btn" value="" />
        <div class="clear"></div>
        </div>
        <div class="clear"></div>
        </div>
        <div class="clear_right"></div>
        <div class="callus"><img src="images/phone-icon.png" />&nbsp;CALLUS:(888) 878.2642</div>
    </div>
    <div class="clear"></div>
    
    <div id='topnav'>
    <a id='navbtn' href='#'>Nav Menu</a>
    <nav id='menus' class='topnav'>
    
    <div class="navi">
    	<ul>
        <li class="first"><a href="#" class="first_highlight">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#" class="last">Contact Us</a></li>
        </ul>
    </div>
    </nav>
    </div>
    
    <div class="clear"></div>
    <div class="banner">
    <img src="images/banner.jpg"/>
    <div class="bannerbox">
    	<h2>Industrial Battery Charger Services</h2>
        <p>We can supply you with new and used forklift battery chargers to keep your industrial fleet running efficiently</p>
    </div>
    </div>
    </div>
</div>
<div class="wrapper">
	<img src="images/shadow.jpg" />
	<div class="welcome">
    	<h1>Welcome to battery tec</h1>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exercitation Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud</p>
        <a href="#"><img src="images/learnmore.jpg" class="learmore" border="0" /></a>
    </div>
    <div class="services">
    	<div class="services_img"><img src="images/service.jpg" /></div>
    	<div class="services_info">
        	<img src="images/shadow_img.png" />
            <h2>Energy and industrial systems</h2>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exercitation Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud</p>
        </div>
        <div class="clear"></div>
    </div>
    
</div>

<div class="gallery">
<div class="wrapper">
    <div class="gallery_title">Photo Gallery</div>
    <div class="gallery_box">
    <div class="gallery_box_align">
    <div class="responsive">
    	<div class="img_circle"><img src="images/image_1.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
        <div class="img_circle"><img src="images/image_2.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
        <div class="img_circle"><img src="images/image_3.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
        <div class="img_circle"><img src="images/image_4.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
        <div class="img_circle"><img src="images/image_1.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
        <div class="img_circle"><img src="images/image_2.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
        <div class="img_circle"><img src="images/image_3.jpg" /><br/><img src="images/gallery-shadow.png" class="shadow" /></div>
	</div>
    </div>
    </div>
</div>
</div>

<div class="footer">
	<div class="wrapper">
    <p><span>Copyright</span> &copy; 2015 batterytech.net. All rights reserved | <a href="#">Terms and conditions</a> | <a href="#">Privacy Policy</a></p>
    </div>
</div>


<script type="text/javascript" src="js/jquery_min11.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="js/slick.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
     $('.responsive').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
    });
  </script>
<script src="js/topmenu.js" type="text/javascript"></script>
</body>
</html>