    <?php
      require_once ('shablon/shablon.php');
	  
      $header = file_get_contents('shablon/header.html'); 
      $footer = file_get_contents('shablon/footer.html');
	  $uplinks = file_get_contents('shablon/uplinks.html'); 
      $downlinks = file_get_contents('shablon/downlinks.html');
	  
      $content = new content('shablon/home_page.html'); 
	  
      $content->set('{HEADER}', $header);
      $content->set('{FOOTER}', $footer);
	  $content->set('{UPLINKS}', $uplinks);
      $content->set('{DOWNLINKS}', $downlinks);
   
      $content->outContent();
    ?>