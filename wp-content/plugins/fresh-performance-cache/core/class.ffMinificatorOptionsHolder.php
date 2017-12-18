<?php
/**
 * Basically options for the whole minificator plugin. They could be
 * accessed via the admin screen. They will also be accessed across
 * the whole plugin.
 * 
 * @author boobs.lover
 */
class ffMinificatorOptionsHolder extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure('minificator');
		
		$s->startSection('minificator');

			//$s->addElement( ffOneElement::TYPE_PARAGRAPH, '', 'Cache is gradually improved as your site is being browsed.');
		
			$s->addElement( ffOneElement::TYPE_TABLE_START );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'General');

					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'enable_cache', 'Enable Fresh Performance Cache ', 0, '');

					$s->addElement( ffOneElement::TYPE_NEW_LINE);

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<span style="color:red; font-weight:bold">PLEASE READ:</span> Fresh Performance Cache 
					minifies your CSS and JS files and merges them together into one small file. This will speedup loading the site. 
					It works smoothly in like 95% of cases. However there are developers, who write incorrect JS and CSS codes and these codes then breaks the whole site, so if this happens,
					 simply de-activate Fresh Performance Cache and you are good to go. Minification is very hard computing process, so in first few runs you might experience timeout PHP errors.
					  This is completely OK, just refresh your site 5 - 10 times, till the cache has been build.');

					$s->addElement( ffOneElement::TYPE_NEW_LINE);
				
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_css', 'Minify CSS ', 1, '');
					
					$s->addElement( ffOneElement::TYPE_NEW_LINE);
					
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_js', 'Minify JavaScript ', 1, '');
					
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
				
				
				/*
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Allow monitoring of included assets');
				
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_monitoring_css', 'of CSS ', 1, '');
					
					$s->addElement( ffOneElement::TYPE_NEW_LINE);
					
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_monitoring_js', 'of JavaScript ', 1, '');
					
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
				
				*/
		
			$s->addElement(ffOneElement::TYPE_TABLE_END);
	
		$s->endSection();
		
		return $s;
	}
}

