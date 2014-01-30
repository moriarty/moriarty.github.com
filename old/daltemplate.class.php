<?php
/*--------------------------------------------------------------------------------------------*\
|| daltemplate.class.php                                          Last Modified: 2010-10-25   ||
||                                                                         by: Jon Hartling   ||
||                                                                                            ||
||  Template class that wraps a PHP application in Dalhousie's CQ template.                   ||
||  Please send any bugs, suggestions, or questions to jh@dal.ca                              ||
||                                                                                            ||
|| FUNCTION OVERVIEW:                                                                         ||
||  __construct($file)                                                                        ||
||      $file: location of the template file, default: http://dal.ca/templates/main.html      ||
||  commit()                                                                                  ||
||     Prevents further changes from being made.  Splits the template apart in to pieces.     ||
||  displayHeader()                                                                           ||
||     Displays the template header                                                           ||
||  displayFooter()                                                                           ||
||     Displays the template footer.  This function is called automatically at the end of     ||
||     the page using register_shutdown_function()                                            ||
||  noSideBar()                                                                               ||
||     Removes the sidebar from the page                                                      ||
||  replace($search,$rep)                                                                     ||
||     Replaces $search with $rep in the template                                             ||
||      $search: search term                                                                  ||
||      $rep: replace term                                                                    ||
||  parentPage($page,$title,$titleurl)                                                        ||
||     Makes the template mimic an existing dal.ca page in CQ                                 ||
||      $page: URL of the page to mimic in CQ, eg:http://dal.ca/admissions/undergraduate.html ||
||      $title: main page title (H1)                                                          ||
||      $titleurl: URL for the main page title link, defaults to PHP_SELF                     ||
||     Note: This function calls createBreadcrumbs(), createNavigation(), createBanner()      ||
||           and createSubHeader()                                                            ||
||  createBanner($page)                                                                       ||
||     Makes the template mimic an existing dal.ca page's banner                              ||
||      $page: URL of the page to mimic in CQ                                                 ||
||  createBreadcrumbs($page)                                                                  ||
||     Makes the template mimic an existing dal.ca page's breadcrumbs                         ||
||      $page: URL of the page to mimic in CQ                                                 ||
||  createNavigation($nav,$highlight=null)                                                    || 
||     Creates the navigation on the page, you can either make the template mimic an existing ||
||     dal.ca page's navigation or create a custom navigation                                 ||
||      $nav: this variable can be three different things: a link to a dal.ca CQ page to      ||
||            mimic, an array of navigation items, or a structured HTML list                  ||
||      $highlight: if $nav is an array, $highlight will be the item that's selected          ||
||  createSubHeader($title,$subnav,$titleurl,$highlight)                                      ||
||     Creates the subsite header                                                             ||
||      $title: main page title(H1)                                                           ||
||      $subnav: this variable can be two different things: a link to a dal.ca CQ page to     ||
||               mimic, or an array of subsite navigation items                               ||
||      $titleurl: URL for the main page title link, defaults to #                            ||
||      $highlight: if $subnav is an array, $highlight will be the item that's selected       ||
||  createCSS($css)                                                                           ||
||     Adds CSS files in the header under the standard template CSS                           ||
||      $css: an array of CSS files, eg: array("css/mycss.css","css/more.css")                ||
||  setTitle($title)                                                                          ||
||     Sets the page <title>                                                                  ||
||      $title: the page title                                                                ||
||  set($a,$v)                                                                                ||
||     Sets an internal attribute in $this->attributes                                        ||
||      $a: attribute                                                                         ||
||      $v: value                                                                             ||
||  get($a)                                                                                   ||
||     Gets an internal attribute from $this->attributes                                      ||
||      $a: attribute                                                                         ||
||  setMetaDescription($desc)                                                                 ||
||     Sets the META description to $desc                                                     ||
||      $desc: page meta description                                                          ||
||  setMetaKeywords($keywords)                                                                ||
||     Sets the META keywords to $keywords                                                    ||
||      $keywords: page meta keywords                                                         ||
||  removeFeedback()                                                                          ||
||     Removes the Feedback Tab                                                               ||
||  removeAnalytics()                                                                         ||
||     Removes the Analytics, good during testing                                             ||
||                                                                                            ||
|| CHANGELOG:                                                                                 ||
||                                                                                            ||
\*--------------------------------------------------------------------------------------------*/

class daltemplate {
	private $template;              # template container.
	private $file;                  # what template file we're using.
	private $attributes = array();  # the attributes for the template.
	private $displayed  = array();  # array to keep track of what's been displayed;
	private $header;                # everything above the content
	private $footer;                # everything below the content

