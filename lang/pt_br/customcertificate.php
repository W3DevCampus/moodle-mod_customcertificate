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
$string['modulename'] = 'Certificado Custom';
$string['modulenameplural'] = 'Certificados Custom';
$string['pluginname'] = 'Certificado Custom';
$string['viewcertificateviews'] = '{$a} certificados emitidos';
$string['summaryofpreviouscertificate'] = 'Resumo dos certificados emitidos';
$string['issued'] = 'Emitidos';
$string['coursegrade'] = 'Nota do curso';
$string['getcertificate'] = 'Obtenha seu certificado';
$string['awardedto'] = 'Obtido para';
$string['receiveddate'] = 'Date de Recebimento';
$string['grade'] = 'Nota';
$string['code'] = 'Código';
$string['report'] = 'Relatório';
$string['opendownload'] = 'Pressione o botão abaixo para salvar o seu certificado no aeu computador.';
$string['openemail'] = 'Pressione o botão abaixo e seu certificado será enviado por email.';
$string['openwindow'] = 'Pressione o botão abaixo para visualizar o seu certificado em uma nova tela.';
$string['hours'] = 'horas';
$string['keywords'] = 'cetificate, course, pdf, moodle';
$string['pluginadministration'] = 'Administração de Certificado';
$string['awarded'] = 'Obtido';
$string['deletissuedcertificates'] = 'Remover os certificados emitidos';
$string['nocertificatesissued'] = 'Nenhum certificado emitido';

//Form
$string['certificatename'] = 'Nome do certificado';
$string['userphoto'] = 'Arquivo de Imagem do user do Certificado';
$string['certificateimage'] = 'Arquivo de Imagem do Certificado';
$string['certificatetext'] = 'Texto do Certificado';
$string['certificatetextx'] = 'Posição Horizontal do texto do certificado';
$string['certificatetexty'] = 'Posição Vertical do texto do certificado';
$string['introcertificatetext'] = '';
$string['introcertificatetextx'] = '';
$string['introcertificatetexty'] = '';
$string['conclucertificatetext'] = '';
$string['conclucertificatetextx'] = '';
$string['conclucertificatetexty'] = '';
$string['height'] = 'Altura do certificado';
$string['width'] = 'Largura do certificado';
$string['coursehours'] = 'Carga horária';
$string['coursename'] = 'Nome alternativo do curso';
$string['intro'] = 'Introdução';
$string['printoutcome'] = 'Imprimir resultado (Outcome)';
$string['printdate'] = 'Tipo de data do certificado';

////Date options
$string['issueddate'] = 'Data da emissão';
$string['completiondate'] = 'Data do fim do curso';
$string['datefmt'] = 'Formato da Data';

////Date format options
$string['userdateformat'] = 'Formato definido pelas definições do usuário';

$string['printgrade'] = 'Tipo de nota do certificado';
$string['gradefmt'] = 'Formato da nota';
////Grade format options
$string['gradeletter'] = 'Nota por Conceito';
$string['gradepercent'] = 'Nota por perrcentual';
$string['gradepoints'] = 'Nota por pontos';
$string['coursetimereq'] = 'Minutos mínimos de participação no curso';
$string['addphoto'] = 'Agregar un certificado foto';
$string['addphotox'] = 'Posição Horizontal do foto del participação do certificado';
$string['addphotoy'] = 'Posição Verticale do foto del participação do certificado';
$string['addphotowidth'] = 'Ancho do foto del participação do certificado';
$string['addphotoheight'] = 'Altura do foto del participação do certificado';


////Form options help text

$string['certificatename_help'] = 'Nome do certificado';
$string['certificatetext_help'] = 'Este é o texto que será usado no verso certificado, algums marcadores especiais serão substituidos por variáveis do certificado, como o nome do curos, nome do estudante, notas...
Os marcadores são:

{USERNAME} -> Nome completo do aluno
{COURSENAME} -> Nome compledo do curso (ou o que estiver definido em "Nome Alternativo do Curso")
{GRADE} -> Nota formatada
{DATE} -> Data formatada
{OUTCOME} -> Resultados (Outcomes)
{HOURS} -> Carga horária do curso
{TEACHERS} -> Lista de professores
{IDNUMBER} -> id number
{FIRSTNAME} -> Nome        
{LASTNAME} -> Sobrenome        
{EMAIL} -> E-mail        
{ICQ} -> ICQ        
{SKYPE} -> Skype        
{YAHOO} -> Yahoo messenger        
{AIM} -> AIM        
{MSN} -> MSN        
{PHONE1} -> 1° Número de telefone        
{PHONE2} -> 2° Número de telefone        
{INSTITUTION} -> Instituição        
{DEPARTMENT} -> Departamento        
{ADDRESS} -> Endereço
{CITY} -> Cidade
{COUNTRY} -> País
{URL} -> Home-page
{PROFILE_xxxx} -> Campos personalizados

Para usar campos personalizados deve usar o prefixo "PROFILE_", por exemplo, se criar um campo com a abreviação (shortname) de aniversario, então deve-se usar o marcador
"PROFILE_ANIVERSARIO"
O texto pode ser um HTML básico, com fontes básicas do HTLM, tabelas, mas evitar o uso de posicionamento';

