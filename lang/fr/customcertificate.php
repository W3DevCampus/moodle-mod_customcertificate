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
$string['viewcertificateviews'] = 'Voir {$a} certificats délivrés';
$string['summaryofpreviouscertificate'] = 'Résumé des certificats reçus précédemment'; 
$string['issued'] = 'Délivré';
$string['coursegrade'] = 'Note de cours';
$string['getcertificate'] = 'Obtenez votre certificat';
$string['awardedto'] = 'Décerné à';
$string['receiveddate'] = 'Date de réception';
$string['grade'] = 'Note';
$string['code'] = 'Code';
$string['report'] = 'Signaler';
$string['hours'] = 'Heures';
$string['keywords'] = 'certificat, cours, pdf, moodle';
$string['pluginadministration'] = 'Administration de certificat';
$string['awarded'] = 'Décerné';
$string['deletissuedcertificates'] = 'Supprimer les certificats délivrés';
$string['nocertificatesissued'] = 'Pas de certificat délivré';

//Form
$string['certificatename'] = 'Nom du certificat';
$string['userphoto'] = 'Fichier image de l\'utilisateur du certificat';
$string['certificateimage'] = 'Fichier image du certificat';
$string['certificatetext'] = 'Texte du certificat';
$string['certificatetextx'] = 'Position horizontale du texte du certificat';
$string['certificatetexty'] = 'Position verticale du texte du certificat';
$string['introcertificatetext'] = 'Texte d\'introduction du certificat';
$string['introcertificatetextx'] = 'Position horizontale du texte d\'introduction du certificat';
$string['introcertificatetexty'] = 'Position verticale du texte d\'introduction du certificat';
$string['conclucertificatetext'] = 'Texte de conclusion du certificat';
$string['conclucertificatetextx'] = 'Position horizontale du texte de conclusion du certificat';
$string['conclucertificatetexty'] = 'Position verticale du texte de conclusion du certificat';
$string['height'] = 'Hauteur du certificat';
$string['width'] = 'Largeur du certificat';
$string['coursehours'] = 'Heures de cours';
$string['coursename'] = 'Nom alternatif du cours';
$string['intro'] = 'Description';
$string['printoutcome'] = 'Imprimer le résultat';
$string['printdate'] = 'Imprimer la date';

////Date options
$string['issueddate'] = 'Date de publication';
$string['completiondate'] = 'Date d’achèvement de cours';
$string['datefmt'] = 'Format de la date';

////Date format options
$string['userdateformat'] = 'Format de la date dans la langue de l\'utilisateur';

$string['printgrade'] = 'Imprimer la note';
$string['gradefmt'] = 'Format de la note';
////Grade format options
$string['gradeletter'] = 'Note en lettre';
$string['gradepercent'] = 'Note en pourcentage';
$string['gradepoints'] = 'Note en points';
$string['coursetimereq'] = 'Temps passé exigé dans ce cours (en minutes)';

$string['addphoto'] = 'Ajouter une photo au certificat';
$string['addphotox'] = 'Position horizontale de la photo de l\'utilisateur';
$string['addphotoy'] = 'Position verticale de la photo de l\'utilisateur';
$string['addphotowidth'] = 'Largeur de la photo de l\'utilisateur';
$string['addphotoheight'] = 'Hauteur de la photo de l\'utilisateur';


////Form options help text

$string['certificatename_help'] = 'Nom du certificat';
$string['certificatetext_help'] = 'Ceci est le texte qui sera utilisé dans le certificat définitif (en pdf), certains mots spéciaux seront remplacés par des variables 
telles que le nom du cours, le nom de l\'étudiant, les notes, etc. Ce sont:

