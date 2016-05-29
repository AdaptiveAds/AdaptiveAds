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
  
</body>
</html>
