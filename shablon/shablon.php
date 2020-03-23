<?php
class Content 
{
	private $vars;
	private $template;
	
	public function __construct($file)
	{
		$this->vars = [];
		$this->template = file_get_contents($file);
	}
	public function set($name,$val)
	{
		$this->vars[$name] = $val;
	}
	
	public function outContent() 
	{
		foreach($this->vars as $key => $val) 
		{
			$this->template = str_replace($key, $val, $this->template); 	
		}
		//echo $this->template;
		file_put_contents('shablon/prepage.php', $this->template);
		include('shablon/prepage.php');
	}
}
?>