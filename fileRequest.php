<html>
<?php
$folder = $_GET['folder'];

echo ("<form enctype=multipart/form-data action=fileProcess.php?folder=$folder method=post>");

//Удаление
if (isset($_POST['udal']))
 {
	if (isset($_POST['fl']))
	{
		echo ("Удалить файл "); 
		$fl=$_POST['fl'];
		echo ("<input type=hidden name=fl value=$fl><b>$fl</b> из папки <b>$folder</b> ?<br>");
		echo ("<input type=submit value=\"Удалить\" name=udal>");
	}
	else
	{
		echo("<br><p>No file selected!</p>");
	}
}

//Перемещение
function tree($fld, $folder, $fl)
{
$hdl=opendir($fld);
while ($file = readdir($hdl))
{
 if (($file!=".")&&($file!=".."))
  {
   $fllnm=$fld."/".$file;
   if (is_dir($fllnm)==True)
    {
     $no=0;
     if ($fllnm==$folder."/".$fl)
       {
        $no=1;
       }      
     if ($no==0)
       {
        if ($fllnm!=$folder)
        {
          echo ("<input name=rd type=radio value=$fllnm>$fllnm<br>");
        }
        tree ($fllnm, $folder, $fl);
        }
    }
  }
}
closedir($hdl);
}

if (isset($_POST['repl'])||isset($_GET['repl']))
{
	if (isset($_POST['fl']))
	{
		$begin="user_folder";
		echo ("Куда копировать файл?<br>");
		$fl=$_POST['fl'];

		echo ("<input type=hidden name=fl value=$fl>$folder/$fl<br>");
		echo ("<br>Выберите папку для перемещения:<br>");
		tree($begin, $folder, $fl);
		if ($begin!=$folder)
		{
			echo ("<input name=rd type=radio value=$begin>$begin<br>");
		}
		echo ("<input type=submit value=\"Переместить\" name=repl>");
	}
	else
	{
		echo("<br><p>No file selected!</p>");
	}

}


//Переименование
if (isset($_POST['ren'])||isset($_GET['ren']))
 {
	if (isset($_POST['fl']))
	{
		$fl=$_POST['fl'];
		echo ("<input type=hidden name=afl value=$fl>");
		echo ("$fl");
		echo ("<input type=text size=30 name=rfl value=$fl><br>");
		echo ("<input type=submit value=\"Переименовать\" name=ren>");
	}
	else
	{
		echo("<br><p>No file selected!</p>");
	}
 }

//Создание новой папки 
if (isset($_POST['md'])||isset($_GET['md']))
 {
  echo ("Введите имя папки:<br><input type=text size=30 name=newname><br><input type=submit value=\"Создать папку\" name=md>");
 }

//Создание нового файла 
if (isset($_POST['mf'])||isset($_GET['mf']))
 {
  echo ("Введите имя файла:<br><input type=text size=30 name=newname><br><input type=submit value=\"Создать файл\" name=mf>");
 }
 
//Добавление файла 
 if (isset($_POST['load'])||isset($_GET['load']))
 {
	echo ("<br><input type=file size=30 name=zak><br><br><input type=submit value=\"Загрузить\" name=load>"); 
 }
 
 //Редактирование txt файла
 if (isset($_POST['red']))
 {	
    if (isset($_POST['fl']))
	{	
		$fl=$_POST['fl'];
		if (is_file($folder."/".$fl))
		{
			$info = new SplFileInfo($folder."/".$fl);
			if ($info->getExtension()=='txt')
			{		
				$content = file_get_contents($folder."/".$fl);
				echo ("<input type=hidden name=fname value=$fl>");
				echo ("<b>$fl</b>");
				echo("<br><textarea name=preview rows=12 cols=50>$content</textarea><br>");
				echo("<input type=submit value=\"Редактировать\" name=red>");
			}
			else echo("<br><p><b>$fl</b> isn't a txt file!</p>");
		}	
		else
		{
			echo("<br><p><b>$fl</b> is a directory!</p>");
		}
 	}
	else
	{
		echo("<br><p>No file selected!</p>");
	}
 }
?>
<br><input type=submit value="Отмена" name=ot>
</form>
</html>