<?php
/**
* A model for content stored in database.
* 
* @package SmvcCore
*/
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule {


  /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install': 
        try {
          $this->db->ExecuteQuery(self::SQL('drop table content'));
          $this->db->ExecuteQuery(self::SQL('create table content'));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Hello World!', '', 'blog', "This is a demo post.\n\nThis is another row in this demo post.", 1, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Hello Word Again!', '', 'blog', "This is another demo post.\n\nThis is another row in this demo post.",  1, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Hello World Once More!', '', 'blog', "This is one more demo post.\n\nThis is another row in this demo post.",  1, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Home', '', 'page' , "This is a demo page, this could be your personal home-page.\n\nLydia is a PHP-based MVC-inspired Content management Framework, watch the making of Lydia at: http://dbwebb.se/lydia/tutorial.",  2, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('About', '', 'page' , "Det h�r �r sidan. <br /> Sidan �r inte stor. <br /> Sidan �r gjortd av Simon. <br /> Som en del av kursen phpmvc. <br /> F�rinstallerade inneh�llet i nyheter �r taget fr�n <a href='http://www.feber.se'>feber.se</a> ",  2, '', '', 'html', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Download', '', 'page', "This is a demo page, this could be your personal download-page.\n\nYou can download your own copy of lydia from https://github.com/mosbth/lydia.",  2, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Page with BBCode', '', 'page', "This is a demo page with some BBCode-formatting.\n\n[b]Text in bold[/b] and [i]text in italic[/i] and [url=http://dbwebb.se]a link to dbwebb.se[/url]. You can also include images using bbcode, such as the lydia logo: [img]http://dbwebb.se/lydia/current/themes/core/logo_80x80.png[/img]",  3, '', '', 'bbcode', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Page with HTMLPurifier', '', 'page', "This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.\n\n<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.",  3, '', '', 'htmlpurify', date('c')));
        
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Nytt rollspel fr�n CD Project Red', 'Den polska bakom The Witcher, CD Projekt Red, avsl�jade tidigare i dag ett helt nytt rollspel. ', 'news', "Den polska bakom The Witcher, CD Projekt Red, avsl�jade tidigare i dag ett helt nytt rollspel. Spelet baseras p� Mike Pondsmiths rollspel (bordsrollspel) Cyberpunk som sl�ppte sin f�rsta revision n�gon g�ng p� slutet av 80-talet. 
		CD Projekt Red lovar en rik, olinj�r och komplex samt gripande, ett l�fte som de troligen kan h�lla d� man redan har bevisat det med The Witcher-spelen. Dock �r det inte samma team som jobbade p� The Witcher och The Witcher 2 men d�remot s� jobbar ett flertal \"veteraner\" fr�n The Witcher-teamet med detta spel. 
		P� tal om The Witcher och CD Project Red s� tillk�nnagav man ocks� i dag att man �ven kommer sl�ppa The Witcher 2 till Mac under h�sten.",  4, 'http://www.student.bth.se/~sihf11/images/red-big.jpeg', 'http://www.student.bth.se/~sihf11/images/red-mini.jpg', 'html', date('c')));
		
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Klassikern DOOM 3 kommer tillbaka', 'Har du saknat klassikern DOOM? Goda nyheter. Bethesda meddelar att de senare i �r kommer att sl�ppa DOOM 3 BFG Edition som inneh�ller DOOM, DOOM 2, DOOM 3.', 'news', "Har du saknat klassikern DOOM? Goda nyheter. Bethesda meddelar att de senare i �r kommer att sl�ppa DOOM 3 BFG Edition som inneh�ller DOOM, DOOM 2, DOOM 3 och DOOM 3: Ressurection of Evil tillsammans med Lost Mission som �r en singelplayerkampanj i Doom 3 inneh�llandes sju nya niv�er som aldrig sl�ppts. 

F�rutom det trevliga inneh�llet s� kommer specialutg�van att bel�nas med uppdaterad grafik, st�d f�r 3D och erbjuda 5.1 surroundljud samt Trof�er och Achievements. Spar- och checkpointsystemet kommer ocks� att g�ras om liksom ficklampan som numera sitter monterad p� spelarens rustning. John Carmack som �r Techincal Director ber�ttar om relanseringen. 

\"DOOM 3 was enthusiastically embraced by gamers worldwide at its release. Today, the full experience has been enhanced and extended to be better than ever, and is delivered across all the platforms with a silky smooth frame rate and highly responsive controls. New support for 3D TVs, monitors, and head mounted displays also allows players to experience the game with more depth than ever before. We think shooter fans everywhere will love it.\"

Spelet kommer att s�ppas till PC, Xbox 360 och PS3 senare i h�st. Utannonseringstrailern ser ni ovan.",  4, '<iframe width="780" height="438" src="http://www.youtube.com/embed/qNJ1GHYHQf8" frameborder="0" allowfullscreen></iframe>', 'http://www.student.bth.se/~sihf11/images/doom-mini.jpg', 'bbcode', date('c')));
        
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Nytt Ratchet and Clank-spel fr�n Insomni', 'I dag tillk�nnagav Insomniac att man h�ller p� att utveckla ett nytt spel i Ratchet & Clank-serien. Spelet kommer heta Ratchet & Clank: QForce och sl�pps till PlayStation 3 under h�sten. ', 'news', "I dag tillk�nnagav Insomniac att man h�ller p� att utveckla ett nytt spel i Ratchet & Clank-serien. Spelet kommer heta Ratchet & Clank: QForce och sl�pps till PlayStation 3 under h�sten. 

I ett inl�gg p� den officiella PlayStation-bloggen skrev Insomniac-chefen, Ted Price, att spelet kommer bli ett mindre �ventyr men kommer �ven �terg� till spelseriens r�tter. Trots detta s� kommer spelet �ven erbjuda ett helt nytt s�tt att spela Ratchet & Clank med sina v�nner, vad nu det inneb�r �terst�r helt enkelt att se. 

Spelet kommer sl�ppas b�de p� Blu-Ray samt via PSN och med tanke p� hur popul�rt Ratchet & Clank: Quest fot Booty var s� har nog detta ocks� potential att lyckas.",  4, 'http://www.student.bth.se/~sihf11/images/ratchet-big.jpeg', 'http://www.student.bth.se/~sihf11/images/ratchet-mini.jpg', 'bbcode', date('c')));
        
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Blizzard forts�tter uppdatera Diablo III', '
Efter att spelet nu varit ute i n�rmare tv� veckor b�rjar Blizzard mer i detalj ber�tta om de f�r�ndringar som �r p� g�ng.', 'news', "Efter att spelet nu varit ute i n�rmare tv� veckor b�rjar Blizzard mer i detalj ber�tta om de f�r�ndringar som �r p� g�ng. Det handlar en hel del om att de agerar p� spelares synpynkter - bland annat vad g�ller balansen mellan olika karakt�rer och f�rm�gor. 

Den f�rsta patchen att sl�ppas var 1.0.2 som nu �r live och den handlar fr�mst om l�sningen p� �terst�ende serverstrul. N�sta patch i ordningen �r 1.0.3 som ska fokusera mer p� att balansera de olika klasserna. Efter det kommer fokus att l�ggas p� bland andra Legendary-loot som b�de ska buffas och g�ras mer unika - dock g�ller det bara loot som hittas efter patchen. Med st�rsta sannolikhet kommer de f�r�ndringarna i 1.1-patchen som ocks� ber�knas vara PvP-patchen. 

I bloggposten d�r Blizzard g�r mer in i detalj p� f�r�ndringarna, och anledningen till dem, visades ocks� en del ny statistik upp. 

- On average players have created 3 characters each 
- 80% of characters are between levels 1 and 30 
- 1.9% of characters have unlocked Inferno difficulty 
- 54% of Hardcore players chose a female character 
- The majority of Hardcore deaths (35%) occur in Act I Normal 
- The most common level 60 build in the game is only used by 0.7% of level 60 characters of that class (not including Passive diversity) 
- The most used runes for each class at level 60 are Barbarian: Best Served Cold, Demon Hunter: Lingering Fog, Wizard: Mirror Skin, Monk: Peaceful Repose, Witch Doctor: Numbing Dart

Hur m�nga karakt�rer har du?",  4, 'http://www.student.bth.se/~sihf11/images/diablo-big.jpeg', 'http://www.student.bth.se/~sihf11/images/diablo-mini.jpg', 'bbcode', date('c')));
        
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Metro: Last Light', 'H�r har vi en vacker bild fr�n kommande Metro: Last Light. ', 'news', "H�r har vi en vacker bild fr�n kommande Metro: Last Light. ",  4, 'http://www.student.bth.se/~sihf11/images/metro-big.jpeg', 'http://www.student.bth.se/~sihf11/images/metro-mini.jpg', 'bbcode', date('c')));
          
          return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
        } catch(Exception$e) {
          die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        }
      break;
      
      case 'cow':
      	break; 
      
      default:
        throw new Exception('Unsupported action for this module.');
      break;
    }
  }
  
  /**
   * Properties
   */
  public $data;


  /**
   * Constructor
   */
  public function __construct($id=null) {
    parent::__construct();
    if(!empty($id)) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }


  /**
   * Implementing ArrayAccess for $this->data
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }
	
  /**
   * Delete content. Adds a date when it was deleted in the database, does not remove the content entirly.
   */
  public function Delete($id=null) {
  	
  	if($this->user->IsAuthenticated() && $id!=null){
  		
  		
  		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
  		$userIdCont = $res[0]['idUser'];
  		//$res2 = $this->user->GetUserProfile();
  		//$userId = $res2['id'];
  		$userId = $this->user->GetId();
  		
  		if($userId==$userIdCont || $this->user->IsAdministrator()) {
	  		if($id!=null) {
		  		$this->db->ExecuteQuery(self::SQL('delete content'), array(date('c'), $id));
  				$this->session->AddMessage('notice', 'Post deleted');
  			}
  		} else {
  			$this->session->AddMessage('error', 'You cannot delete another users post');
  		}
  	} else {
  		$this->session->AddMessage('error', 'You are not logged in');
  	}
  }
  
  /**
   * Restores content.
   */
  public function Restore() {
  	
  	if($this->user->IsAuthenticated() && $this->data['id']!=null){
  		
  		if($this->user->IsAdministrator()) {
  		
	  		$this->db->ExecuteQuery(self::SQL('restore content'), array($this->data['id']));
  			$this->session->AddMessage('notice', 'Post restored');
  		} else {
  			$this->session->AddMessage('error', 'You cannot restore a post unless your an administrator.');
  		}
  	}
  }
  
  public function Like() {
  	
  	if(empty($_SESSION['voted']["{$this->data['id']}"])) {
  		$this->db->ExecuteQuery(self::SQL('like'), array($this->data['id']));
	  	$_SESSION['voted']["{$this->data['id']}"]=true;
  	} else {
  		$this->session->AddMessage('error', 'Already liked this post');
  	}
  	
  }

  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null) {
    $queries = array(
      'drop table content'		=> "truncate table Content; drop table Content",
      'create table content'	=> "CREATE TABLE `Content` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `title` varchar(40) DEFAULT NULL,  `short` varchar(150) DEFAULT NULL,  rating int(11) DEFAULT '0', `type` varchar(40) DEFAULT NULL,  `content` text,  `idUser` int(11) DEFAULT NULL,  `image` text,  `img` text,  `filter` varchar(10) DEFAULT NULL,  `created` datetime DEFAULT NULL,  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,  `deleted` datetime DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
      'insert content'          => "INSERT INTO `Content` (`title`, `short`, `type`, `content`, `idUser`, `image`, `img`, `filter`, `created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);",
      'select * by id'          => 'SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=?;',
      'select * by key'         => 'SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=%s;',
      'select *'         		=> 'SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id;',
      'select-all-desc'         => "SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id ORDER BY c.id DESC;",
      'select-all-asc'          => "SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id ORDER BY c.id ASC;",
      'update content'          => "UPDATE Content SET title=?, short=?, type=?, content=?, image=?, img=?, filter=? WHERE id=?;",
      'delete content'			=> "UPDATE Content SET deleted = ? WHERE id = ?;",
      'restore content'			=> "UPDATE Content SET deleted = NULL WHERE id = ?;",
      'like'					=> "UPDATE Content SET rating = rating+1 WHERE id = ?;",
      'select next news'		=> "select * from Content where id<? and type='news' order by id desc;",
      'select back news' 		=> "select * from Content where id>? and type='news' order by id asc;",
     );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }  

  /**
   * Go next new. Automaticlly get next 'news', created for the browsing buttons in page-view.
   *
   * @returns array with next new, else null.
   */
  public function GoNextNews() {
  	
  	$res=$this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select next news'), array($this['id']));
  	
  	$res = isset($res[0]) ? $res[0] : null;
  	
  	return $res;
  	
  } 
   
   
  /**
   * Go back new. Automaticlly get next 'news', created for the browsing buttons in page-view.
   *
   * @returns array with earlier new, else null.
   */
  public function GoBackNews() {
  
  	$res=$this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select back news'), array($this['id']));
  	
  	$res = isset($res[0]) ? $res[0] : null;
  	
  	return $res;
  }

  /**
   * Save content. If it has a id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save($content=null) {
    $msg = null;
    if($this['id']) {
      //echo sprintf(self::SQL('update content'), $content['title'], $content['subtitle'], $content['type'], $content['content'], $content['image'], $content['video']);
      //echo $this['id'];
      $this->db->ExecuteQuery(self::SQL('update content'), array($content['title'], $content['short'], $content['type'], $content['content'], $content['image'], $content['img'], $content['filter'], $this['id']));
      $msg = 'update';
    } else {
      //echo sprintf(self::SQL('insert content'), $content['title'], $content['subtitle'], $content['type'], $content['content'], $this->user['id'], $content['image'], $content['video'], date('c'));
      $this->db->ExecuteQuery(self::SQL('insert content'), array($content['title'], $content['short'], $content['type'], $content['content'], $this->user['id'], $content['image'], $content['img'], $content['filter'], date('c')));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'created';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->session->AddMessage('success', "Successfully {$msg} content '{$this['key']}'.");
    } else {
      $this->session->AddMessage('error', "Failed to {$msg} content '{$this['key']}'.");
    }
    return $rowcount === 1;
  }
  
  public static function Filter($data, $filter)  {
  	switch($filter) {
      case 'html': $data = nl2br($data); break;
      case 'bbcode': $data = nl2br(bbcode2html(htmlentities($data))); break;
      case 'htmlpurify': $data = nl2br(CHTMLPurifier::Purify($data)); break;
      case 'plain': 
      default: $data = nl2br(makeClickable(htmlentities($data))); break;
    }
    return $data;
  } 
  
  public function GetFilteredData() {
  	return $this->Filter($this['content'], $this['filter']);
  } 
  
  public function FilterContent() {
	$this['content'] = $this->Filter($this['content'], $this['filter']);
  }
  
  
  /*============================
  //	Get filtered data for all posts in DB, used primary for blog
  //===========================*/
  public function GetAllFilteredData($order=null) {
 	
 	$res=null;
 	
 	
 	if($order='desc'){
	
	 	try{
		  	$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select-all-desc'));
	  	} catch(exception $e) {
  			$res = null;
	  	}
  	}
  	else if($order='asc'){
  	
  		try{
  	 		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select-all-asc'));
  		} catch(exception $e) {
  			$res = null;
  		}
  	}
  	else{
  	
  		try{
  	 		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *'));
  		} catch(exception $e) {
  			$res = null;
  		}
  	}
  	
  	for($i=0;$i<count($res);$i++){
  		$res[$i]['content']=$this->Filter($res[$i]['content'], $res[$i]['filter']);
  	}
  	
  	
  	return $res;
  }

  /**
   * Load content by id.
   *
   * @param id integer the id of the content.
   * @returns boolean true if success else false.
   */
  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->session->AddMessage('error', "Failed to load content with id '$id'.");
      return false;
    } else {
      $this->data = $res[0];
    }
    return true;
  }
  
  
  /**
   * List all content.
   *
   * @returns array with listing or null if empty.
   */
  public function ListAll() {
    
    try {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *'));
    } catch(Exception$e) {
      return null;
    }
  }
  
  
  
}