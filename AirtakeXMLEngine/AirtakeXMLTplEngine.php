<?php

include_once 'AirtakeXMLEngine/ViewClass.php';
include_once 'AirtakeXMLEngine/ImageViewClass.php';
include_once 'AirtakeXMLEngine/RTLabelClass.php';
include_once 'AirtakeXMLEngine/ButtonClass.php';

class AirtakeXMLTplEngine
{
	protected $xmlPath = 'XML';
	protected $viewPath = 'View';

	protected $fileName;
	protected $hFileName;
	protected $mFileName;

	protected $className;
	protected $xmlContent = array();
	protected $cssContent = array();

	protected $viewClass;
	protected $imageViewClass;
	protected $rtLabelClass;
	protected $buttonClass;

	public function init($tplName)
	{
		$this->fileName = $tplName;
		$this->hFileName = 'View/'.$this->fileName.'.h';
		$this->mFileName = 'View/'.$this->fileName.'.m';
		
		$this->parseXML($tplName);
		$this->parseCSS($tplName);

// 		print_r($this->className);
// 		print_r($this->xmlContent);
// 		print_r($this->cssContent);
// 		exit;
		
		$this->generateTpl();
	}
	
	public function outputHFile()
	{
// 		echo $this->hFileName;
		echo "<pre>";
		echo $this->read($this->hFileName);
		echo "</pre>";
	}
	
	public function outputMFile()
	{
// 		echo $this->mFileName;
		echo "<pre>";
		echo $this->read($this->mFileName);
		echo "</pre>";
	}
	
	public function parseXML($tplName)
	{
		$xmlFileName = $this->xmlPath.'/'.$tplName.'/index.html';
		$xml = $this->read($xmlFileName);
		
// 		$this->parseBody($xml);
		$this->parseDiv($xml);
		$this->parseImg($xml);
		$this->parseButton($xml);
	}
	
	public function parseBody($xml)
	{
		$exp = explode('<body', $xml);
		$exp = explode('>',$exp[1]);
		preg_match('/class="(?<class>\w+)"/', $exp[0], $matches);
		
		if ($matches['class']) {
			$this->className = $matches['class'];
		}
	}
	
	public function parseDiv($xml)
	{
		$divArray = explode('<div', $xml);
		
		foreach ($divArray as $div)
		{
			$exDiv = explode('>',$div);
			$value = $exDiv[0];
				
			$conf = $this->getXMLConf($value);
			if (!empty($conf))
			{
				if ($conf['id'] == 'main') {
					$this->className = $conf['class'];
				} else {
				if (!$conf['class']) $conf['class'] = 'UIView';
					$this->xmlContent[] = $conf;
				}
			}
		}
	}
	
	public function parseImg($xml)
	{
		$imgArray = explode('<img', $xml);
		foreach ($imgArray as $img)
		{
			$exImg = explode('/>',$img);
			$value = $exImg[0];

			$conf = $this->getXMLConf($value);
			if (!empty($conf))
			{
				if (!$conf['class']) $conf['class'] = 'UIImageView';
				$this->xmlContent[] = $conf;
			}
		}
	}
	
	public function parseButton($xml)
	{
		$buttonArray = explode('<button', $xml);
		foreach ($buttonArray as $button)
		{
			$exp = explode('>',$button);
			$value = $exp[0];
		
			$conf = $this->getXMLConf($value);
			if (!empty($conf))
			{
				if (!$conf['class']) $conf['class'] = 'UIButton';
				$this->xmlContent[] = $conf;
			}
		}
	}
	
	public function getXMLConf($string)
	{
		$conf = array();
		preg_match('/id="(?<id>\w+)"/', $string, $matches);
		if ($matches['id']) {
			$conf['id'] = $matches['id'];
		}
			
		preg_match('/class="(?<class>\w+)"/', $string, $matches);
		if ($matches['class']) {
			$conf['class'] = $matches['class'];
		}
		
		preg_match('/text="(?<text>[^"]+)"/', $string, $matches);
		if ($matches['text']) {
			$conf['text'] = $matches['text'];
		}
			
		preg_match('/src="(?<image>[^"]+)"/', $string, $matches);
		if ($matches['image']) {
			$conf['image'] = str_replace(array('image/','@2x'), '',$matches['image']);
		}
	
		preg_match('/parent="(?<parent>\w+)"/', $string, $matches);
		if ($matches['parent']) {
			$conf['parent'] = $matches['parent'];
		}
		
		return $conf;
	}
	
