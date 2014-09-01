<?php
include_once 'AirtakeXMLEngine/BaseViewClass.php';

class LabelClass extends BaseViewClass
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
		if ($this->align) 		$this->setTextAlign();
		if ($this->text)		$this->setText();
		if ($this->textColor)	$this->setTextColor();
		if ($this->fontFamily || $this->fontSize) 	$this->setFont();
		$this->endTpl();

		return $this->tpl;
	}

	public function setTextAlign()
	{
		switch ($this->align)
		{
			case 'left':
				$textAlign = 'ATkLabelAlignmentLeft';
				break;
	
			case 'right':
				$textAlign = 'ATkLabelAlignmentRight';
				break;
					
			case 'center':
				$textAlign = 'ATkLabelAlignmentCenter';
				break;
				
			default:
				$textAlign = 'ATkLabelAlignmentLeft';
				break;
		}
		$this->tpl .= "		_{$this->id}.textAlignment = {$textAlign};\n";
	}
	
	public function setText()
	{
		$this->tpl .= "		_{$this->id}.text = NSLocalizedString(@\"{$this->text}\",@\"\");\n";
	}
	
	public function setTextColor()
	{
		$this->tpl .= "		_{$this->id}.textColor = HEXCOLOR(0x{$this->color});";
	}
	
	public function setFont()
	{
		if (!$this->fontFamily) $this->fontFamily = 'HelveticaNeue-light';
		if (!$this->fontSize) $this->fontSize = 14;
		
		$this->tpl .= "		_{$this->id}.font = [UIFont fontWithName:@\"{$this->fontFamily}\" size:{$this->fontFamily}];\n";
	}
}