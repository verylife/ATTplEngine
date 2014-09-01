<?php
include 'AirtakeXMLEngine/AirtakeXMLTplEngine.php';
include 'AirtakeXMLEngine/WindFolder.php';

$tplEngine = new AirtakeXMLTplEngine;

if (!$_GET['action']) $_GET['action'] = 'list';

if ($_GET['action'] == 'list')
{
	 $dirs = WindFolder::read('XML',WindFolder::READ_DIR);

	 echo '<table>';
	 foreach ($dirs as $tplName)
	 {
	 	echo '<tr>';
	 	echo '<td>'.$tplName.'</td>';
	 	echo "<td><a target=\"_blank\" href=\"XML/{$tplName}/index.html\">预览</a></td>";
		echo "<td><a target=\"_blank\" href=\"tpl.php?action=hfile&tplName={$tplName}\">H文件</a></td>";
	  	echo "<td><a target=\"_blank\" href=\"tpl.php?action=mfile&tplName={$tplName}\">M文件</a></td>";
	 	echo '</tr>';
	 }
	 echo '</table>';
	 exit;
}
else if ($_GET['action'] == 'mfile')
{
	$tplName = $_GET['tplName'];
	$tplEngine->init($tplName);
	$tplEngine->outputMFile();
}
else if ($_GET['action'] == 'hfile')
{
	$tplName = $_GET['tplName'];
	$tplEngine->init($tplName);
	$tplEngine->outputHFile();
}