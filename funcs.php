<?php	   		 
function clean ($string){
$string = addslashes($string);
$string = htmlspecialchars($string);
$string = strip_tags($string);
return $string;
} 
   function nixtime($unix,$time = '')
    {
            
			$today = mktime(0,0,0, date('m'), date('d'), date('Y'));
            $yesterday = mktime(0,0,0, date('m'), date('d')-1, date('Y'));
            if ($unix > $today)
            {
                $visit = date('g:i a', $unix );
				if ($time == "n")
                {
					return "Today";
				}
				else 
				{
					return "Today, $visit";
                }
			}
            elseif ($unix > $yesterday && $unix < $today)
                {
					$visit = date('g:i a', $unix );
					if ($time == "n")
					{
						return "Yesterday";
					}
					else 
					{
						return "Yesterday, $visit";
					}
				}
            else {
                $visit = date('n/j/y g:i a', $unix );
                return $visit;
        }
    }
function date_time($options,$time,$one)
	{
		$ti = $_SESSION['timezone'];
		if (!$ti)
			{
				$ti = "-6";
			}
		if ($_SESSION['dst'] == 1)
			{
				$ti++;
			}
		$timezone_offset = date("Z");
  		$timezone_add = round($ti*60*60);
  		$unix = round($time-$timezone_offset+$timezone_add);
		if ($one == "u")
		{
		     $date= nixtime($unix);
		}
		else if($one == "nt")
			{
				$date = nixtime($unix,"n");
				if ($date != "Today" || $date != "Yesterday")
					{
						$date = date($options,$unix);
					}
			}
		else if ($one == "n") {
		$date = date($options,$unix);		
		}	  
		return $date;
	}
function storereferer () {

    global $HTTP_REFERER, $baseurl;
	$baseurl = "codinghub.com";
  
    if (!isset ($HTTP_REFERER))
        return;

	 
    if ($HTTP_REFERER == "")
        return;
    
    if (strstr ($HTTP_REFERER, $baseurl))
        return;
    
    $linke = htmlspecialchars ($HTTP_REFERER, ENT_QUOTES);
	$link = explode("//",$linke);
	$link = explode("/",$link[1]);
	$link = $link[0];  
	$link = str_replace("www.","",$link);
    
    $now = date ('YmdHis');	

   mysql_query("INSERT INTO referers (url, full, d) VALUES ('$link', '$linke', '$now');");	
    }
function hrefererspage () {

    $today = getdate();	
    $hour = $today['hours'];	
    $minutes = $today['minutes'];	
    $seconds = $today['seconds'];

	 
    $yesterday  = mktime (date ("H"), date ("i"), date ("s"), date("m"), date ("d") - 1, date("Y"));

    $yesterday = date ("YmdHis", $yesterday);
    
    $result = mysql_query(
        "SELECT DISTINCT url, COUNT(*) as ct from referers GROUP BY url ORDER BY ct DESC, url LIMIT 5");

    /*Build the HTML table.*/
    
    echo ("<table cellpadding=\"0\" cellspacing=\"0\" width='99%' align='center' style='font-size: 10px;'>\n");
    
    while ($myrow = mysql_fetch_row ($result)) {
    
        $link = $myrow[0];
	 
		
        echo ("<tr><td align='left' width='95%'>$link</td>");
        echo ("<td align=\"right\" width='5%'>$myrow[1]</td></tr>");
        } /*while*/
        
    echo ("</table>\n");	
    } /*refererspage*/
	function refererspage () {

    $today = getdate();	
    $hour = $today['hours'];	
    $minutes = $today['minutes'];	
    $seconds = $today['seconds'];
    
    /*Get yesterday.*/
	 
    $yesterday  = mktime (date ("H"), date ("i"), date ("s"), date("m"), date ("d") - 1, date("Y"));

    $yesterday = date ("YmdHis", $yesterday);
    
    $result = mysql_query(
        "SELECT DISTINCT url, COUNT(*) as ct from referers GROUP BY url ORDER BY ct DESC, url;");
    
    while ($myrow = mysql_fetch_row ($result)) {
    
        $link = $myrow[0];
	
		 
		
        echo "<div style='float: left; text-align:left;'><a href='http://$link/'>$link</a></div> <div style='float: right; text-align:right;'>$myrow[1]</div><br />";

        } /*while*/

    } /*refererspage*/
