<!doctype html>
<html class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo config_item('company_name'); ?></title>

<link rel="shortcut icon" href="<?php echo theme_img('favicon.png');?>" type="image/png" />
<?php if(isset($meta)):?>
<?php echo (strpos($meta, '<meta') !== false) ? $meta : '<meta name="description" content="'.$meta.'" />';?>
<?php else:?>
    <meta name="keywords" content="<?php echo config_item('default_meta_keywords');?>" />
    <meta name="description" content="<?php echo config_item('default_meta_description');?>" />
<?php endif;?>
<link rel="stylesheet" href="<?php echo theme_url('bower_components');?>/bootstrap/dist/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo theme_url('bower_components');?>/font-awesome/css/font-awesome.css" />
<script src="<?php echo theme_url('bower_components');?>/modernizr/modernizr.js"></script>

<?php
$_css = new CSSCrunch();
$_css->addFile('owl.carousel');
$_css->addFile('magnific-popup');
$_css->addFile('process-cart');
$_css->addFile('main');

$_js = new JSCrunch();
$_js->addFile('modernizr-2.8.3.min');
$_js->addFile('jquery-1.11.3.min');
$_js->addFile('jquery.magnific-popup.min');
$_js->addFile('jquery.spin');
$_js->addFile('owl.carousel.min');
$_js->addFile('gumbo');
$_js->addFile('elementQuery.min');
$_js->addFile('jquery.colorbox-min');
$_js->addFile('main');

if(true) //Dev Mode
{
    //in development mode keep all the css files separate
    $_css->crunch(true);
    $_js->crunch(true);
}
else
{
    //combine all css files in live mode
    $_css->crunch();
    $_js->crunch();
}


//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
    echo $additional_header_info;
}
?>
<script src="<?php echo theme_url('bower_components');?>/bootstrap/js/tooltip.js"></script>
<script src="<?php echo theme_url('bower_components');?>/bootstrap/js/tab.js"></script>
<script src="<?php echo theme_url('bower_components');?>/bootstrap/js/carousel.js"></script>
</head>
<body>
<!--[if lt IE 10]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<!-- Fixed navbar -->
<header class="navbar navbar-default navbar-fixed-top">
    
    <div id="header-container">
        <div class="header-serch-menu form-group">
        <?php echo form_open('search', 'class="form-search form-inline"');?>
            <input id="search" name="term" type="text" class="form-control search-query col-sm-1" placeholder="<?php echo lang('search');?>" />
          </form>
        </div> 
        <div id="logo-container">
            <h1>
                <a href="/"><img src="<?php echo theme_img('musyme-logo.png');?>" width="170" alt="Musyme logo"></a>
            </h1>
        </div>

        <div class="header-cart-menu">
            <div class="header-links" >
                <ul class="nav navbar-nav pull-right">
                    <?php if(CI::Login()->isLoggedIn(false, false)):?>                    
                    <li>
                        <a href="<?php echo  site_url('my-account');?>">
                            <i class="fa fa-unlock hidden-lg hidden-md" title="<?php echo lang('my_account')?>"></i>
                            <span class="hidden-sm hidden-xs"><?php echo lang('my_account')?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('logout');?>">
                            <i class="fa fa-crosshairs hidden-lg hidden-md" title="<?php echo lang('logout');?>"></i>
                            <span class="hidden-sm hidden-xs"><?php echo lang('logout');?></span>
                        </a>
                    </li>
                    <?php else:?>
                    <li><a href="<?php echo  site_url('login');?>"><?php echo lang('login');?></a></li>
                    <li><a href="<?php echo  site_url('register');?>"><?php echo lang('register');?></a></li>
                    <?php endif; ?>
                    
                    <li>
                        <a href="<?php echo  site_url('checkout');?>">
                            <i class="fa fa-shopping-cart"></i>
                                <?php echo lang('checkout');?>
                                <span class="hidden-sm hidden-xs">
                                    <span id="itemCount" class="badge"><?php echo GC::totalItems();?></span>
                                </span>
                        </a>
                    </li>                                                                                               
                </ul>
            </div>
        </div>
        <nav>
            <ul class="nav-list" id="main-nav-list">
                <li>
                    <a title="<?php echo lang('nav_movies');?>" href="http://musy.me/movies">
                        <img alt="<?php echo lang('nav_movies');?>" src="<?php echo theme_img('nav-btn1.png');?>">
                    </a>
                </li>
                <li>
                    <a title="<?php echo lang('nav_songs');?>" href="http://musy.me/songs">
                        <img alt="<?php echo lang('nav_songs');?>" src="<?php echo theme_img('nav-btn2.png');?>">
                    </a>
                </li>
                <li class="lang">                  
                        <a title="<?php echo lang('nav_select_language');?>" href="#">
                            <img alt="<?php echo lang('nav_select_language');?>" src="<?php echo theme_img('flag-bg.jpg');?>">
                        </a>
                    <ul class="sub-nav-list">
                                    <li>
                <div>
                    <a title="en" href="#"><img alt="English" src="<?php echo theme_img('flag-en.jpg');?>"></a>
                </div>
            </li>
                    <li>
                <div>
                    <a title="fr" href="#"><img alt="French" src="<?php echo theme_img('flag-fr.jpg');?>"></a>
                </div>
            </li>
                    <li>
                <div>
                    <a title="nl" href="#"><img alt="Dutch" src="<?php echo theme_img('flag-nl.jpg');?>"></a>
                </div>
            </li>
                    <li>
                <div>
                    <a title="es" href="#"><img alt="Spanish" src="<?php echo theme_img('flag-es.jpg');?>"></a>
                </div>
            </li>
                    <li>
                <div>
                    <a title="ru" href="#"><img alt="Russian" src="<?php echo theme_img('flag-ru.jpg');?>"></a>
                </div>
            </li>
                    <li>
                <div>
                    <a title="de" href="#"><img alt="German" src="<?php echo theme_img('flag-de.jpg');?>"></a>
                </div>
            </li>
                    <li>
                <div>
                    <a title="bg" href="#"><img alt="Bulgarian" src="<?php echo theme_img('flag-bg.jpg');?>"></a>
                </div>
            </li>
                            </ul>
                </li>
                <li>
                    <a title="<?php echo lang('nav_books');?>" href="http://musy.me/audiobooks">
                        <img alt="<?php echo lang('nav_books');?>" src="<?php echo theme_img('nav-btn4.png');?>">
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
</header>



<div class="container">
    <div class="row">
    <?php if (CI::session()->flashdata('message')):?>
        <div class="alert blue">
            <?php echo CI::session()->flashdata('message');?>
        </div>
    <?php endif;?>

                    
                