	// Constructor
	function __construct($file = 'http://intern.its.dal.ca/test/MyTemplate/MyDal.html'){
		// Default Attributes
		$this->attributes['Navigation']  = '';
		$this->attributes['Breadcrumbs'] = '';
		$this->attributes['CSS'] 		 = '';
		$this->file = $file;
		$this->footer = '';
		
		// Open our template.
		if (!$this->template = @file_get_contents($this->file)) {
			die("Please try again later."); // Couldn't open file.
		}
		$this->template = str_replace("null","",$this->template);
		
		// Default template fixes.
		$this->defaultFixes();
				
		// Auto-include the footer at the end of the script!
		register_shutdown_function(array(&$this, "displayFooter"));
	}

	// Function to remove search bar	
	//function removeSearch() {
	//	$pattern = '<!--DalSearch.*boxy-->';
	//	$replacement = '';
	//	$this->template = preg_replace ($pattern, $replacement, $this->template);
	//}
	//
	//function noSearch() {
	//		$this->template = preg_replace("/<div class=\"hdr-search\">.*?<\/div>/s","",$this->template);
	//}

// Function to remove Search
	function removeSearch() {
	$pattern = '/(<\!--DalSearch.*boxy-->)/s';
		$replacement = '';
		$this->displayed = preg_replace ($pattern, $replacement, $this->displayed);
	}

	//
	//function addSearch(){
	//	$
	//	$this->template = str_replace("<!-- Title -->",$title,$this->template);
	//}

/*
* Functions below are original.
*
*
*/
	
	// Finished creating template elements, split it apart!
	function commit() {	
		// Default template fixes.
		$this->defaultFixes();
		$this->removeSearch();
		// Split the template apart on <!-- Content -->
		preg_match("/(.*)<!-- Content -->(.*)/s", $this->template, $parts);
		$this->header = $parts[1];
		$this->footer = $parts[2];
	}
	
	// Functions to display header/footer.
	function displayHeader() { 
		if (!in_array("header",$this->displayed)) {
			echo $this->header;
			$this->displayed[] = "header";	
		}
	}
	function displayFooter() { 
		if (!in_array("footer",$this->displayed)) {
			echo $this->footer; 
			$this->displayed[] = "footer";	
			
			// Close any open mysql connections.
			@mysql_close();
		}
	}
	
	// Function to disable the sidebar.
	function noSideBar() {
			$this->template = preg_replace("/<div class=\"sidebar\">.*?<\/div>/s","",$this->template);
	}
	
	// Generic replace function
	function replace($search,$rep) {
		//echo "<!-- $search = $rep -->\n";
		$this->template = str_replace($search,$rep,$this->template);	
	}
	
	// Function for mimicing an existing dal.ca page.
	// This function will copy breadcrumbs, navigation, and banner.
	function parentPage($page,$title='',$titleurl='') {
		$this->createBreadcrumbs($page);
		$this->createNavigation($page);
		$this->createBanner($page);
		if ($title!='') {
			if ($titleurl=='') $titleurl = $_SERVER['PHP_SELF'];
			$this->createSubHeader($title,$page,$titleurl);
		}
		
		// Fix the URLs in the template.
		$this->replace("\"/content/dalhousie","\"http://dal.ca/content/dalhousie");
		$this->replace("(/content/dalhousie","(http://dal.ca/content/dalhousie"); // For CSS.
	}
	
	// Function for copying the banner of a given page
	function createBanner($page) {
		if (strpos($page,".html")!==false) {
			if (strpos($page,'.banner')===false) $page = str_replace(".html",".banner.html",$page);
			$this->template = str_replace('<div class="banner"></div>',@file_get_contents($page),$this->template);
		}
	}
	// Function for copying the breadcrumbs of a given page
	function createBreadcrumbs($page) {
		if (strpos($page,".html")!==false) {
			// See if this is a page we can pull the menu off of.	
			if (strpos($page,'.cumbs')===false) $page = str_replace(".html",".crumbs.html",$page);
			$this->set('Breadcrumbs',@file_get_contents($page));	
		}
		$this->template = str_replace("<!-- Breadcrumbs -->",$this->get('Breadcrumbs'),$this->template);
	}
	
	// Function for generating custom navigation.
	function createNavigation($nav,$highlight=null) {
		if (is_array($nav)) {
			// Let's create our nav list.
			$tmp = "<div class=\"sidenav\">\n<ul class=\"block-nav\">\n";
			foreach($nav as $k=>$v) {
				$tmp.= "\t<li";
				if ($highlight==$k) $tmp.= " class=\"open\"";
				$tmp.= "><a href=\"$v\">$k</a></li>\n";
			}
			$tmp.= "</ul>\n</div>\n";
			$this->set('Navigation',$tmp);
		} else if (strpos($nav,".html")!==false) {
			// See if this is a page we can pull the menu off of.	
			if (strpos($nav,'.menu')===false) $nav = str_replace(".html",".menu.html",$nav);
			$this->set('Navigation',@file_get_contents($nav));	
		} else {
			// If the nav isn't an array or  URL, it hopefully is the structured UL.
			$this->set('Navigation','<div class="sidenav">'.$nav.'</div>');	
		}
		$this->template = str_replace("<!-- Side Nav -->",$this->get('Navigation'),$this->template);
	}
	
