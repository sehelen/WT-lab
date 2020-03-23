<?php
$begin="user_folder";
$folder = $_GET['folder'];

if (!isset($_GET['folder'])||(strpos($_GET['folder'],$begin)!==0)||(strpos($_GET['folder'],"..") !== false))
 {
  exit;
 }
else
{
  $folder = $_GET['folder'];
}	
//Удаление 
function delfiles($fld)
 {
	 $hdl=opendir($fld);
  while ($file = readdir($hdl)) 
   {
    if (($file!=".")&&($file!=".."))
     {
    if (is_dir($fld."/".$file)==True)
       {
        delfiles ($fld."/".$file);
        rmdir ($fld."/".$file);
       }
      else
       {
        unlink ($fld."/".$file);    
       }
     }
   }
  closedir($hdl); 
 }
 
if (isset($_POST['udal']))
 {
  $fl=$_POST['fl'];
    if (is_dir($folder."/".$fl)==True)
     {
      delfiles ($folder."/".$fl);
      rmdir ($folder."/".$fl);
     }
    else
     {
      unlink ($folder."/".$fl);
     }
   
 }
 
 //Переименование
if (isset($_POST['ren']))
 {	
	if ($_POST['rfl'] != "")
	{
		$afl=$_POST['afl'];
		$rfl = $_POST['rfl'];
		
		if (!file_exists($folder."/".$rfl))
		{
			$rfl=strtr($rfl, " []{},/\!@#$%^&*", "____________________");
			rename ($folder."/".$afl, $folder."/".$rfl);
		}
		else
		{
			echo("File $rfl already exists!");
			echo("<form action=fileProcess.php?folder=$folder method=post><br><input type=submit value=\"Назад\" name=back></form>");
			exit;		
		}
	}
	else
	{
		echo("Input file name plz");
		echo("<form action=fileProcess.php?folder=$folder method=post><br><input type=submit value=\"Назад\" name=back></form>");
		exit;
	}
 }
 
//Перемещение 
function copyfold ($rt, $fld, $tgt)
 {
  mkdir ($tgt."/".$fld, 0777);
  $hdl=opendir($rt."/".$fld);
  while ($file = readdir($hdl)) 
   {
    if (($file!="..")&&($file!="."))
     {
      if (is_dir($rt."/".$fld."/".$file)==True)
       {
        copyfold($rt."/".$fld, $file, $tgt."/".$fld);
       }
      else
       {
        copy ($rt."/".$fld."/".$file, $tgt."/".$fld."/".$file);
       }
     }
   }
 closedir($hdl); 
 }
 
if (isset($_POST['repl']))
 {
	 if(isset($_POST['rd'])&& isset($_POST['fl']))
	 {
		$fl=$_POST['fl'];
		$rd=$_POST['rd'];
		if (!file_exists($rd."/".$fl))
		{
			if (is_dir($folder."/".$fl))
			{
				if (!(strpos ($rd, $folder."/".$fl)===0))
				{
				copyfold($folder, $fl, $rd);
				delfiles ($folder."/".$fl);//удаление
				rmdir ($folder."/".$fl);//удаление
				}
			}
			else
			{
				copy ($folder."/".$fl, $rd."/".$fl);
				unlink ($folder."/".$fl);//удаление
			}
		}
		else
		{
			echo("$fl already exists!");
			echo("<form action=fileProcess.php?folder=$folder method=post><br><input type=submit value=\"Назад\" name=back></form>");
			exit;		
		}
		 
	 } 
    else
	{
		echo("Choose folder plz");
		echo("<form action=fileProcess.php?folder=$folder method=post><br><input type=submit value=\"Назад\" name=back></form>");
		exit;
	}	 
 }
 
//Создание новой папки
if (isset($_POST['md']))
 {
	 if ($_POST['newname'] != "")
	{
		$fl = $_POST['newname'];
		if (!file_exists($folder."/".$fl)&& !is_dir($folder."/".$fl))
		{
			$newname=$_POST['newname'];
			$newname=strtr($newname, " []{},/\!@#$%^&*", "____________________");
			mkdir ($newname, 0777);
		}
		else
		{
			echo("$fl already exists!");
			$temp = $_POST['md'];
			echo("<form action=filesReqPage.php?folder=$folder&md=$temp method=post><br><input type=submit value=\"Назад\" name=back></form>");
			exit;		
		}
	}
	else
	{
		echo("Input folder name plz");
		$temp = $_POST['md'];
		echo("<form action=filesReqPage.php?folder=$folder&md=$temp method=post><br><input type=submit value=\"Назад\" name=back></form>");
		exit;
	}
	 
	 
	 
	
 }

//Создание нового файла
if (isset($_POST['mf']))
 {
	if ($_POST['newname'] != "")
	{
		$file = $_POST['newname'];
		if (!file_exists($folder."/".$file))
		{
			$fp = fopen($folder."/".$file, "w"); 
			fclose($fp);
		}
		else
		{
			echo("File $file already exists!");
			$temp = $_POST['mf'];
			echo("<form action=filesReqPage.php?folder=$folder&mf=$temp method=post><br><input type=submit value=\"Назад\" name=back></form>");
			exit;		
		}
	}
	else
	{
		echo("Input file name plz");
		$temp = $_POST['mf'];
		echo("<form action=filesReqPage.php?folder=$folder&mf=$temp method=post><br><input type=submit value=\"Назад\" name=back></form>");
		exit;
	}
 }
 
 //Загрузить файл
 if (isset($_POST['load']))
 {
	$zak = $_FILES['zak'];
	if ($zak['name'] !="")
	{		
        $uploadfile = $folder ."/". basename($zak['name']);
		
		if (!file_exists($uploadfile))
		{
			move_uploaded_file($_FILES['zak']['tmp_name'], $uploadfile);
		}
		else
		{
			echo("Such file already exists!");
			$temp = $_POST['load'];
			echo("<form action=filesReqPage.php?folder=$folder&load=$temp method=post><br><input type=submit value=\"Назад\" name=back></form>");
			exit;		
		}
	}
	else
	{
		echo("Choose file plz");
		$temp = $_POST['load'];
		echo("<form action=filesReqPage.php?folder=$folder&load=$temp method=post><br><input type=submit value=\"Назад\" name=back></form>");
		exit;
	}	 	 
 }
 
 
//Редактирование 
 if (isset($_POST['red']))
 {
	file_put_contents($folder."/".$_POST['fname'], $_POST['preview']);
 }
 
 
 
Header ("Location: files.php?fold=$folder");
?>