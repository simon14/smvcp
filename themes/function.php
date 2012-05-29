<?php

function base_url($url) {

	return CSmvc::Instance()->request->base_url . trim($url, '/');
}

function current_url() {

  return CSmvc::Instance()->request->current_url;
}

function create_url($url, $sub=null, $values=null) {
	
	$urlCreator="{$url}/{$sub}/{$values}";
	
	return base_url($urlCreator);
}

?>