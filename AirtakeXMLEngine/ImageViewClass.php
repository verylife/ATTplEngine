<?php
include_once 'AirtakeXMLEngine/BaseViewClass.php';

class ImageViewClass extends BaseViewClass
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
		if ($this->image) $this->setImageTpl();
		$this->endTpl();
		
		return $this->tpl;
	}

	public function setImageTpl()
	{
		$this->tpl .= "		_{$this->id}.image = [UIImage imageNamed:@\"{$this->image}\"];\n";
	}
}