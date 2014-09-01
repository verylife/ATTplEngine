<?php
include_once 'AirtakeXMLEngine/BaseViewClass.php';

class ButtonClass extends BaseViewClass
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
		if ($this->fontSize || $this->fontFamily) $this->setTitleFont();
		if ($this->color) $this->setTitleColor();
		if ($this->image) $this->setImage();
		if ($this->backgroundImage) $this->setBackgroundImage();
		$this->endTpl();

		return $this->tpl;
	}
	
	public function setTitle()
	{
		
	}
	
	public function setTitleColor()
	{
		$this->tpl .= "		_{$this->id}.titleLabel.textColor = HEXCOLOR(0x{$this->color});\n";
	}

	public function setTitleFont()
	{
		if (!$this->fontFamily) $this->fontFamily = 'HelveticaNeue-light';
		if (!$this->fontSize) $this->fontSize = 14;
		$this->tpl .= "		_{$this->id}.titleLabel.font = [UIFont fontWithName:@\"{$this->fontFamily}\" size:{$this->fontFamily}];\n";
	}
	
	public function setImage()
	{
		$this->tpl .= "		[_{$this->id} setImage:[UIImage imageNamed:@\"{$this->image}\"] forState:UIControlStateNormal]";
	}
	
	public function setBackgroundImage()
	{
		$this->tpl .= "		[_{$this->id} setBackgroundImage:[UIImage imageNamed:@\"{$this->backgroundImage}\"] forState:UIControlStateNormal];\n";
	}
}