<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_out_articles
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Приветствуем текущего пользователя
$user = JText::_(JFactory::getUser());
print "<p> Привет ".$user."! </p>";

// Получаем значения параметров модуля
$hint	= (int) $params->get('show_author', '30');
$color	= (string) $params->get('active_row');

// Генерируем стили для раздела style:
//<style>
//  tr:hover {color: цвет;}
//  table {border: 1px;}
//</style>
$rowStyle =	'<style> .r1:hover {background-color: '.$color.';}'.'.t1 {border: 1px;}</style>';

// Добавляем стили на страницу:
echo $rowStyle; 

//Получаем данные из БД:
// Берём ссылку на объект базы данных:
$db =& JFactory::getDBO();
// Подготовка имен: заключаем название таблицы в 
// кавычки нужного вида: для MySQL это апострофы “`”
$tableContent  = $db->quoteName('#__content');
$tableUsers = $db->quoteName('#__users');
echo "$tableContent:".$tableContent."; $tableUsers: ".$tableUsers."<br>";
// Строим SQL:
// Create a new query object.
$sql = $db->getQuery(true);
/*
$sql = "SELECT a.`title` , a.`alias` , b.`name` 
        FROM  $tableContent AS a, $tableUsers AS b
        WHERE a.`created_by` = b.`id`"; 
echo $sql;
*/

/*
SELECT a.`title` , a.`alias` , b.`username` , b.`name` 
FROM  `test2_content` AS a
INNER JOIN  `test2_users` AS b ON a.`created_by` = b.`id` 

или без кавычек
SELECT a.title,a.alias,b.username,b.name 
FROM `#__content` AS `a` 
INNER JOIN `#__users` AS `b` ON (`a`.`created_by` = `b`.`id`)
*/
$sql->select(array('a.title', 'a.alias', 'b.username', 'b.name'))
    ->from($db->quoteName('#__content', 'a'))
    ->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')');

echo "<br> sql=".$sql;

// Предварительно устанавливаем текст запроса 
$db->setQuery($sql);
// Выполняем запрос и анализируем результат 
if ($db->query()) {
	// Запрос выполнился успешно. Получаем кол-во 
    // задействованных в запросе строк.
    $RowCount = $db->getAffectedRows();
    // Выводим сообщение
    echo JText::sprintf  ('<p>На сайте %u статей.</p>',  $RowCount);
	
	// Если нужно, выводим подсказку к статье:
	if ($hint) {
	  echo "<style>
	        td > .hint {
              position: absolute;
              display: none;
            }
            td:hover > .hint {
              display: block;
              background-color: lightgreen;
              border: 3px outset;
			  border-radius: 7px;
            }
			</style>";
	}
	
	//Выводим таблицу статей:
	$table="<thead><tr><th>№<th>Название<th>Ссылка</tr></thead>";
	$table=$table."<tbody>";
	// получаем данные в виде ассоциативного списка
	$data = $db->loadAssocList(); 
	$i = 1;
	$hintContent="";
	$article = array ();
	foreach ($data as $row) {
       if ($hint) {
	     $data="Автор: <br>Логин - ".$row['username']."<br>Имя   - ".$row['name'];
		 $hintContent="<div class=\"hint\">".$data."</div>";
	   }
	   $table=$table."<tr class='r1'><td>".$i."<td>".$row['title'].$hintContent."<td>".$row['alias'];
	   $i=$i+1;
    };
	$table=$table."</tbody>";
	
	echo "<table class='t1'>".$table."</table>";	
	
   } else {
    // Неудача (например, ошибка в синтаксисе SQL)
    ECHO "<p>Ошибка при работе с БД.</p>";
}
?>