{USERNAME} -> Nom complet de l\'utilisateur
{COURSENAME} -> Nom complet du cours (ou le nom alternatif du cours)
{GRADE} -> Note formatée
{DATE} -> Date formatée
{OUTCOME} -> Résultats
{HOURS} -> Heures définies du cours
{TEACHERS} -> Liste des enseignants
{IDNUMBER} -> Numéro d\'identification du l\'utilisateur
{FIRSTNAME} -> Prénom de l\'utilisateur
{LASTNAME} -> Nom de famille de l\'utilisateur
{EMAIL} -> Courriel de l\'utilisateur
{ICQ} -> ICQ de l\'utilisateur
{SKYPE} -> Skype de l\'utilisateur
{YAHOO} -> Messagerie Yahoo de l\'utilisateur
{AIM} -> AIM de l\'utilisateur
{MSN} -> MSN de l\'utilisateur
{PHONE1} -> Numéro de téléphone de l\'utilisateur
{PHONE2} -> Deuxième numéro de téléphone de l\'utilisateur
{INSTITUTION} -> Institution ou société de l\'utilisateur
{DEPARTMENT} -> Département (direction, développement, etc.) de l\'utilisateur
{ADDRESS} -> Adresse de l\'utilisateur
{CITY} -> Ville de l\'utilisateur
{COUNTRY} -> Pays de l\'utilisateur
{URL} -> Site Web de l\'utilisateur
{PROFILE_xxxx} -> Les champs personnalisés de l\'utilisateur

Pour utiliser les champs de profils personnalisés, vous devez utiliser le préfixe "PROFILE_ ». par exemple: vous avez créé un profil personnalisé avec nom abrégé de "anniversaire", 
donc la marque de texte utilisé sur le certificat doit être {PROFILE_BIRTHDAY}. 
Le texte peut utiliser du html de base, des polices de base, des tables, mais il faut éviter toute définition de ‘position';

$string['introcertificatetext_help'] = 'Ceci est le texte qui sera utilisé dans le certificat définitif (en pdf), en tant qu\'introduction. Certains mots spéciaux seront remplacés par des variables 
telles que le nom du cours, le nom de l\'étudiant, les notes, etc. Ce sont:

{USERNAME} -> Nom complet de l\'utilisateur
{COURSENAME} -> Nom complet du cours (ou le nom alternatif du cours)
{GRADE} -> Note formatée
{DATE} -> Date formatée
{OUTCOME} -> Résultats
{HOURS} -> Heures définies du cours
{TEACHERS} -> Liste des enseignants
{IDNUMBER} -> Numéro d\'identification du l\'utilisateur
{FIRSTNAME} -> Prénom de l\'utilisateur
{LASTNAME} -> Nom de famille de l\'utilisateur
{EMAIL} -> Courriel de l\'utilisateur
{ICQ} -> ICQ de l\'utilisateur
{SKYPE} -> Skype de l\'utilisateur
{YAHOO} -> Messagerie Yahoo de l\'utilisateur
{AIM} -> AIM de l\'utilisateur
{MSN} -> MSN de l\'utilisateur
{PHONE1} -> Numéro de téléphone de l\'utilisateur
{PHONE2} -> Deuxième numéro de téléphone de l\'utilisateur
{INSTITUTION} -> Institution ou société de l\'utilisateur
{DEPARTMENT} -> Département (direction, développement, etc.) de l\'utilisateur
{ADDRESS} -> Adresse de l\'utilisateur
{CITY} -> Ville de l\'utilisateur
{COUNTRY} -> Pays de l\'utilisateur
{URL} -> Site Web de l\'utilisateur
{PROFILE_xxxx} -> Les champs personnalisés de l\'utilisateur

Pour utiliser les champs de profils personnalisés, vous devez utiliser le préfixe "PROFILE_ ». par exemple: vous avez créé un profil personnalisé avec nom abrégé de "anniversaire", 
donc la marque de texte utilisé sur le certificat doit être {PROFILE_BIRTHDAY}. 
Le texte peut utiliser du html de base, des polices de base, des tables, mais il faut éviter toute définition de ‘position';

$string['conclucertificatetext_help'] = 'Ceci est le texte qui sera utilisé dans le certificat définitif (en pdf), en tant que conclusion. Certains mots spéciaux seront remplacés par des variables 
telles que le nom du cours, le nom de l\'étudiant, les notes, etc. Ce sont:

