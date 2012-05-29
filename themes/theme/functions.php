<?php

/*============================
//	Footer
//===========================*/
$cs->data['footer']="Simon Hevosmaa, SMVC";


/*============================
//	Create a header with nav-bar
//===========================*/
function makeHeader() {
	
	$login = login_menu();
	
	$cs = CSmvc::Instance();
	$selected="";
	$header=<<<EOD

<div class='banner'>
<h1>smvc</h1>
</div>

EOD;

	$header.="<nav id='navbar'>";
	
	$menu = array(
	  'index'         => array('text'=>'index',  'className' => 'CCIndex', 'url'=>$cs->request->CreateUrl('index')),
	  'developer'	  => array('text'=>'developer', 'className' => 'CCDeveloper', 'url'=>$cs->request->CreateUrl('developer')),
	  'guestbook'	  => array('text'=>'guestbook', 'className' => 'CCGuestBook', 'url'=>$cs->request->CreateUrl('guestbook')),
	  'user'		  => array('text'=>'user', 'className' => 'CCUser', 'url' => $cs->request->CreateUrl('user')),
	  'content'		  => array('text'=>'content', 'className' =>'CCContent', 'url' => $cs->request->CreateUrl('content')),
	);

	foreach($menu as $key => $item){
		$header.="<a href='{$item['url']}'";
		if($item['className']===$cs->data['selected'])
			$header.=" class='selected'";		
		$header.=">{$item['text']}</a>\n";
	}

	$header.="</nav>";
	
	return $header;
}

function sub_menu() {

$html=null;

$cs = CSmvc::Instance();
if($cs->data['selected']=='CCUser') {
	$url = create_url('user');
	$html = <<<EOD
</div>
<div class='wrapper'>
  <div class='header'>
  <nav id='navbar'>
  <a href='{$url}/login'>Login</a>
  <a href='{$url}/create'>Create</a>
  <a href='{$url}/profile'>Profile</a>
  <a href='{$url}'>Index</a>
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
    	
    	$items = "<img src='" . $cs->user->GetGravatar() . "'><br />";
    	$items .= "<a href='" . create_url('user/profile') . "'>" . $cs->user->GetAcronym() . "</a><br />";
	    
	    if($cs->user->IsAdministrator()) {
    	  $items .= "<small><a href='" . create_url('acp') . "'>acp</a><br /></small>";
    	}
    	
	    $items .= "<small><a href='" . create_url('user/logout') . "'>logout</a></small>";
	    
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
function render_views() {
  
  return CSmvc::Instance()->views->Render();
}

/*============================
//	 Filter dataz
//===========================*/
function filter_data() {

}

?>