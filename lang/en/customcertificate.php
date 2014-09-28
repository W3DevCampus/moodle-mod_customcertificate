<?php

/**
 * Language strings for the customcertificate module
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  W3DevCampus/W3C <training@w3.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


//-----
$string['modulename'] = 'Custom Certificate';
$string['modulenameplural'] = 'Custom Certificates';
$string['pluginname'] = 'Custom Certificate';
$string['viewcertificateviews'] = 'View {$a} issued certificates';
$string['summaryofpreviouscertificate'] = 'Summary of previously received certificates';
$string['issued'] = 'Issued';
$string['coursegrade'] = 'Course Grade';
$string['getcertificate'] = 'Get Your Certificate';
$string['awardedto'] = 'Awarded To';
$string['receiveddate'] = 'Date Received';
$string['grade'] = 'Grade';
$string['code'] = 'Code';
$string['report'] = 'Report';
$string['hours'] = 'Hours';
$string['keywords'] = 'Certificate, course, pdf, moodle';
$string['pluginadministration'] = 'Certificate Administration';
$string['awarded'] = 'Awarded';
$string['deletissuedcertificates'] = 'Delete Issued Certificates';
$string['nocertificatesissued'] = 'No Certificates Have Been Issued';

//Form
$string['certificatename'] = 'Certificate Name';
$string['certificateimage'] = 'Certificate Image File';
$string['userphoto'] = 'Certificate User Photo File';
$string['certificatetext'] = 'Certificate Text';
$string['certificatetextx'] = 'Certificate Text Horizontal Position';
$string['certificatetexty'] = 'Certificate Text Vertical Position';
$string['introcertificatetext'] = 'Introduction Certificate Text';
$string['introcertificatetextx'] = 'Introduction Certificate Text Horizontal Position';
$string['introcertificatetexty'] = 'Introduction Certificate Text Vertical Position';
$string['conclucertificatetext'] = 'Conclusion Certificate Text';
$string['conclucertificatetextx'] = 'Conclusion Certificate Text Horizontal Position';
$string['conclucertificatetexty'] = 'Conclusion Certificate Text Vertical Position';
$string['height'] = 'Certificate Height';
$string['width'] = 'Certificate Width';
$string['coursehours'] = 'Course Hours';
$string['coursename'] = 'Alternative Course Name';
$string['intro'] = 'Introduction';
$string['printoutcome'] = 'Print Outcome';
$string['printdate'] = 'Print Date';

////Date options
$string['issueddate'] = 'Date Issued';
$string['completiondate'] = 'Course Completion';
$string['datefmt'] = 'Date Format';

////Date format options
$string['userdateformat'] = 'User\'s Language Date Format';

$string['printgrade'] = 'Print Grade';
$string['gradefmt'] = 'Grade Format';
////Grade format options
$string['gradeletter'] = 'Letter Grade';
$string['gradepercent'] = 'Percentage Grade';
$string['gradepoints'] = 'Points Grade';
$string['coursetimereq'] = 'Required minutes in course';
$string['addphoto'] = 'Add Photo to Certificate';
$string['addphotox'] = 'User Photo Horizontal Position';
$string['addphotoy'] = 'User Photo Vertical Position';
$string['addphotowidth'] = 'User Photo Width';
$string['addphotoheight'] = 'User Photo Height';

////Form options help text

$string['certificatename_help'] = 'Certificate Name';
$string['certificatetext_help'] = 'This text will be used in the certificate, some special words will be replaced by variables such as course name, student\'s name, grade, etc. These are:

{USERNAME} -> Full user name
{COURSENAME} -> Full course name (or a defined alternate course name)
{GRADE} -> Formated Grade
{DATE} -> Formated Date
{OUTCOME} -> Outcomes
{HOURS} -> Defined course hours
{TEACHERS} -> Teachers List
{IDNUMBER} -> User id number
{FIRSTNAME} -> User first name        
{LASTNAME} -> User last name        
{EMAIL} -> User e-mail        
{ICQ} -> User ICQ        
{SKYPE} -> User Skype        
{YAHOO} -> User Yahoo messenger        
{AIM} -> User AIM        
{MSN} -> User MSN        
{PHONE1} -> User 1° Phone Number        
{PHONE2} -> User 2° Phone Number        
{INSTITUTION} -> User institution        
{DEPARTMENT} -> User department        
{ADDRESS} -> User address
{CITY} -> User city
{COUNTRY} -> User country
{URL} -> User home page
{PROFILE_xxxx} -> User custom profile fields

In order to use custom profiles fields you must use a "PROFILE_" prefix. For example: you have created a custom profile with "birthday" as a shortname, so the text used on certificate must be {PROFILE_BIRTHDAY} 
The text can use basic html, basic fonts, tables, but please avoid any position definition';

$string['introcertificatetext_help'] = 'This text will be used in the certificate, like an introduction, some special words will be replaced by variables such as course name, student\'s name, grade, etc. These are:

{USERNAME} -> Full user name
{COURSENAME} -> Full course name (or a defined alternate course name)
{GRADE} -> Formated Grade
{DATE} -> Formated Date
{OUTCOME} -> Outcomes
{HOURS} -> Defined course hours
{TEACHERS} -> Teachers List
{IDNUMBER} -> User id number
{FIRSTNAME} -> User first name        
{LASTNAME} -> User last name        
{EMAIL} -> User e-mail        
{ICQ} -> User ICQ        
{SKYPE} -> User Skype        
{YAHOO} -> User Yahoo messenger        
{AIM} -> User AIM        
{MSN} -> User MSN        
{PHONE1} -> User 1° Phone Number        
{PHONE2} -> User 2° Phone Number        
{INSTITUTION} -> User institution        
{DEPARTMENT} -> User department        
{ADDRESS} -> User address
{CITY} -> User city
{COUNTRY} -> User country
{URL} -> User home page
{PROFILE_xxxx} -> User custom profile fields

In order to use custom profiles fields you must use a "PROFILE_" prefix. For example: you have created a custom profile with "birthday" as a shortname, so the text used on certificate must be {PROFILE_BIRTHDAY} 
The text can use basic html, basic fonts, tables, but please avoid any position definition';

$string['conclucertificatetext_help'] = 'This text will be used in the certificate, like a conclusion, some special words will be replaced by variables such as course name, student\'s name, grade, etc. These are:

{USERNAME} -> Full user name
{COURSENAME} -> Full course name (or a defined alternate course name)
{GRADE} -> Formated Grade
{DATE} -> Formated Date
{OUTCOME} -> Outcomes
{HOURS} -> Defined course hours
{TEACHERS} -> Teachers List
{IDNUMBER} -> User id number
{FIRSTNAME} -> User first name        
{LASTNAME} -> User last name        
{EMAIL} -> User e-mail        
{ICQ} -> User ICQ        
{SKYPE} -> User Skype        
{YAHOO} -> User Yahoo messenger        
{AIM} -> User AIM        
{MSN} -> User MSN        
{PHONE1} -> User 1° Phone Number        
{PHONE2} -> User 2° Phone Number        
{INSTITUTION} -> User institution        
{DEPARTMENT} -> User department        
{ADDRESS} -> User address
{CITY} -> User city
{COUNTRY} -> User country
{URL} -> User home page
{PROFILE_xxxx} -> User custom profile fields

In order to use custom profiles fields you must use a "PROFILE_" prefix. For example: you have created a custom profile with "birthday" as a shortname, so the text used on certificate must be {PROFILE_BIRTHDAY} 
The text can use basic html, basic fonts, tables, but please avoid any position definition';
$string['textposition'] = 'Position of the text in the certificate';
$string['textposition_help'] = 'These are the XY coordinates (in millimeters) of the certificate text';
$string['size'] = 'Certificate Size';
$string['size_help'] = 'These are the Width and Height sizes (in millimeters) of the certificate, Default size is A4 Landscape';
$string['coursehours_help'] = 'Course Hours';
$string['coursename_help'] = 'Alternate Course Name';
$string['userphoto_help'] = 'This is the picture that will be used, such as the user photo in the certificate';
$string['certificateimage_help'] = 'This is the picture that will be used in the certificate';

$string['printoutcome_help'] = 'You can choose any course outcome to print the name of the outcome and the user\'s received outcome on the certificate.  An example might be: Assignment Outcome: Proficient.';
$string['printdate_help'] = 'This is the date of send that will be printed, if a print date is selected. If the course completion date is selected but the student has not completed the course, the date received will be printed. You can also choose to print the date based on when an activity was graded. If a certificate is issued before that activity is graded, the date received will be printed.';
$string['datefmt_help'] = 'Enter a valid PHP date format pattern (http://www.php.net/manual/en/function.strftime.php). Or, leave it empty to use the format of the user\'s chosen language.';
$string['gradefmt_help'] = 'There are three available formats if you choose to print a grade on the certificate:

Percentage Grade: Prints the grade as a percentage.
Points Grade: Prints the point value of the grade.
Letter Grade: Prints the percentage grade as a letter.';

$string['coursetimereq_help'] = 'Enter here the minimum amount of time, in minutes, during which a student must be logged into the course before being able to receive the certificate.';
$string['addphoto_help'] = 'If you choose this option, students are forced to upload their photo to get their certificate.';
//


$string['designoptions'] = 'Design Options';

//Admin settings page
$string['defaultwidth'] = 'Default Width';
$string['defaultheight'] = 'Default Height';
$string['defaultcertificatetextx'] = 'Default Horizontal Text Position';
$string['defaultcertificatetexty'] = 'Default Vertical Text Position';
$string['defaultintrocertificatetextx'] = 'Default Introduction Horizontal Text Position';
$string['defaultintrocertificatetexty'] = 'Default Introduction Vertical Text Position';
$string['defaultconclucertificatetextx'] = 'Default Conclusion Horizontal Text Position';
$string['defaultconclucertificatetexty'] = 'Default Conclusion Vertical Text Position';

$string['defaultaddphotox'] = 'Default Horizontal User Photo Position';
$string['defaultaddphotoy'] = 'Default Vertical User Photo Position';
$string['defaultaddphotowidth'] = 'Default User photo width';
$string['defaultaddphotoheight'] = 'Default User photo height';

$string['link'] = 'This link';

//Erros
$string['filenotfound'] = 'File not Found: {$a}';
$string['invalidcode'] = 'Invalid certificate code';
$string['cantdeleteissue'] = 'Error removing issued certificates';


//Verify certificate page
$string['certificateverification'] = 'Certificate Verification';

//Adding photo certificate page
$string['certificateaddphoto'] = 'Add your photo (portrait)';
$string['unknowchar'] = 'The file name contains special characters. Please fix that and and try again.';
$string['emailvalidationphotosubject'] = '[Moodle] A user need a validation of photo !';
$string['emailvalidationphotolink'] = 'You can validate the user\'s photos here: ';
$string['emailvalidationphotolinkhtml'] = 'You can validate the user\'s  photos at ';

//Pending certificate page
$string['pendingcertificate'] = 'The validation is pending';
$string['pending'] = 'Your picture is being validated, please wait.';

//Save certificate page
$string['savecertificate'] = 'Get an archive';
$string['archivefinished'] = 'The archive is completed, you can get it at ';
$string['archiveerror'] = 'There is an error in the creation of the archive, please retry';

//Validation certificate page
$string['validationcertificate'] = 'Validation of user\'s photo';
$string['emailvalidatedphotosubject'] = '[Moodle] Your photo is validated!';
$string['emailvalidatedphotolink'] = 'You can get your certificate at this link: ';
$string['emailvalidatedphotolink'] = 'You can get your certificate at ';
$string['refresh'] = 'Please refresh the page for another validation.';
$string['photovalidated'] = 'These photos are validated: ';
$string['permissiondenied'] = 'You don\'t have the permission to access this page.';

//Menu
$string['validationlink'] = 'Validation of student\’s pictures';
$string['verificationlink'] = 'Verification of certificate';
$string['archivelink'] = 'Archive';

//Settings
$string['certlifetime'] = 'Keep issued certificates for: (in Months)';
$string['certlifetime_help'] = 'This specifies the length of time you want to keep the issued certificates. Issued certificates that are older than this span of time will be automatically deleted.';
$string['neverdeleteoption'] = 'Never delete';

$string['variablesoptions'] = 'Others Options';
$string['getcertificate'] = 'Get Certificate';
$string['verifycertificate'] = 'Verify Certificate';

$string['customcertificate'] = 'Verification of the custom certificate code';
$string['customcertificate:addinstance'] = 'Add a custom certificate instance';
$string['customcertificate:manage'] = 'Manage a custom certificate instance';
$string['customcertificate:printteacher'] = 'Be listed as a teacher on the custom certificate if the print teacher setting is on';
$string['customcertificate:student'] = 'Retrieve a custom certificate';
$string['customcertificate:view'] = 'View a custom certificate';