function tuts($id)
{
	$list = mysql_query("SELECT * FROM `tutorials` WHERE `cid` = '$id'");
	$num = mysql_num_rows($list);
	return $num; 
	
} 
function birthday($date)
	{
		$date = explode("/",$date);	 
		$year = $date[2];
		$year = 2006 - $year;
		return $year; 
	}	


class mysqld {
	
	function connect($server,$user,$pass,$db)
		{										
			$thing = "<html>
<head>
  <title>TutorialHub - Error</title>	
  <style type='text/css'>
  BODY {
  background: #efefef;
  margin: 150px;
  text-align: center;
  }
  #error {
  background: #fefefe;
  font-family: verdana, tahoma, arial;
  font-size: 12px;
  margin: 0 auto;
  padding: 15px;
  width: 520px;
  color: #777; 
  border: 1px #999 solid;  
  text-align: left;
  }
  </style>
</head>
<body>
<div id='error'>
	<center><img src='/images/logo.png' border='0' /><br />
";

$end = "</pre><br /><br /></div>
</body>
</html>";	 
$mysql = "<span style='color: #ff0000; font-weight: bold;'>Warning</span><br/><br/>There was an error connecting to the MySQL server.</center><br />MySQL Said:<br /><pre>";


			@mysql_connect($server,$user,$pass) or die($thing.$mysql.mysql_error().$end);
			@mysql_select_db($db);
		}
	function query($sql)
		{
			$q = mysql_query($sql);
			return $q;
		}
	function assoc($sql)
		{
			$q = @mysql_query($sql);
			return mysql_fetch_assoc($q);
		}	
	function rows($sql)	
		{
			$q = @mysql_query($sql);
			return mysql_num_rows($q);
		}
			function error($error)
				{
						
						
						$mysql = "<span style='color: #ff0000; font-weight: bold;'>Warning</span>
						<br/><br/>An MySQL error was encountered processing this page:</center><br />
						MySQL Said:<br />
						<span style='font-size: 10px; font-family: Courier, Courier New, Console, System;'>";
						
						$end = "</span>";
						
						echo "$mysql$error$end";
				}
}	
class pagination {

	   var $pages = "";
   