{USERNAME} -> Nom complet de l\'utilisateur
{COURSENAME} -> Nom complet du cours (ou le nom alternatif du cours)
{GRADE} -> Note formatée
{DATE} -> Date formatée
{OUTCOME} -> Résultats
{HOURS} -> Heures définies du cours
{TEACHERS} -> Liste des enseignants
{IDNUMBER} -> Numéro d\'identification du l\'utilisateur
{FIRSTNAME} -> Prénom de l\'utilisateur
{LASTNAME} -> Nom de famille de l\'utilisateur
{EMAIL} -> Courriel de l\'utilisateur
{ICQ} -> ICQ de l\'utilisateur
{SKYPE} -> Skype de l\'utilisateur
{YAHOO} -> Messagerie Yahoo de l\'utilisateur
{AIM} -> AIM de l\'utilisateur
{MSN} -> MSN de l\'utilisateur
{PHONE1} -> Numéro de téléphone de l\'utilisateur
{PHONE2} -> Deuxième numéro de téléphone de l\'utilisateur
{INSTITUTION} -> Institution ou société de l\'utilisateur
{DEPARTMENT} -> Département (direction, développement, etc.) de l\'utilisateur
{ADDRESS} -> Adresse de l\'utilisateur
{CITY} -> Ville de l\'utilisateur
{COUNTRY} -> Pays de l\'utilisateur
{URL} -> Site Web de l\'utilisateur
{PROFILE_xxxx} -> Les champs personnalisés de l\'utilisateur

Pour utiliser les champs de profils personnalisés, vous devez utiliser le préfixe "PROFILE_ ». par exemple: vous avez créé un profil personnalisé avec nom abrégé de "anniversaire", 
donc la marque de texte utilisé sur le certificat doit être {PROFILE_BIRTHDAY}. 
Le texte peut utiliser du html de base, des polices de base, des tables, mais il faut éviter toute définition de ‘position';

$string['textposition'] = 'Position du texte dans le certificat';
$string['textposition_help'] = 'Ce sont les coordonnées XY (en millimètres) du texte du certificat';
$string['size'] = 'Taille du certificat';
$string['size_help'] = 'C\'est la taille de la largeur et de la hauteur (en millimètres) du certificat. La taille par défaut est un A4 en mode paysage';
$string['coursehours_help'] = 'Heures du cours';
$string['coursename_help'] = 'Nom alternatif du cours';
$string['userphoto_help'] = 'Cette image  sera utilisée dans le certificat comme la photo de l\'utilisateur';
$string['certificateimage_help'] = 'Cette image sera utilisée dans le certificat';

$string['printoutcome_help'] = 'Vous pouvez choisir n\'importe quel résultat du cours et imprimer le nom du résultat et celui obtenu par l\'utilisateur sur le certificat.
Un exemple pourrait être: Affectation Résultat : Maîtrise';
$string['printdate_help'] = 'C\'est la date d\'envoi qui sera imprimée, si la date d\'impression est sélectionnée. Si la date de fin de cours est sélectionnée, mais l\'élève n\'a pas terminé le cours, alors la date de réception sera imprimée. 

Vous pouvez également choisir d\'imprimer la date au moment où une activité a été notée. Si un certificat est délivré avant, cette activité est notée, et la date de réception sera imprimée.';


$string['datefmt_help'] = 'Entrez un modèle de format de date PHP valide (http://www.php.net/manual/en/function.strftime.php) ou laisser vide pour utiliser le format de la langue choisie par l\'utilisateur.';
$string['gradefmt_help'] = 'Il y a trois formats disponibles si vous choisissez d\'imprimer une note sur le certificat :

Niveau par pourcentage : Imprimer la note comme un pourcentage.
Niveau par points : Imprimer la note comme des points.
Niveau par lettre : Imprimer la note comme une lettre.';


$string['coursetimereq_help'] = 'Entrez ici le temps minimum requis passé par l\'étudiant dans le cours avant qu\'il n\'ait le droit d\'obtenir son certificat (en minutes).';

$string['addphoto_help'] = 'Si vous choisissez cette option, les étudiants sont forcés d\'uploader leur photo pour récupérer leur certificat.';



