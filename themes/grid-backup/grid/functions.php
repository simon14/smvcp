<?php

/*============================
//	Footer
//===========================*/
$cs->data['footer']="Simon Hevosmaa, SMVC";


/*============================
//	Create a header with nav-bar
//===========================*/
function makeLogo() {
	
	$logo_url = create_url('site/img/logo-smvc.png');
	$back_url = create_url('');
	$header="<div class='main-header'><a href='{$back_url}'><img src='{$logo_url}' /></a></div>";
	
	return $header;
}

function makeMenu() {
	
	
	$cs = CSmvc::Instance();
	
	$selected="";
	$header="<div class='main-menu'><nav id='navbar'>";
	
	$menu = array(
	  'news'		  => array('text'=>'news', 'className' =>'CCNews', 'url' => $cs->request->CreateUrl('news')),
 	  'about'		  => array('text'=>'about', 'className' =>'CCPage', 'url' => $cs->request->CreateUrl('about')),
	  'user'		  => array('text'=>'user', 'className' => 'CCUser', 'url' => $cs->request->CreateUrl('user')),
	  'blog'		  => array('text'=>'blog', 'className' =>'CCBlog', 'url' => $cs->request->CreateUrl('blog')),
	  'content'		  => array('text'=>'content', 'className' =>'CCContent', 'url' => $cs->request->CreateUrl('content')),
	);


	foreach($menu as $key => $item){
	   if($cs->user->IsWriter() && $item['text']=='content') {
			$header.="<a href='{$item['url']}'";
			if($item['className']===$cs->data['selected'])
			$header.=" class='selected'";		
			$header.=">{$item['text']}</a>\n";
		} elseif($item['text']=='content') {
			
		} else {
			$header.="<a href='{$item['url']}'";
			if($item['className']===$cs->data['selected'])
			$header.=" class='selected'";		
			$header.=">{$item['text']}</a>\n";
		}
	   
	}

	$header.="</nav></div>\n";
	
	return $header;
}

function sub_menu() {

$html="";

$cs = CSmvc::Instance();
if($cs->data['selected']=='CCUser') {
	$url = create_url('user');
	$html = <<<EOD
<div class='wrapper'>
  <div class='sub-menu'>
  <nav id='navbar'>
  <a href='{$url}/login'>Login</a>
  <a href='{$url}/create'>Create</a>
  <a href='{$url}/profile'>Profile</a>
  <a href='{$url}'>Index</a>
  </nav>
  </div>
</div>
EOD;
}
	return $html;
}

/*============================
//	Create a user-login thing that shows incase user are logged in
//===========================*/
function login_menu() {
	$cs = CSmvc::Instance();
  	if($cs->user->IsAuthenticated()) {
    	
    	//$items = "<img src='" . $cs->user->GetGravatar() . "'>";
    	$items = "<a href='" . create_url('user/profile') . "'>" . $cs->user->GetAcronym() . "</a>";
	    
	    if($cs->user->IsAdministrator()) {
    	  $items .= " <a href='" . create_url('acp') . "'>acp</a>";
    	}
    	
	    $items .= " <a href='" . create_url('user/logout') . "'>logout</a>";
	    
	    
	} else {
    	$items = "<a href='" . create_url('user/login') . "'>login</a> ";
	}
	
  	return "<nav id='loginNav'>$items</nav>";
}

/*============================
//	Print debug into the footer
//===========================*/
function get_debug() {
  $cs = CSmvc::Instance();
  
  $html = "";
  
  if($cs->config['debug']===true){
  	  $html .= "<h2>Debuginformation</h2><hr><p>The content of the config array:</p><pre>" . htmlentities(print_r($cs->config, true)) . "</pre>";
	  $html .= "<hr><p>The content of the data array:</p><pre>" . htmlentities(print_r($cs->data, true)) . "</pre>";
	  $html .= "<hr><p>The content of the request array:</p><pre>" . htmlentities(print_r($cs->request, true)) . "</pre>";
	  $html .= $cs->data['debug'];
  }
  
  
  
  return $html;
}

/*============================
//	 Get messages stored in "flash" session
//===========================*/
function get_messages_from_session() {
  
  $messages = CSmvc::Instance()->session->GetMessages();
  $html = null;
  
  if(!empty($messages)) {
    
    foreach($messages as $val) {
    
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    
    }
  }
  
  return $html;
}

/*============================
//	Render all views
//===========================*/
function render_views($region='default') {
  
  return CSmvc::Instance()->views->Render($region);
}


/**
* Check if region has views. Accepts variable amount of arguments as regions.
*
* @param $region string the region to draw the content in.
*/
function region_has_content($region='default' /*...*/) {
  return CSmvc::Instance()->views->RegionHasView(func_get_args());
}


?>