	   function pagination($limit, $items, $min, $start, $url){
	      $per_page = $limit;
	      $total = ceil($items / $per_page);
	      $cur_page = (floor($start / $per_page) + 1);
	      $count = 0;
      $countb = 0;
	
	      if($total > 1){
	         if($start == 0){
	            $this -> pages .= '« Previous | ';
         } else {
            $this -> pages .= '« <a href="' . $url . ($cur_page - 1) . '">Previous</a> | ';
        }
        for($i = 1; $i <= $total; $i ++){
           if($i == $cur_page){
              $this -> pages .= "<strong>" . $i . "</strong> ";
	            } else if($total > $min){
               if($cur_page > 4 && $i > 3 && $i < ($cur_page - 1) && $i < ($total - 3)){
	                  $count ++;
	                  $this -> pages .= ($count == 1)? "... " : "";
               } else if($i > ($cur_page + 2) && $i < ($total - 2)){
                  $countb ++;
                  $this -> pages .= ($countb == 1)? "... " : "";
               } else {
	                  $this -> pages .= "<a href='" . $url . $i . "'>" . $i . "</a>";
	                  if($i < $total){
	                     $this -> pages .= " ";
                 }
               }
	            } else {
	               $this -> pages .= "<a href='" . $url . $i . "'>" . $i . "</a>";
	               if($i < $total){
	                  $this -> pages .= " ";
               }
            }
         }

         if($cur_page == $total){
            $this -> pages .= ' | Next »';
         } else {
            $this -> pages .= ' | <a href="' . $url . ($cur_page + 1) . '">Next</a> »';
         }
      }
  }
}   
function iif($expression, $returntrue, $returnfalse = '') {
return ($expression ? $returntrue : $returnfalse);
} 		  
function do_log($user) {
$ip = $_SERVER['REMOTE_ADDR'];
$page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}"; 
$page .= iif(!empty($_SERVER['QUERY_STRING']), "?{$_SERVER['QUERY_STRING']}", "");
$ref = $_SERVER['HTTP_REFERER'];
$date = time();
$agent = $_SERVER['HTTP_USER_AGENT'];
$host = @getHostByAddr($ip);
$query = "INSERT INTO `logs` ( `page` , `ip` , `host` , `agent` , `ref` , `date`, `user` ) VALUES ('$page', '$ip', '$host', '$agent', '$ref', '$date', '$user')";
mysql_query($query);
$datee = date("n/j/y");
$query = "INSERT INTO `todays` ( `ip` , `date` ) VALUES ('$ip', '$datee')";
mysql_query($query);
} 
function validateEmail($email)
	{
 		$pattern = '/^\w[\w\d]+(\.[\w\d]+)*@\w[\w\d]+(\.[\w\d]+)*\.[a-z]{2,7}$/i';
 		return preg_match($pattern,$email);
	}

 
  $start_time = !isset($start_time) ? explode(' ', microtime()) : $start_time;

  define('UBB_LOOKDOWN', 2);
  
  define('UBB_IMG_MAX_RESIZE_WIDTH', 100);
  define('UBB_IMG_MAX_RESIZE_HEIGHT', 100);
function ubbtexthandler($text, $this = null)
{
  if(is_object($this)) if(strpos(strtolower($text), '/me') > 0) $text = eregi_replace("([^[])/me([^\n\r$]*)([\n\r$])", "\\1<span class=\"me\">*".$this->username." \\2 *</span>\\3", $text);
  $text = nl2br($text);
    //echo '<div>'.htmlspecialchars($text).'</div>';
  $smiles = array();
  $smiles['!!'] = '<img src="/images/smilies/icon_exclaim.gif" style="border: 0;" alt="" />';
  $smiles[':C'] = '<img src="/images/smilies/icon_angry.gif" style="border: 0;" alt="" />';
  $smiles[':c'] = '<img src="/images/smilies/icon_angry.gif" style="border: 0;" alt="" />';
  $smiles[':)'] = '<img src="/images/smilies/icon_smile.gif" style="border: 0;" alt="" />';
  $smiles[':P'] = '<img src="/images/smilies/icon_tongue.gif" style="border: 0;" alt="" />';
  $smiles[':('] = '<img src="/images/smilies/icon_sad.gif" style="border: 0;" alt="" />';
  $smiles[':p'] = '<img src="/images/smilies/icon_tongue.gif" style="border: 0;" alt="" />';
  $smiles[':D'] = '<img src="/images/smilies/icon_biggrin.gif" style="border: 0;" alt="" />';
  $smiles[':d'] = '<img src="/images/smilies/icon_biggrin.gif" style="border: 0;" alt="" />';
  $smiles[':O'] = '<img src="/images/smilies/icon_surprised.gif" style="border: 0;" alt="" />';
  $smiles[':o'] = '<img src="/images/smilies/icon_surprised.gif" style="border: 0;" alt="" />';
  $smiles[':blink:'] = '<img src="/images/smilies/blink.gif" style="border: 0;" alt="" />';
  $smiles[':blush:'] = '<img src="/images/smilies/blush.gif" style="border: 0;" alt="" />';
  $smiles[':8'] = '<img src="/images/smilies/icon_cool.gif" style="border: 0;" alt="" />';
  $smiles[':huh?:'] = '<img src="/images/smilies/huh.gif" style="border: 0;" alt="" />';
  $smiles[':lol:'] = '<img src="/images/smilies/icon_lol.gif" style="border: 0;" alt="" />';
  $smiles[':LOL:'] = '<img src="/images/smilies/icon_lol.gif" style="border: 0;" alt="" />';
  $smiles[';)'] = '<img src="/images/smilies/icon_wink.gif" style="border: 0;" alt="" />';

  $smiles[':ninja:'] = '<img src="/images/smilies/ninja.gif" style="border: 0;" alt="">';

  foreach($smiles as $ubb => $html)
    $text = str_replace($ubb, '<b>'.$html.'</b>', $text);
  
  return $text;
}

