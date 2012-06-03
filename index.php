<?php
include("./daltemplate.class.php");

// Create our template.
$site = new daltemplate("http://intern.its.dal.ca/test/MyTemplate/MyDal.html");
$site->setTitle("This is my basic test page");

// Mimic an existing dal.ca CQ page.
//$site->parentPage("http://intern.its.dal.ca/test/MyTemplate/MyDal.html/MyDal.html","");

//Custom CSS
//$css = array("css/style.css","css/custom.css","css/uniform.default.css"); // These files don't actually exist, just an example.
//$site->createCSS($css);



//Force HTTPS and remove  Feedback
//$site->forceHTTPS();
$site->removeSearch();
// Commit our template changes, this will split the page apart.
$site->commit();

//$site->noSearch();

// Show our header.
$site->displayHeader();
//$site->noSearch();




?>

<div id="login_left">
      <h2>Login to MyDal</h2>
      <div id="login_form">
        <form name="userid" onSubmit="xferFocus(this); return false;">
          <div id="login_form_user">
            <label for="user" accesskey="u">Your NetID:</label>
            <input class="input-box" type="text" id="user" name="user" size="12" maxlength="30" tabindex="1" onFocus="hadFocus(true)"/> 
          </div>
        </form>
        <form name="cplogin" action="https://my.dal.ca/cp/home/login" onSubmit="login(); return false;" method="post"> 
          <input type="hidden" name="inst" value="dal2"/>
          <input type="hidden" name="user" value=""/>
          <div id="login_form_pass">
            <label for="pass" accesskey="p">Your Password:</label>
            <input class="input-box" type="password" id="pass" name="pass" size="12" maxlength="256" tabindex="2" onFocus="hadFocus(true);"/>
          </div>
        </form>
        <div id="login_form_submit">
          <a href="http://password.dal.ca" target="_blank">New User? Forgot your password?</a>
          <input class="input-btn" type="button" accesskey="l" name="login_btn" value="Login" onClick="login();" tabindex="3"/>
        </div>
        <div id="login_form_footer"></div>
      </div>

      <script type="text/javascript">
        deleteCookie();
        if (!hadFocus(false)) document.userid.user.focus();
      </script>
      <!-- FP#17600 add browser requirements text -->
      <div id="login_browser_info">
        <h4>Browser Requirements:</h4>
        <p>We support and recommend the latest versions of
        <a href="http://www.mozilla.com" target="_blank">Mozilla Firefox</a>
        and <a href="http://www.apple.com/safari/" target="_blank">Safari</a>.</p>
        <p><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank">Internet Explorer 7+</a>
        is also supported but may result in slower response times.</p>
      </div>
      <!-- FP#17600 end -->
    </div>

    <div id="login_right">
      <h2>MyDal - Your Information Source</h2>
      <ul>

        <!-- temporary login page notices -->
        <!-- <li><b>Bold Heading here</b> -->
        <!--   <br/> Details here  -->
        <!-- </li> -->
        <!-- end temporary login page notices -->
        <li><b>E-mail:</b> Send and receive e-mail, and create your own personal address book.</li>
        <li><b>Calendar:</b> Access and manage your personal and events calendars.</li>
        <li><b>Online Web Learning (OWL):</b> Connect to Dalhousie's online course management system.</li>
        <li><b>Information Technology (IT) help &amp; support</b> for your computer and Dalhousie tools and systems.</li>
        <li>News, entertainment, games, widgets and more.</li>
      </ul>
      <ul id="login_links">
        <li class="first-child"><a href="#" onclick="window.open('/webdocs/help/help_index.html', 'MyDalHelp', 'toolbar=yes,location=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=350,height=350')">MyDal Help</a></li>
        <li><a href="http://www.dal.ca/status">Systems Status</a></li>
      </ul>
    </div>
