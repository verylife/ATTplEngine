<?php
include_once 'AirtakeXMLEngine/BaseViewClass.php';

class RTLabelClass extends BaseViewClass
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
		if ($this->align) $this->setTextAlignTpl();
		if ($this->text)  $this->setText();
		$this->endTpl();

		return $this->tpl;
	}

	public function setTextAlignTpl()
	{
		switch ($this->align)
		{
			case 'left':
				$rtLabelAlign = 'RTTextAlignmentLeft';
				break;
	
			case 'right':
				$rtLabelAlign = 'RTTextAlignmentRight';
				break;
					
			case 'center':
				$rtLabelAlign = 'RTTextAlignmentCenter';
				break;
	
			case 'justified':
				$rtLabelAlign = 'RTTextAlignmentJustify';
				break;
					
			default:
				$rtLabelAlign = 'RTTextAlignmentLeft';
				break;
		}
		$this->tpl .= "		_{$this->id}.textAlignment = {$rtLabelAlign};\n";
	}
	
	public function setText()
	{
		$this->tpl .= "		_{$this->id}.text = NSLocalizedString(@\"{$this->text}\",@\"\");\n";
	}
}