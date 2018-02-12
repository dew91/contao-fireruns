<?php
/* === FireRuns Contao Bundle ===
 *
 * Copyright (c) 2017-2018 Dominic Ernst
 * http://www.dominic-ernst.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * FireRunsModel.php
 * - provides functions for fetching operations records from the database
 */

namespace dew91\FireRuns\Model;

/**
 * FireRuns Model
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */
class FireRunsModel extends \Model
{
	/**
	 * @var string Table name
	 */
	protected static $strTable = 'tl_firerun';

	/**
	 * Find the year of the oldest database record.
	 *
	 * @return integer|null The 4 digit year of oldest record or null if no records present
	 */
	public static function findYearMin()
	{
		$t = static::$strTable;
		$arrColumns = array("$t.opVisible=?");
		$arrValues = array(1);
		$arrOptions = array(
			'limit'		=> '1',
			'offset'	=> 0,
			'order'		=> "$t.opDateTime ASC",
		);

		// Equal to SQL query:
		// SELECT * FROM tl_firerun WHERE tl_firerun.opVisible = 1 ORDER BY tl_firerun.opDateTime ASC LIMIT 0 1;

		return static::findOneBy($arrColumns, $arrValues, $arrOptions);
	}

	/**
	 * Find all fire run records for given year.
	 *
	 * @param integer $year The year e.g. 2017
	 *
	 * @return \Model\Collection|null A collection of models or null of no records for given year found
	 */
	public static function findByYear($year)
	{
		$t = static::$strTable;
		$arrColumns = array("$t.opDateTime >= ? AND $t.opDateTime <= ? AND opVisible = ?");
		$arrValues = array(strtotime($year.'-01-01 00:00:00'), strtotime($year.'-12-31 23:59:59'), 1);
		$arrOptions = array(
			'order' => "$t.opDateTime DESC"
		);

		// Equal to SQL query:
		// SELECT * FROM tl_firerun WHERE tl_firerun.opDateTime >= 'strtotime([YEAR]-01-01 00:00:00)' AND tl_firerun.opDateTime <= 'strtotime([YEAR]-12-31 23:59:59)' AND tl_firerun.opVisible = 1 ORDER BY tl_firerun.opDateTime DESC;

		return static::findBy($arrColumns, $arrValues, $arrOptions);
	}

	/**
	 * Find total number of visible fire run records in database.
	 *
	 * @return integer The number of visible records in database
	 */
	public static function findOverallCount()
	{
		// Equal to SQL query:
		// SELECT COUNT(opVisible) FROM tl_firerun WHERE opVisible = 1;
		return static::countBy(array('opVisible=?'), array(1));
	}
}
?>
