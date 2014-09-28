<?php

/**
 * Code fragment to define the version of the customcertificate module
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$module->version  = 2013070501; // The current module version (Date: YYYYMMDDXX)
$module->requires = 2011120500;  // Requires this Moodle version
$module->cron     = 4 * 3600;    // Period for cron to check this module (secs)
$module->release  = '1.0.0';       // Human-friendly version name
//MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC, MATURITY_STABLE
$module->maturity = MATURITY_STABLE;