function _quickerUBB_isTextTag($tag)
{
  return in_array($tag,
  array(
  'code',
  'php',
  ));
}

/********
* ubbParsing class.
*
* This class builds an tree of stackItems objects and from
* there derives an appropriate html structure based upon
* code generation methods. Each code generation method
* parse_[ubb], as where [ubb] is an ubb tag which is
* supported by the parser. After adding an additional
* method, the parser will recognize the code generation
* method and apply this method when encountering a matching
* ubb-tag while parsing.
*
* In order to use the parser, initialize an ubbParser object
* and call the following method
*
* $initializedUbbParser->parse($ubb)
*
* This class can be a superclass for more flexible classess,
* for instanse the UbbAdminParser which is used to parse
* site admin messages and which allowes html input, using the
* [html]html code[/html] tag.
*
* When using the /me tag (which will automatically be
* replace to a [me=username][/me] structure), you should use
* $parser->setUsername('username') first.
*/

class ubbParser
{
  var $usedTags;
  var $username;
  
  function setUsername($username)
  {
    $this->username = eregi_replace('([^a-z0-9_~]*)', '', $username);
  }
  
  function ubbParser()
  {
    $this->usedTags = array();
    $this->textTags = array();
    $this->username = '';
    $methods = get_class_methods(get_class($this));
    foreach($methods as $m)
    {
      if(substr($m, 0, 6) == 'parse_')
      {
        $tag = substr($m, 6);
        $this->usedTags[$tag] = $m;
      }
    }
  
  }

  function parse($text)
  {
     $text = str_replace('[*]','[li]', $text);
     $text = str_replace('[/*]','[/li]', $text);
     $basetree = new stackItem();
     $basetree->build(' '.trim($text));
     return $basetree->parse($this, $this->usedTags);
  }

  /* Auxilary method which calls upon the ubbtexthandler
     method, or does noting when not found */
  function parse_text($tree)
  {
    $this->text_handler = 'ubbtexthandler';
    if(isset($this->text_handler))
    {
      if(function_exists($this->text_handler))
      {
        $f = $this->text_handler;
        return $f($tree, $this);
      }
    }
    return $text;
  }
  
  /* base function to convert a [*]text[*] to <**>text</**> */
  function simple_parse($tree, $html_pre, $html_post, $parseInner = true, $htmlspecialchars = true, $nl2br = true)
  {
    $text = $parseInner ? $tree->innerToHtml($this, $this->usedTags) : $tree->toText();
    $text = strlen($text) > 0 ? $html_pre.$text.$html_post : '';
    /* Added a $nl2br check, thanx to Bert Goedhals */
    if ( !$nl2br )
    {
      $text = str_replace ("<br />", "", $text);
    }
    return $text;
  }
  
