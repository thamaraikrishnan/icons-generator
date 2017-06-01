<?php 
namespace Icons;

use Icons\Exception\Exception;

Class IconsGeneratorFactory {
	
	
	const ICONS_GENERATOR	= 'Ticons';
	
	private $iconsGenerators = array();
	
	/** function to use the obj global inside this class **/
	public function __construct() {
		$this->setUpIconsGenerators();
	}
	
	protected function setUpIconsGenerators() {
		$this->iconsGenerators[self::ICONS_GENERATOR]	= new TiconsGenerator();
	}
	
	/**
	 * @param string $name
	 * @return IconsGenerator
	 * @throws Exception When requested IconsGenerator does not exist
	 */
	public function get($name = self::ICONS_GENERATOR)
	{
		if(!isset($this->iconsGenerators[$name])) {
			throw new Exception(sprintf('IconsGenerator "%s" not found', $name));
		}
		
		return $this->iconsGenerators[$name];
	}
}
?>