//Admin settings page
$string['defaultwidth'] = 'Largeur par défaut';
$string['defaultheight'] = 'Hauteur par défaut';
$string['defaultcertificatetextx'] = 'Position horizontale du texte par défaut';
$string['defaultcertificatetexty'] = 'Position verticale du texte par défaut';
$string['defaultintrocertificatetextx'] = 'Position horizontale du texte d\'introduction par défaut';
$string['defaultintrocertificatetexty'] = 'Position verticale du texte d\'introduction par défaut';
$string['defaultconclucertificatetextx'] = 'Position horizontale du texte de conclusion par défaut';
$string['defaultconclucertificatetexty'] = 'Position verticale du texte de conclusion par défaut';

$string['defaultaddphotox'] = 'Position horizontale de la photo de l\'utilisateur par défaut';
$string['defaultaddphotoy'] = 'Position verticale de la photo de l\'utilisateur par défaut';
$string['defaultaddphotowidth'] = 'Largeur de la photo de l\'utilisateur';
$string['defaultaddphotoheight'] = 'Hauteur de la photo de l\'utilisateur';

$string['link'] = 'Ce lien';

//Erros
$string['filenotfound'] = 'Fichier non trouvé : {$a}';
$string['invalidcode'] = 'Code de certificat invalide';
$string['cantdeleteissue'] = 'Erreur de suppression de certificats délivrés';


//Verify certificate page
$string['certificateverification'] = 'Vérification des certificats';

//Adding photo certificate page
$string['certificateaddphoto'] = 'Ajouter votre photo d\'identité';
$string['unknowchar'] = 'Le nom de votre fichier contient des caractères spéciaux, merci de corriger et de réessayer.';
$string['emailvalidationphotosubject'] = '[Moodle] Une photo d\'utilisateur à besoin d\'être validée !';
$string['emailvalidationphotolink'] = 'Vous pouvez valider les photos des utilisateurs par ce lien : ';
$string['emailvalidationphotolinkhtml'] = 'Vous pouvez valider les photos des utilisateurs par ';

//Pending certificate page
$string['pendingcertificate'] = 'En attente de validation';
$string['pending'] = 'Votre photo est en cours de validation, merci de patienter.';

//Save certificate page
$string['savecertificate'] = 'Obtenir une archive';
$string['archivefinished'] = 'L\'archive est complétée, pour pouvez l\'obtenir via ';
$string['archiveerror'] = 'Une erreur est survenue à la création de l\'archive, merci de réessayer plus tard.';

//Validation certificate page
$string['validationcertificate'] = 'Validation des photos d\'étudiants';
$string['emailvalidatedphotosubject'] = '[Moodle] Votre photo est validée !';
$string['emailvalidatedphotolink'] = 'Vous pouvez récupérer votre certificat par ce lien : ';
$string['emailvalidatedphotolink'] = 'Vous pouvez récupérer votre certificat par ';
$string['refresh'] = 'Rafraichissez la page si vous souhaitez valider d\'autres photos.';
$string['photovalidated'] = 'Ces photos ont été validées :';
$string['permissiondenied'] = 'Vous n\'avez pas la permission d\’accéder à cette page.';

//Menu
$string['validationlink'] = 'Validation des photos d\'étudiants';
$string['verificationlink'] = 'Vérification des certificats';
$string['archivelink'] = 'Archive';

//Settings
$string['certlifetime'] = 'Gardez les certificats délivrés pendant : (en mois)';
$string['certlifetime_help'] = 'Ceci spécifie la durée pendant laquelle vous souhaitez conserver les certificats délivrés. Les certificats délivrés plus anciens que cette date seront automatiquement supprimés.';
$string['neverdeleteoption'] = 'Ne jamais supprimer';

$string['variablesoptions'] = 'Autre options';
$string['getcertificate'] = 'Obtenir le certificat';
$string['verifycertificate'] = 'Vérifier le certificat';


$string['customcertificate'] = 'Vérification du code de "custom certificate"';
$string['customcertificate:addinstance'] = 'Ajout d\'une instance de "custom certificate"';
$string['customcertificate:manage'] = 'Gérer une instance de "custom certificate"';
$string['customcertificate:printteacher'] = 'Être répertorié comme un enseignant sur ​​le "custom certificate" si le réglage de professeur éditeur est activé';

$string['customcertificate:student'] = 'Récupérer un "custom certificate"';
$string['customcertificate:view'] = 'Voir un "custom certificate"';
