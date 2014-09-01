<?php
include_once 'AirtakeXMLEngine/BaseViewClass.php';

class ViewClass extends BaseViewClass
{	

	public function init($xml,$css)
	{
		$this->xml = $xml;
		$this->css = $css;
		$this->initBaseConf();
		$this->initConf();
		
		return $this->tpl();
	}
	
	public function initConf()
	{
	}
	
	public function tpl()
	{
		$this->initWithFrameTpl($id, $class, $left, $top, $width, $height);
		if ($this->backgroundColor) $this->setBackgroundColor();
		$this->endTpl();
		return $this->tpl;
	}

	public function setBackgroundColor()
	{
		$this->tpl .= "		[_{$this->id} setBackgroundColor:HEXCOLOR(0x{$this->backgroundColor})];\n";
	}
}