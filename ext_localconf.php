<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.' . $_EXTKEY,
    'Eventlist',
    [
        'Event' => 'list, show, showNotFound, listUpcoming, new, update, create, delete, printCal',
    ],
    // non-cacheable actions
    [
        'Event' => 'new, update, create, delete',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.' . $_EXTKEY,
    'Eventsubscribe',
    [
        'Subscriber' => 'new, create, delete, eventNotFound, subscriberNotFound',
    ],
    // non-cacheable actions
    [
        'Subscriber' => 'new, create, delete',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.' . $_EXTKEY,
    'Eventuserpanel',
    [
        'Event'      => 'listOwn, show',
        'Subscriber' => 'list, show',
    ],
    // non-cacheable actions
    [
        'Event' => 'listOwn',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.' . $_EXTKEY,
    'Eventgeniusbar',
    [
        'Category' => 'list, gbList',
    ],
    // non-cacheable actions
    [
        'Category' => '',
    ]
);

## EXTENSION BUILDER DEFAULTS END TOKEN -
# Everything BEFORE this line is overwritten with the defaults of the extension builder

/***************************************************************
 * Backend module
 */
if (TYPO3_MODE === 'BE') {

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        Slub\SlubEvents\Slots\HookPreProcessing::class;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        Slub\SlubEvents\Slots\HookPostProcessing::class;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        Slub\SlubEvents\Slots\HookPostProcessing::class;

    // include cli command controller
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] =
        Slub\SlubEvents\Command\CheckeventsCommandController::class;

    $languageDir = $_EXTKEY . '/Resources/Private/Language/';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Slub\\SlubEvents\\Task\\StatisticsTask'] = [
        'extension'        => $_EXTKEY,
        'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.statistics.name',
        'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.statistics.description',
        'additionalFields' => Slub\SlubEvents\Task\StatisticsTaskAdditionalFieldProvider::class
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Slub\\SlubEvents\\Task\\CleanUpTask'] = [
        'extension'        => $_EXTKEY,
        'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.cleanup.name',
        'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.cleanup.description',
        'additionalFields' => Slub\SlubEvents\Task\CleanUpTaskAdditionalFieldProvider::class
    ];
}
