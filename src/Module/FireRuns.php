<?php
/* === FireRuns Contao Bundle ===
 *
 * Copyright (c) 2017-2018 Dominic Ernst
 * http://www.dominic-ernst.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * FireRuns.php
 * - provides front end module "Fire Runs"
 */

namespace dew91\FireRuns\Module;

use dew91\FireRuns\Model\FireRunsModel;
use Contao;
/**
 * FireRuns Frontend Module
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */
class FireRuns extends \Module
{
	/**
	 * @var string Template
	 */
	protected $strTemplate = 'mod_fireruns_list';

	/**
	 * @var integer Current selected year
	 */
	protected $curYear = NULL;

	/**
	 * Generate module instance, assign get input parameters.
	 *
	 * @return string The module html code
	 */
	public function generate()
	{
		// Check if module is displayed in Backend
		if(TL_MODE == 'BE')
		{
			/** @var \BackendTemplate|object $objTemplate */
			// Generate module placeholder for Backend display:
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['FireRuns'][0]) . ' ###';
			$objTemplate->title = $GLOBALS['TL_LANG']['FMD']['FireRuns'][0];
			$objTemplate->id = $this->id;
			$objTemplate->link = $GLOBALS['TL_LANG']['FMD']['FireRuns'][1];
			$objTemplate->href = 'contao?do=themes&table=tl_module&act=edit&id='.$this->id;

			return $objTemplate->parse();
		}

		// Assign URL get parameter "year"
		// -> for implementing year filtering
		\Input::setGet($GLOBALS['TL_LANG']['tl_firerun']['getParamYear'], \Input::get($GLOBALS['TL_LANG']['tl_firerun']['getParamYear']));
		$this->curYear = \Input::get($GLOBALS['TL_LANG']['tl_firerun']['getParamYear']);

		return parent::generate();
	}

	/*
	 * Generate module
	 */
	public function compile()
	{
		// === CHECK FOR CURRENT YEAR ===
		// Check for current year parameter
		if($this->curYear != NULL && preg_match('/^[0-9]{4}$/', $this->curYear))
		{
			// Assign given year to template variable
			$this->Template->Year = $this->curYear;
		} else {
			// Assign current year to template variable, as no year parameter was given
			$this->Template->Year = date('Y');
		}
		// Set current year to year maximum value
		$this->Template->YearMax = date('Y');
		// Set oldest record year to year minimum value
		$this->Template->YearMin = $this->getYearMin();

		// Set link template for year links
		global $objPage;
		$this->Template->YearURL = $this->generateFrontendUrl($objPage->row(), '/'.$GLOBALS['TL_LANG']['tl_firerun']['getParamYear'].'/%s');

		// Load operation kinds from language array
		$this->Template->opTypeValues = $GLOBALS['TL_LANG']['tl_firerun']['opTypeValues'];

		// Load operation records for current selected year
		$this->Template->eItems = $this->getFireRunsYear($this->Template->Year);

		// Load total count of operations
		$this->Template->OverallCount = $this->getFireRunsCount();
	}

	/**
	 * Find the year minimum value from database
	 *
	 * @return integer|null The lowest year from database or null of no records present
	 */
	private function getYearMin()
	{
		$objRun = FireRunsModel::findYearMin();
		return date('Y', $objRun->opDateTime);
	}

	/**
	 * Find fire run records for given year.
	 *
	 * @param integer $jahr Four digit year for record filtering
	 *
	 * @return \Model\Collection|null Returns list of record models or null if no records found.
	 */
	private function getFireRunsYear($year)
	{
		return FireRunsModel::findByYear($year);
	}

	/**
	 * Find total count of fire runs from database.
	 *
	 * @return integer Count of active database records
	 */
	private function getFireRunsCount()
	{
		return FireRunsModel::findOverallCount();
	}
}
?>