  /* code generation methods */
  function parse_hr($tree)   {return $this->simple_parse($tree, '<hr noshade/>', '');}
  function parse_br($tree)   {return $this->simple_parse($tree, '<br />', '');}
  function parse_i($tree)    {return $this->simple_parse($tree, '<i>', '</i>');}
  function parse_u($tree)    {return $this->simple_parse($tree, '<u>', '</u>');}
  function parse_s($tree)    {return $this->simple_parse($tree, '<s>', '</s>');}
  function parse_b($tree)    {return $this->simple_parse($tree, '<b>', '</b>');}
  function parse_sub($tree)  {return $this->simple_parse($tree, '<sub>', '</sub>');}
  function parse_sup($tree)  {return $this->simple_parse($tree, '<sup>', '</sup>');}
  function parse_small($tree){return $this->simple_parse($tree, '<small>', '</small>');}
  function parse_big($tree)  {return $this->simple_parse($tree, '<big>', '</big>');}

  
  function parse_php($tree)  {return '<div class="code">Code:
  <div class="linenum"></div>
  <div class="linetext">'.highlight_string(unhtmlspecialchars(''.$tree->toText().''), true).'</div>
  <div style="clear: both;"></div>
  </div>';}
  function parse_htmlforadminsonly($tree)  {return ''.unhtmlspecialchars(''.$tree->toText().'').'';}
  function parse_code($tree)  {return '<div class="code">Code:
  <div class="linenum"></div>
  <div class="linetext">'.nl2br(htmlspecialchars(unhtmlspecialchars(''.$tree->toText().''), true)).'</div>
  <div style="clear: both;"></div>
  </div>';}
  function parse_list($tree) {return $this->simple_parse($tree, '<ul>', '</ul>', true, true, false);}
  function parse_ul($tree)   {return $this->simple_parse($tree, '<ul>', '</ul>', true, true, false);}
  function parse_ol($tree)   {return $this->simple_parse($tree, '<ol>', '</ol>', true, true, false);}
  function parse_li($tree)   {return $this->simple_parse($tree, '<li>', '</li>', true, true, false);}
  function parse_edit($tree) {return $this->simple_parse($tree, '<span class="edit"><b>Edit: </b>','</span>');}
  function parse_bold($tree) {return $this->simple_parse($tree, '<b>', '</b>');}
 function parse_quote($tree, $params = array())
  {
     $font = isset($params['by']) ? $params['by'] : $tree->toText();
     return $this->simple_parse($tree, '<div class="boxtop">Quote</div><div class="box">', '</div>');
  }   
  /* more complex code generation methods */

   function parse_url($tree, $params = array())
  {
     /* [url]href[/url] as well as [url=href]text[/url] is supported */
     $href = isset($params['url']) ? $params['url'] : $tree->toText();
     $href = $this->valid_url($href) ? $href : '';
     return $this->simple_parse($tree, '<a target="blank" href="'.htmlspecialchars($href).'">', '</a>');
  }
  function parse_mail($tree, $params = array())
  {
     $href = isset($params['mail']) ? $params['mail'] : $tree->toText();
     return $this->simple_parse($tree, '<a href="mailto:'.htmlspecialchars($href).'">', '</a>');
  }
  function parse_font($tree, $params = array())
  {
     $font = isset($params['color']) ? $params['color'] : $tree->toText();
     return $this->simple_parse($tree, '<font color="'.$font.'">', '</font>');
  }    
 
  function valid_url($href)
  {
     $lowhref = strtolower($href);
     return ((substr($lowhref,0,7)=='http://') || (substr($lowhref,0,6)=='ftp://') || (substr($lowhref,0,7)=='mailto:'));
  }
}

/* ubbAdminParse class which enabled site admins to input
* plain html into their messages
*/
class ubbAdminParser extends ubbParser {
  function parse_html($tree)
  {
    return $tree->toText();
  }
}

/*
*
*/

/* StackItems is an recursive object used to create a
* tree, from which html or plain text can be derived.
* Although methods are commented, editing is not
* recommanded */
class stackItem {
    /* $parent maintaince a link to the parent object of
     * element, as where $childs is an mixed array of plain
     * text and other stackItem objects
     */ var $parent; var $childs;
    /* $tag_open : the ubb tag, without parameters
     * $tag_close: the ubb closing tag.
     * $tag_full : full ubb tag as found in the original
     *             unparsed text
     */ var $tag_open, $tag_close, $tag_full; var $was_closed = false;
    /* storeage array for parameter information*/ var $parameters;
    
    /* construtor initializes attributes */
    function stackItem()
    {
      $this->parent = null;
      $this->childs = array();
      $this->parameters = array();
      $this->tag_open = '';
      $this->tag_close = '';
      $this->tag_full = '';
    }
    
    /* set the parent of the object, this method is often
     * calles upon, just after creation of the object */
    function setParent(&$parent)
    { if(!is_object($parent)) return false; if(get_class($parent) != get_class($this)) return false;
      $this->parent = $parent;
    }
    
    /* Alter $this->tag_open and $this->tag_close from an
     * external scope */
    function setTag($open, $close = '')
    {
       $this->tag_open = strtolower($open);
       $this->tag_close = strtolower($close);
    }
    
    /* parse $text until $this->tag_close is encountered.
     * When a other closing tag than expected is found,
     * handle it appropriate:
     * - Look down the tree, werther there is an element for
     *   which the found closing tag is appropriate. If this
     *   element is less then UBB_LOOKDOWN steps away, close
     *   the current tag and return to calling object. When
     *   out of range, handle the closing tag as ordinary
     *   text
     */
    function take($text)
    { while(($s = strpos($text, '[')) >= 0 && strlen($text) > 0)
      { if($s===false)
        {
          $this->append($text);
          $text = '';
        } elseif($s == 0)
        {
          $close = strpos($text, ']'); if($close < 0)
          {
            $this->append($text);
            $text = '';
          } elseif(substr($text, 0, 2) == '[/')
          {
            $tag = strtolower(substr($text, 0, $close+1));
            $text = substr($text, $close+1); if($tag==$this->tag_close)
            {
              $this->was_closed = true;
              return $text;
            }
            else if($this->parent != null)
            {
              $subelem = $this->parent->isThisYours($tag, UBB_LOOKDOWN); if(!$subelem)
              {
                $this->append($tag);
              }
              else
              { if($subelem <= UBB_LOOKDOWN)
                {
                  return $tag.$text;
                }
                else
                {
                  $this->append($tag);
                }
              }
            }
            else
            {
              $this->append($tag);
            }
          }
          else
          {
            $child = new stackItem();
            $child->setParent($this);
            $text = $child->build($text);
            $this->append($child);
          }
        }
        else
        {
          $this->append(substr($text, 0, $s));
          $text = substr($text, $s);
        }
        $s = -1;
      } //end while
      
      return $text;
    }
    
    /**
    * parse $tag into $tag_open en $tag_full.
    * extract (parameter,value) pairs and store
    * these in $this->parameters;
    */
    function parseTag($tag)
    {
      $this->tag_full = '['.$tag.']'; while(strpos($tag, ' =') > 0) $tag = str_replace(' =', '=', $tag); while(strpos($tag, '= ') > 0) $tag = str_replace('= ', '=', $tag); while(strpos($tag, ', ') > 0) $tag = str_replace(', ', ',', $tag); while(strpos($tag, ' ,') > 0) $tag = str_replace(' ,', ',', $tag);
      $exploded = explode(' ', $tag);
      $tag_open = ''; foreach($exploded as $index => $element)
      {
        $pair = explode('=', $element, 2); if(count($pair) == 2)
        {
          $this->parameters[strtolower($pair[0])] = $pair[1];
        } if($index == 0) $tag_open = $pair[0];
      }
      $this->tag_open = strtolower($tag_open);
      $this->tag_close = strtolower('[/'.$tag_open.']');
    }
    
    /* build($text) generates a tree from $text from where
     * $this is the current root element.
     */
    
    function build($text)
    { if(empty($text)) return ''; if(substr($text, 0, 1) == '[')
      {
         /* Starts with an tag?

          * parsing should stop when /tag is found
          *
          * therefor $tag_open, $tag_close should be
          * initialized
          */
        $sclose = strpos($text, ']'); if($sclose<0)
        {
          $this->append($text);
          return '';
        }
        $tag = substr($text, 1, $sclose-1);

        $text = substr($text, $sclose + 1);
        $this->parseTag($tag); if(_quickerUBB_isTextTag(strtolower($tag)))
        {
          $s = strpos(strtolower($text),'[/'.strtolower($tag)); if($s == false)
          {
            $text = $this->take($text);
          }
          else
          {
            $subtext = substr($text, 0, $s);
            $this->childs[] = $subtext;
            $text = substr($text, $s);
            $text = substr($text, strpos($text,']')+1);
          }
        }
        else
        {
          $text = $this->take($text);
        }
        return $text;
      }
      else
      {
        /* Starts with text, therefor containerobject */
        $text = $this->take($text);
        $this->append($text);
      }
    }
    
    /* appends $data to the internal leaf structure.
     * $data can be object or plain text
     */
    function append($data)
    { if(empty($data)) return;
      $this->childs[] = $data;
    }
    
    /* This method is called upon from child object, to
     * find a object matching to a found closing tag
     * in order to maintain a stable structure.
     *
     * returns 'false' or a numeric value, telling the
     * calling child how many levels the corresponding
     * element is down in the tree, from the childs origin
     */
    function isThisYours($closingTag, $was_closed = 0)
    { if($closingTag == $this->tag_close)
      { if($was_closed >= 0) { $this->was_closed = true;}
        return 1;
      } if($this->parent == null)
      {
        return false;
      }
      else
      {
        $s = $this->parent->isThisYours($closingTag, $was_closed - 1); if(is_int($s)) return $s + 1;
        return $s;
      }
      
    }
    /* Return the parameters for this object */
    function getParameters()
    {
      return $this->parameters;
    }
    
    /* Return a string representation of this tag in plain
     * ubb */
    function toString()
    {
      return $this->tag_full.$this->toText().($this->was_closed ? $this->tag_close : '');
    }
    
    /* Return a string representation of this tags inner
     * in plain ubb */
    function toText()
    {
      $text = ''; foreach($this->childs as $c)
      { if(is_object($c))
        {
          $text.= $c->toString();
        }
        else
        {
          $text.= $c;
        }
      }
      return $text;
    }
    
    /* convert the contents of this element to html.
     * the $parser object is used to find appropriate
     * parse_tag methods.
     */
    function innerToHtml(&$parser, $methods = array())
    {
      $text = ''; foreach($this->childs as $c)
      { if(is_object($c))
        {
          $text.= $c->parse($parser, $methods);
        }
        else
        {
          $text.= $parser->parse_text($c);
        }
      }
      return $text;

    }
    
    /* Convert the total object to html */
    function toHtml(&$parser, $methods=array(), $inner_only = true)
    {
      $text = ''; if(strlen($this->tag_full) > 0 && !$inner_only)
      { if(isset($methods[$this->tag_open]))
        {
          $method = $methods[$this->tag_open];
          $text = $parser->$method($this);
        }
        else
        {
          return $this->innerToHtml($parser, $methods);
        }
      }
      else
      {
        /* No method found for this tag */ foreach($this->childs as $c)
        { if(is_object($c))
          {
            $text.= $c->parse($parser, $methods);
          }
          else
          {
            $text.= $parser->parse_text($c);
          }
        }
      }
      return $text;
    }
    
    /* Parse this object into html, this method is called
     * from the root element of the constructed tree */
    function parse(&$parser, $methods = array())
    {
      $text = ''; if(strlen($this->tag_full) > 0)
      { if(isset($methods[$this->tag_open]))
        {
          $method = $methods[$this->tag_open];
          $text = $parser->$method($this, $this->parameters);
        }
        else
        { foreach($this->childs as $c)
          { if(is_object($c))
            {
              $text.= $c->parse($parser, $methods);
            }
            else
            {
              $text.= $parser->parse_text($c);
            }
          }
          return $this->tag_full.$text.($this->was_closed ? $this->tag_close : '');
        }
      }
      else
      {
        /* No method found for this tag */ foreach($this->childs as $c)
        { if(is_object($c))
          {
            $text.= $c->parse($parser, $methods);
          }
          else
          {
            $text.= $parser->parse_text($c);
          }
        }
      }
      return $text;
    }
}	
		 	 
 function unhtmlspecialchars($text) {
   
       // Get Translation Table
       $trans = get_html_translation_table(HTML_SPECIALCHARS);
       $trans = array_flip($trans);
   
       // Return Translated $text
       return strtr($text, $trans);
   }   
 
?>




