<?php

class BaseViewClass
{
	protected  $xml;
	protected $css;

	protected $id;
	protected $class;

	protected $image;

	protected $left;
	protected $top;
	protected $width;
	protected $height;
	
	protected $fontSize;
	protected $fontFamily;
	protected $color;
	protected $backgroundImage;

	protected $align;
	protected $text;
	
	protected $tpl;
	
	public function init($xml,$css)
	{
		$this->xml = $xml;
		$this->css = $css;
		$this->initBaseConf();
	}
	
	public function initBaseConf()
	{
		$this->image = $this->xml['image'];
		
		$this->id	 = $this->xml['id'];
		$this->class = $this->xml['class'];

		$this->left   = str_replace('px', '',$this->css['left']);
		$this->top 	  = str_replace('px', '',$this->css['top']);
		$this->width  = str_replace('px', '',$this->css['width']);
		$this->height = str_replace('px', '',$this->css['height']);
		
		$this->color 		= str_replace('#', '',$this->css['color']);
		$this->fontSize   	= str_replace('px', '',$this->css['font-size']);
		$this->fontFamily 	= $this->css['font-family'];
		
		$this->backgroundColor 	= str_replace('#','',$this->css['background-color']);
		$this->backgroundImage 	= str_replace(array('url(',')','image/','@2x'),'',$this->css['background-image']);
		
		$this->text = $this->xml['text'];
		$this->align = $this->css['text-align'];
	}
	
	public function initWithFrameTpl()
	{
		$this->tpl = 
"
-({$this->class} *){$this->id}
{
	if (!_{$this->id})
	{
		_{$this->id} = [[{$this->class} alloc] initWithFrame:CGRectMake({$this->left},{$this->top},{$this->width},{$this->height})];
";
	}
	
	public function endTpl()
	{
		$this->tpl .= 
"	}
	return _{$this->id};
}
";
	}
}