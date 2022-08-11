<?php
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];

if($currentFile=="index.php"){ $index="class='active'"; } else {  $index=""; }

if($currentFile=="welcome_content.php"){$welcome_content="active"; } else {  $welcome_content=""; } 
if($currentFile=="why_advance.php"){$why_advance="active"; } else {  $why_advance=""; }
if($currentFile=="testimonials.php"){$testimonials="active"; } else {  $testimonials=""; } 

if($currentFile=="partners_section.php"){ $partners_section="active"; } else {  $partners_section=""; } 

if(($currentFile=="testimonials.php") ||($currentFile=="why_advance.php") || ($currentFile=="partners_section.php") || ($currentFile=="welcome_content.php") ||($currentFile=="homemanage.php")){ $homemanage="active"; } else {  $homemanage=""; }

if(($currentFile=="home_banner.php") || ($currentFile=="banner_content.php")){ $banner="active"; } else {  $banner=""; }
if($currentFile=="site_settings.php"){ $site_settings="class='active'"; } else {  $site_settings=""; }
if($currentFile=="socialmedia.php"){ $socialmedia="class='active'"; } else {  $socialmedia=""; }


?>
<aside class="main-sidebar" style="top: 50px;">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
                
            <li <?php echo $index;?>>
                <a href="index.php">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
			<li class="treeview <?php echo $homemanage;?>" <? if($welcome_content || $why_advance || $testimonials|| $partners_section) { echo "style='display:block'"; }else{ echo ""; } ?> >
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span>Home Page Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">  
                    
                    <li class="nav-item <?php echo $welcome_content?>"><a class="nav-link" href="welcome_content.php"><i class="menu-icon fa fa-caret-right"></i>Welcome Content</a></li> 
					<li class="nav-item <?php echo $why_advance?>"><a class="nav-link" href="why_advance.php"><i class="menu-icon fa fa-caret-right"></i>Why advance?</a></li>
					<li class="nav-item <?php echo $testimonials;?>"><a class="nav-link" href="testimonials.php"><i class="menu-icon fa fa-caret-right"></i>Testimonials</a></li>
					<li class="nav-item <?php echo $partners_section;?>"><a class="nav-link" href="partners_section.php"><i class="menu-icon fa fa-caret-right"></i>Partners Section</a></li>
				</ul>
			</li>
			<li class="treeview <?php echo $banner;?>" <? if($banner_image || $banner_content) { echo "style='display:block'"; }else{ echo ""; } ?> >
                <a href="#">
                    <i class="fa fa-image"></i>
                    <span>Banner Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
				<li <?php echo $banner_image;?>><a href="home_banner.php"><i class="menu-icon fa fa-caret-right"></i>Banner Image</a></li>
					<!--<li <?php echo $banner_content;?>><a href="banner_content.php"><i class="menu-icon fa fa-caret-right"></i>Banner Content</a></li>-->
				</ul>
			</li>
			<!--<li <?php echo $banner;?>>
                <a href="home_banner.php">
                    <i class="fa fa-image"></i>
                    <span>Banner Management</span>
                </a>
				<ul class="treeview-menu">
            </li>-->
			<!--<li <?php echo $gallery;?>>
                <a href="gallery.php">
                    <i class="fa fa-image"></i>
                    <span>Gallery Management</span>
                </a>
            </li>
			<li <?php echo $services;?>>
                <a href="services_content.php">
                    <i class="fa fa-cogs"></i>
                    <span>Services Management</span>
                </a>
            </li> -->
			<li <?php echo $site_settings;?>>
                <a href="site_settings.php">
                    <i class="fa fa-cogs"></i>
                    <span>Site Settings</span>
                </a>
            </li>
			<li <?php echo $socialmedia;?>>
                <a href="socialmedia.php">
                    <i class="fa fa-address-book"></i>
                    <span>Social media</span>
                </a>
            </li>
        </ul>
    </section>
</aside>