	public function parseCSS($tplName)
	{
		$cssFileName = $this->xmlPath.'/'.$tplName.'/main.css';
		$css = $this->read($cssFileName);
		$css = str_replace("\n","",$css);
		
		preg_match_all('/#(?<id>\w+){(?<conf>[^}]+)?}/', $css, $matches);
		
		
		foreach ($matches['id'] as $key=>$value)
		{
			$id = $value;
			$conf = array();
			$tmpArray = explode(';',$matches['conf'][$key]);
			foreach ($tmpArray as $tmpValue)
			{
				$tmpConf = explode(':', $tmpValue);
				if ($tmpConf[0])
				{
					$conf[trim($tmpConf[0])] = trim($tmpConf[1]);
				}
			}
			$this->cssContent[$id] = $conf;
		}
	}
	
	public function generateTpl()
	{
		$this->generateHFile();
		$this->generateMFile();
	}
	
	public  function generateHFile()
	{
		$content = 
"//
//  {$this->fileName}.h
//  多拍相机
//
//  Created by AirtakeXMLTplEngine on 14-8-6.
//  Copyright (c) 2014年 Verylife. All rights reserved.
//

@interface {$this->fileName} : {$this->className}
		
";
		
		foreach ($this->xmlContent as $value)
		{
			$content .= "@property(nonatomic,strong) {$value['class']} *{$value['id']};\n";
		}				
		$content .= "\n@end";
		
		$this->write($this->hFileName, $content);
		
// 		echo $this->hFileName."\n-------------\n";
// 		echo $content;
	}

	public  function generateMFile()
	{
		$content  = $this->mFileHeaderTpl();
		$content .= $this->mFileBodyTpl();
		$content .= $this->mFileFooterTpl();
		
		$this->write($this->mFileName, $content);

// 		echo $this->mFileName."\n-------------\n";
// 		echo $content;
	}

	public function mFileHeaderTpl()
	{
		return 
"//
//  {$this->fileName}.m
//  多拍相机
//
//  Created by Verylife on 14-8-6.
//  Copyright (c) 2014年 Verylife. All rights reserved.
//

#import \"{$this->fileName}.h\"

@implementation {$this->fileName}

";
	}
	
	public function mFileFooterTpl()
	{
		return 
"
@end				
";
	}
	
	public function mFileBodyTpl()
	{
		$body = $this->initAndAddSubviewTpl();
		foreach ($this->xmlContent as $xml)
		{
			$css = $this->cssContent[$xml['id']];
			
			switch ($xml['class']) {
				case 'UIImageView':
				 	$body .= $this->imageViewClass()->init($xml, $css);
					break;
				
				case 'RTLabel':
					$body .= $this->rtLabelClass()->init($xml, $css);
					break;

				case 'UIButton':
					$body .= $this->buttonClass()->init($xml, $css);
					break;

				default:
					$body .= $this->viewClass()->init($xml, $css);
				break;
			}
		}
		
		return $body;
	}

	public function initAndAddSubviewTpl()
	{
		$body =
		"- (id)initWithFrame:(CGRect)frame
{
	self = [super initWithFrame:frame];
	if (self) {
";
	
		foreach ($this->xmlContent as $value)
		{
			$body .= 
"		[self addSubview:self.{$value['id']}];\n";
		}
		$body .=		
"	}
	return self;
}
";
		return $body;
	}
	
	public function imageViewClass()
	{
		if (!$this->imageViewClass)
		{
			$this->imageViewClass = new ImageViewClass;
		}
		return $this->imageViewClass;
	}
	
	public function rtLabelClass()
	{
		if (!$this->rtLabelClass)
		{
			$this->rtLabelClass = new RTLabelClass();
		}
		return $this->rtLabelClass;
	}
	
	public function buttonClass()
	{
		if (!$this->buttonClass)
		{
			$this->buttonClass = new ButtonClass();
		}
		return $this->buttonClass;
	}
	
	public function viewClass()
	{
		if (!$this->viewClass)
		{
			$this->viewClass = new ViewClass();
		}
		return $this->viewClass;
	}
	
	public function read($fileName, $method = 'rb') {
		$data = '';
		if (!$handle = fopen($fileName, $method)) return false;
		while (!feof($handle))
			$data .= fgets($handle, 4096);
		fclose($handle);
		return $data;
	}
	
	public function write($fileName, $data, $method =  'rb+', $ifLock = true, $ifCheckPath = true, $ifChmod = true) {
		touch($fileName);
		if (!$handle = fopen($fileName, $method)) return false;
		$ifLock && flock($handle, LOCK_EX);
		$writeCheck = fwrite($handle, $data);
		$method ==  'rb+' && ftruncate($handle, strlen($data));
		fclose($handle);
		$ifChmod && chmod($fileName, 0777);
		return $writeCheck;
	}
}