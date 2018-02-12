<?php
/* === FireRuns Contao Bundle ===
 *
 * Copyright (c) 2017-2018 Dominic Ernst
 * http://www.dominic-ernst.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * tl_firerun.php
 * - DCA configuration of table 'tl_firerun'
 */

/**
 * FireRun DCA
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */
$GLOBALS['TL_DCA']['tl_firerun'] = [
	'config' => [
		'dataContainer' => 'Table',
		'notCopyable' => true,
		'switchToEdit' => false,
		'enableVersioning' => false,
		'sql' => [
			'keys' => [
				'id' => 'primary'
			]
		]
	],
	'list' => [
		'sorting' => [
			'mode' => 1,
			'fields' => ['opDateTime'],
			'flag' => 12,
			'panelLayout' => 'sort,filter;search,limit'
		],
		'label' => [
			'fields' => ['opDateTime', 'opType'],
			'showColumns' => true,
			'format' => '%s',
			'label_callback' => array('tl_firerun', 'formatLabel'),
		],
		'global_operations' => [],
		'operations' => [
			'edit' => [
				'label' => &$GLOBALS['TL_LANG']['tl_firerun']['edit'],
				'href' => 'act=edit',
				'icon' => 'edit.svg'
			],
			'delete' => [
				'label' => &$GLOBALS['TL_LANG']['tl_firerun']['delete'],
				'href' => 'act=delete',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'icon' => 'delete.svg',
			],
			'show' => [
				'label' => &$GLOBALS['TL_LANG']['tl_firerun']['show'],
				'href' => 'act=show',
				'icon' => 'show.svg'
			],
		],
	],
	'palettes' => [
		'__selector__' => [],
		'default' => '{title_runattributes},opDateTime,opType,opArrivalState,opMeasures,opVisible',
	],
	'subpalettes' => [
		'' => '',
	],
	'fields' => [
		'id' => [
			'sql' => "int(10) unsigned NOT NULL auto_increment",
		],
		'tstamp' => [
			'sql' => "int(10) unsigned NOT NULL default '0'",
		],
		'opDateTime' => [
			'label' => &$GLOBALS['TL_LANG']['tl_firerun']['field_opDateTime'],
			'exclude' => true,
			'search' => true,
			'sorting' => true,
			'filter' => false,
			'flag' => 12,
			'inputType' => 'text',
			'eval' => [
				'mandatory' => true,
				'rgxp' => 'datim',
				'datepicker' => true,
				'readonly' => false,
				'tl_class' => 'w50 wizard',
			],
			'sql' => 'varchar(10) NOT NULL',
		],
		'opType' => [
			'label' => &$GLOBALS['TL_LANG']['tl_firerun']['field_opType'],
			'exclude' => true,
			'search' => false,
			'sorting' => true,
			'filter' => true,
			'flag' => 11,
			'inputType' => 'select',
			'options' => &$GLOBALS['TL_LANG']['tl_firerun']['opTypeValues'],
			'eval' => [
				'mandatory' => true,
				'tl_class' => 'w50',
			],
			'sql' => 'tinyint(2) NOT NULL',
		],
		'opArrivalState' => [
			'label' => &$GLOBALS['TL_LANG']['tl_firerun']['field_opArrivalState'],
			'exclude' => true,
			'search' => true,
			'sorting' => false,
			'filter' => false,
			'flag' => 11,
			'inputType' => 'text',
			'eval' => [
				'mandatory' => true,
				'maxlength' => 400,
				'tl_class' => 'long clr',
			],
			'sql' => 'varchar(400) NOT NULL',
		],
		'opMeasures' => [
			'label' => &$GLOBALS['TL_LANG']['tl_firerun']['field_opMeasures'],
			'exclude' => true,
			'search' => true,
			'sorting' => false,
			'filter' => false,
			'flag' => 11,
			'inputType' => 'text',
			'eval' => [
				'mandatory' => true,
				'maxlength' => 400,
				'tl_class' => 'long',
			],
			'sql' => 'varchar(400) NOT NULL',
		],
		'opVisible' => [
			'label' => &$GLOBALS['TL_LANG']['tl_firerun']['field_opVisible'],
			'exclude' => true,
			'search' => false,
			'sorting' => false,
			'filter' => true,
			'flag' => 11,
			'inputType' => 'checkbox',
			'eval' => [
				'mandatory' => false,
				'tl_class' => 'w50',
			],
			'sql' => "char(1) NOT NULL default ''",
		],
	]
];

/**
 * Class for handling backend data formatting of database records
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */
class tl_firerun extends Backend
{
	/**
	 * Format label cells in operation list view
	 *
	 * @param array $row        Database record row
	 * @param array $label      Table label array
	 * @param DataContainer $dc Current data container
	 * @param array $args       Record values assoc. array
	 *
	 * @return array Returns formatted $args array
	 */
	public function formatLabel($row, $label, DataContainer $dc, $args)
	{
		if($row['opVisible'])
			$_img = '<img src="/bundles/fireruns/tick.png" alt="Aktiv" title="Eintrag ist sichtbar" />';
		else
			$_img = '<img src="/bundles/fireruns/hourglass.png" alt="Inaktiv" title="Eintrag ist nicht sichtbar" />';
		$args[0] = $_img.'&nbsp;'.date('Y-m-d H:i', $args[0]);
		return $args;
	}
}
?>