$string['introcertificatetext_help'] = '';
$string['conclucertificatetext_help'] = '';

$string['textposition'] = 'Posicionamento do Texto do Certificado';
$string['textposition_help'] = 'Essas são as coordenadas XY (em milímetros) do texto do certificado';
$string['size'] = 'Tamanho do Certificado';
$string['size_help'] = 'Esse é o tamanho, Largura e Altura (em milímetros) do certificado, o padrão é A4 paisagem';
$string['coursehours_help'] = 'Carga horário do curso';
$string['coursename_help'] = 'Nome alternativo do curso que vai ser impresso no certificado';
$string['userphoto_help'] = 'Esta figura será usada no certificado como la imagen de un usuario';
$string['certificateimage_help'] = 'Esta figura será usada no certificado';

$string['printoutcome_help'] = 'Você pode escolher qualquer resultado (outcome) definido neste curso. Será impresso o nome do resultado e o resultado recebido  pelo usuário. Um exemplo poderia ser: Resultado: Proficiente.';

$string['printdate_help'] = 'Esta é a data de envío que será impressa, você pose escolher entre a data que o aluno completou o curso, ou a data de emissão do certificado.
Também pode-se escolher a data que uma certa atividade foi corrigida, se em algum dos casos o aluno não tiver a data, então a data de emissão será usada.';
$string['datefmt_help'] = 'Coloque um formato de data válido aceito pelo PHP (http://www.php.net/manual/pt_BR/function.strftime.php). ou deixe-o em branco para usar o valor de formatação padrão definido pela a configuração de idioma do usuário.';
$string['gradefmt_help'] = 'Pode-se escolher o formato da nota que são:

Nota por percentual: Imprime a nota como um percentual.
Nota pot pontos: Imprime a nota por pontos, o valor da nota tirada.
Nota por conceito: Imprime o conceito relacionado a nota obtida (A, A+, B, ...).';

$string['coursetimereq_help'] = 'Coloque o tempo minimo de participação (em minutos) que um aluno deve ter para conseguir obter o certificado';
$string['addphoto_help'] = 'Si elige esta opción, los estudiantes se ven obligados a subir su foto para obtener su certificado.';


////Form Sections
$string['issueoptions'] = 'Opcões de Emissão';
$string['designoptions'] = 'Opções de Design';

//Admin settings page
$string['defaultwidth'] = 'Largura Padrão';
$string['defaultheight'] = 'Altura Padrão';
$string['defaultcertificatetextx'] = 'Posição Horizontal padrão do texto do certificado';
$string['defaultcertificatetexty'] = 'Posição Vertical padrão do texto do certificado';
$string['defaultintrocertificatetextx'] = '';
$string['defaultintrocertificatetexty'] = '';
$string['defaultconclucertificatetextx'] = '';
$string['defaultconclucertificatetexty'] = '';


$string['defaultaddphotox'] = 'Posição Horizontal padrão do foto del participação do certificado';
$string['defaultaddphotoy'] = 'Posição Vertical padrão do foto del participação do certificado';
$string['defaultaddphotowidth'] = 'Ancho padrão do foto del participação do certificado';
$string['defaultaddphotoheight'] = 'Altura padrão do foto del participação do certificado';

$string['link'] = '';

//Erros
$string['filenotfound'] = 'Arquivo não encontrado: {$a}';
$string['invalidcode'] = '';
$string['cantdeleteissue'] = 'Ocorreu um erro ao remover os certificados emitidos';

//Adding photo certificate page
$string['certificateaddphoto'] = '';
$string['unknowchar'] = '';
$string['emailvalidationphotosubject'] = '';
$string['emailvalidationphotolink'] = '';
$string['emailvalidationphotolinkhtml'] = '';

//Pending certificate page
$string['pendingcertificate'] = '';
$string['pending'] = '';

//Save certificate page
$string['savecertificate'] = '';
$string['archivefinished'] = '';
$string['archiveerror'] = '';

//Validation certificate page
$string['validationcertificate'] = '';
$string['emailvalidatedphotosubject'] = '';
$string['emailvalidatedphotolink'] = '';
$string['emailvalidatedphotolink'] = '';
$string['refresh'] = '';
$string['photovalidated'] = '';
$string['permissiondenied'] = '';

//Menu
$string['validationlink'] = '';
$string['verificationlink'] = '';
$string['archivelink'] = '';

//Settings
$string['certlifetime'] = 'Manter os certificados emitidos por: (em Mêses)';
$string['certlifetime_help'] = 'Está opção especifica por quanto tempo deve ser guardado um certificado emitido. Certificados emitidos mais velhos que o tempo determinado nesta opção será autmaticamente removidos.';
$string['neverdeleteoption'] = 'Nunca remover';

$string['variablesoptions'] = 'Outras Opções';
$string['getcertificate'] = 'Obter o Certificado';
$string['verifycertificate'] = 'Verificar Certificado';

$string['customcertificate'] = '';
$string['customcertificate:addinstance'] = '';
$string['customcertificate:manage'] = '';
$string['customcertificate:printteacher'] = '';

$string['customcertificate:student'] = '';
$string['customcertificate:view'] = '';