	// Function for creating the subsite header, with search bar.
	function createSubHeader($title,$subnav=null,$titleurl="#",$highlight=null) {
		$header = '<div class="subsite-header"><div class="subsiteHeader">';
		$header.= '<div class="clearfix"><h2><a href="'.$titleurl.'" title="">'.$title.'</a></h2>';
		$header.= '<div class="siteSearch"><form action="http://dal.ca/search.html" method="get" id="search"><div class="hdr-search"><input name="q" id="q" type="text" value="Search" class="input-search-box" /><input type="submit" value="Search Button" class="search-btn" /></form></div></div>';
		$header.= '</div></div>';
		if (is_array($subnav)) {
			$header.= '<div class="subsite-mainnav"> <ul class="clearfix">';
			$x=0;
			foreach ($subnav as $name=>$url) {
				$header.= '<li';
				if ($x==0 || $highlight==$name) {
					$header.= ' class="';
					if ($x==0) $header.= 'first-child ';
					if ($highlight==$name) $header.= 'active';
					$header.= '"';
				}
				$header.= '><a href="'.$url.'">'.$name.'</a></li>';
				$x++;
			}
			$header.= '</ul></div>';
		} else {
			// See if this is a page we can pull the menu off of.	
			if (strpos($subnav,'.subsiteMainNav')===false) $subnav = str_replace(".html",".subsiteMainNav.html",$subnav);
			$header.= '<div class="subsite-mainnav">'.@file_get_contents($subnav).'</div>';
		}
		$header.= '</div>';	
	
		$this->template = str_replace("<!-- Subsite Header -->",$header,$this->template);
	}
	
	// Function for adding CSS to the header, argument $css should be an array of CSS files.
	function createCSS($css) {
		if (is_array($css)) {
			// Let's set up our new css.
			$tmp = '';
			foreach ($css as $cssfile) {
				$tmp.= 	"<link rel=\"stylesheet\" type=\"text/css\" media=\"screen, print\" href=\"$cssfile\" />\n";
			}
			$this->set('CSS',$tmp);	
		}
		$this->template = str_replace("<!-- CSS -->",$this->get('CSS'),$this->template);
	}
	
	// Function to set the page title.
	function setTitle($title) {
		$this->template = str_replace("<!-- Title -->",$title,$this->template);
	}
	
	// Function to set the page meta description.
	function setMetaDescription($desc) {
		$this->template = str_replace('<meta name="description" content="main">',"<meta name=\"description\" content=\"$desc\">",$this->template);
	}
	
	// Function to set the page meta keywords.
	function setMetaKeywords($keywords) {
		$this->template = str_replace('<meta name="keywords" content="" >',"<meta name=\"keywords\" content=\"$keywords\">",$this->template);
	}

	// Functions to get/set attributes.
	function set($a,$v) { $this->attributes[$a] = $v; }
	function get($a) 	{ return $this->attributes[$a];	}
	
	// Function with default template fixes.
	function defaultFixes() {
		// Some fixes we know we'll need.
		$this->replace("/etc/designs/dalhousie/images/favicon.ico","http://www.dal.ca/favicon.ico");
		$this->replace("\"/etc/","\"http://dal.ca/etc/");
		$this->replace("\"/content/dalhousie/en/home","\"http://dal.ca");
		$this->replace("(/content/dalhousie/en/home","(http://dal.ca/content/dalhousie/en/home"); // For CSS.
		$this->replace("(/content/dam/dalhousie/","(http://dal.ca/content/dam/dalhousie/"); // For CSS.
	}
	
	// Function to remove analytics
//	function removeAnalytics() {
//		$pattern = '/(<\!-- Start Kampyle.*End Kampyle Feedback Form Button -->)/s';
//		$replacement = '';
//		$this->template = preg_replace ($pattern, $replacement, $this->template);
//	}

	// Function to remove Feedback (Kampyle)
	function removeFeedback() {
		$pattern = '/(<div id=\"kampyle_button.*div>)/s';
		$replacement = '';
		$this->template = preg_replace ($pattern, $replacement, $this->template);
	}

	// Function to force content to HTTPS
	function forceHTTPS() {
		$this->replace("http://dal.ca/etc/designs/dalhousie/","https://dal.ca/etc/designs/dalhousie/");
		$this->removeFeedback();
	}
}

?>
