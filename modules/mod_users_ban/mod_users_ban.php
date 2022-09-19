<?php
/**
 * @package    [PACKAGE_NAME]
 *
 * @author     [AUTHOR] <[AUTHOR_EMAIL]>
 * @copyright  [COPYRIGHT]
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       [AUTHOR_URL]
 */

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

// Получаем значения параметров модуля
$color	= '';

// Добавляем стили на страницу:


try {
    // подключаемся к серверу
    $dbh = new PDO("mysql:host=localhost; dbname=joomla_db", "root", "");
		$sth = $dbh->prepare('SELECT 
		`liluj_users`.`name`,
		`bl3mt_usergroups`.`title`,
		`liluj_users`.`lastvisitDate`,
		`liluj_users`.`block`
		FROM `liluj_users`
			, `bl3mt_usergroups`');
		$sth->execute();
		
		$table="<table><thead><tr><th>Имя</th><th>Дата последнего входа в систему</th><th>Название группы</th><th>Бан</th></t></tr></thead>";
		$table=$table."<tbody>";	
		$array=[];
		$color = formaColor();
		$group = formaGroup();
		while($res=$sth->fetch()){
			array_push($array,$res['title']);
			$result[] = array_unique($array,SORT_STRING);

			isBlock($res['block']);
			isGroup($res['title']);
			
			if($res['title']==$group)
			{
				
				$table .=
			"<tr><td class=\"trStyle\">".$res['name'].
			"</td><td class=\"trStyle\">".$res['lastvisitDate'].
			"</td><td class=\"trStyle\">".$res['title'].
			"</td><td class=\"blockStyle\">".$res['block'].
			"</td></tr>";
			}
			else{
				$table .=
			"<tr><td>".$res['name'].
			"</td><td>".$res['lastvisitDate'].
			"</td><td>".$res['title'].
			"</td><td class=\"blockStyle\">".$res['block'].
			"</td></tr>";
			}
			
			
		}
			
		$table.="</tbody></table>";
		
		echo $table;
		
			}	
		

catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
function isBlock($block)
{
	if($block==0)
	{
		$color='green';
	}
	else{
		$color='red';
	}
	$blockStyle ='<style> .blockStyle{background-color:'.$color.';}</style>';
	echo $blockStyle;
}
function isGroup($group)
{
	
}
function formaGroup(){
$userGroup = "не определен";

if(isset($_GET["userGroup"])){
  
    $userGroup = $_GET["userGroup"];
		return $userGroup;
}
 print_r($userGroup);

}
function formaColor(){
	$colorStr = "не определено";

	if(isset($_GET["colorStr"])){
  
    $colorStr = $_GET["colorStr"];
		$trStyle ='<style> .trStyle{background-color:'.$colorStr.';}</style>';
		echo $trStyle;
		
}

}
?><html>

</html>
<form name="colorString menthod="POST"">
	  <input name="colorStr" type="text" value="gold">
	 	<input name="userGroup" type="text" value="Guest">
	  <input name="submit" type="submit" value="Send" >	
	</form>
