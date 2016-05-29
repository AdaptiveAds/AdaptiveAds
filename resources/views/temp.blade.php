<?php// no direct accessdefined( '_JEXEC' ) or die( 'Restricted access' );$document = JFactory::getDocument();$document->setGenerator('Faelain SEO Consultants');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >

<head>
  <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.js"></script>

  <script type="text/javascript">  //<![CDATA[
    jQuery.noConflict();  //]]>  </script>
  <jdoc:include type="head" />
  <meta name="geo.region" content="GB" />  <meta name="geo.placename" content="Gloucester" />
  <meta name="geo.position" content="51.8502;-2.255929" />
  <meta name="ICBM" content="51.8502, -2.255929" />

  <link rel="home" href="/" />
  <link rel="search" href="/component/search/" />
  <link rel="help" href="/contact-us.html" />
  <link rel="privacy" href="/privacy-policy.html" />
  <link rel="copyright" href="index.php?option=com_content&amp;view=article&amp;id=1:copyright&amp;catid=2:uncategorised" />
  <link rel="author" href="https://plus.google.com/116909708835558282890" />
  <link rel="publisher" href="https://plus.google.com/116909708835558282890" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/theme.css" type="text/css" />

  <script type="text/javascript">
  //<![CDATA[  sfHover = function() {
  	var sfEls = document.getElementById("menu").getElementsByTagName("LI");
  	for (var i=0; i<sfEls.length; i++) {
  		sfEls[i].onmouseover=function() {
  			this.className+=" sfhover";
  		}
  		sfEls[i].onmouseout=function() {
  			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
  		}
  	}
  }
  if (window.attachEvent) window.attachEvent("onload", sfHover);
  //]]>

</script>
</head>

<body>
  <!-- ************************** -->
  <!--          ROW | ONE         -->
  <!-- ************************** -->
  <div class="row one">
    <div class="wrapper">
      <div id="header">
        <div id="logo">
          <jdoc:include type="modules" name="logo"/>
        </div>
        <div id="nav">
          <jdoc:include type="modules" name="mainmenu"/>
        </div>
      </div>
      <div id="bannerText">
        <jdoc:include type="modules" name="banner-title"/>
        <div id="right">
          <jdoc:include type="modules" name="banner-intro"/>
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <!-- ************************** -->
  <!--          ROW | TWO         -->
  <!-- ************************** -->
  <div class="row two">
    <jdoc:include type="modules" name="featured"/>
    <div class="clear"></div>
  </div>
  <!-- ************************** -->
  <!--         ROW | THREE        -->
  <!-- ************************** -->
  <div class="row three">
    <div class="wrapper">
    <div class="left">
      <jdoc:include type="modules" name="video-content"/>
    </div>
    <div class="right">
      <jdoc:include type="modules" name="video"/>
    </div>
    <div class="clear"></div>
  </div>
</div>
<!-- ************************** -->
<!--         ROW | FOUR         -->
<!-- ************************** -->
<div class="row four">
  <div class="wrapper">
    <jdoc:include type="modules" name="classes"/>
    <div class="clear"></div>
  </div>
</div>
<!-- ************************** -->
<!--         ROW | FIVE         -->
<!-- ************************** -->
<div class="row five">
  <div class="wrapper">
    <div class="left">
      <jdoc:include type="modules" name="social-gallery"/>
    </div>
    <div class="right">
      <jdoc:include type="modules" name="newsletter"/>
    </div>
    <div class="clear"></div>
  </div>
</div>
<!-- ************************** -->
<!--         ROW | SIX          -->
<!-- ************************** -->
<div class="row six">
  <div id="footer">
    <div class="column"></div>
    <div class="column extend"></div>
    <div class="column"></div>
  </div>
  &copy; Copyright #### <?php echo date('Y'); ?>. All Rights Reserved.
  <a href="index.php?option=com_content&amp;view=article&amp;id=1:privacy-policy&amp;catid=2:uncategorised" title="Privacy Policy" rel="privacy">Privacy Policy</a>.
  <a href="http://www.openglobal.co.uk" title="E-commerce web design in Gloucestershire">E-commerce web design</a> by OpenGlobal E-commerce.
  <div class="clear"></div>
</div>
</body>
</html>
