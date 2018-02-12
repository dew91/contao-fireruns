<?php
/* === FireRuns Contao Bundle ===
 *
 * Copyright (c) 2017-2018 Dominic Ernst
 * http://www.dominic-ernst.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * config.php
 * - contao bundle configuration settings
 */

/**
 * FireRuns modules configuration
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */

// Register backend modules
$GLOBALS['BE_MOD']['content']['fireruns'] = array(
	'tables' => array(
		'tl_firerun'
	)
);

// Register frontend modules
$GLOBALS['FE_MOD']['fireruns']['fireruns'] = 'dew91\\FireRuns\\Module\\FireRuns';

// Register models
$GLOBALS['TL_MODELS']['tl_firerun'] = 'dew91\\FireRuns\\Model\\FireRunsModel';
?>
