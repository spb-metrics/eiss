<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>
<?php 
// conecta ao banco de dados
include("../conect.php");

//busca os dados da prefeitura
$sql=mysql_query("SELECT brasao FROM configuracoes");
list($BRASAO)=mysql_fetch_array($sql);

//busca dados do cadastro
$sql = mysql_query("SELECT codigo, nome, cnpjcpf FROM emissores WHERE codigo = '$CODEMPRESA'");
list($codigo, $empresanome, $empresacnpjcpf) = mysql_fetch_array($sql);

//trata os meses do ano em portugues
$mes = date('m');

switch ($mes){
	case 1: $mes = "janeiro"; break;
	case 2: $mes = "fevereiro"; break;
	case 3: $mes = "maro"; break;
	case 4: $mes = "abril"; break;
	case 5: $mes = "maio"; break;
	case 6: $mes = "junho"; break;
	case 7: $mes = "julho"; break;
	case 8: $mes = "agosto"; break;
	case 9: $mes = "setembro"; break;
	case 10: $mes = "outubro"; break;
	case 11: $mes = "novembro"; break;
	case 12: $mes = "dezembro"; break;
}

//incluindo o arquivo do fpdf
require_once("../../../gerapdf/fpdf.php");

//defininfo a fonte 
!define('FPDF_FONTPATH','../../../gerapdf/font/');

//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
$pdf=new FPDF("P","mm","A4");


//****** CABECALHO DO ARQUIVO
//define a fonte  a ser usada
$pdf->SetFont('arial','',6);													

//define o titulo 
$pdf->SetTitle("PREFEITURA MUNICIPAL $MUNICIPIO");								

//assunto 
$pdf->SetSubject("Sistema NF-e");												

// posicao vertical no caso -1.. e o limite da margem
$pdf->SetY("-1");																
$titulo="PREFEITURA MUNICIPAL DE ".strtoupper($MUNICIPIO)." - Sistema NFe";

//escreve no pdf Cell($w,$h,$txt,$border,$ln,$align,$fill,$link)		
$pdf->Cell(0,5,$titulo,0,0,'L'); 												
$pdf->Cell(0,5,$Link,0,1,'R'); 
$pdf->Cell(0,0,'',1,1,'L');

//faz uma quebra de linha 
$pdf->Ln(8);


//****** CONTEUDO DO ARQUIVO
//titulo
$pdf->SetFont('arial','B',12);		//seta a fonte
$titulo="PREFEITURA DO MUNICÍPIO DE ".strtoupper($MUNICIPIO); 	//texto
$pdf->SetY("25");	//posiciona verticalmente
$pdf->SetX("25"); 	//posiciona horizontalmente
$pdf->MultiCell(0,5,$titulo,0,'C');	//escreve o conteudo function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)

//subtitulo
$pdf->SetFont('arial','',12);		
$subtitulo="SOLICITAÇAO DE DESBLOQUEIO DE ACESSO AO SISTEMA NF-E";
$pdf->SetY("40");	
$pdf->SetX("10"); 	
$pdf->MultiCell(0,5,$subtitulo,0,'C');

//brasao da prefeitura, funcao Image(file,x,y,w,h,type,link)
$pdf->Image("../img/brasoes/$BRASAO",43,17,20,20);


//paragrafos
$pdf->SetFont('arial','',10);
$paragrafo01 = "                                 ".strtoupper($empresanome).", inscrito(a) no CNPJ/CPF, sob n ".$empresacnpjcpf.", informa que efetuou o cadastramento para acesso ao Sistema ISS Digital da Prefeitura Municipal de ".strtoupper($MUNICIPIO).", no site ".$Link." e SOLICITA o seu desbloqueio para emitir NF-e e demais funcionalidades e informaçoes de seu interesse exclusivo.\n
                                 DECLARA conhecer que a senha de acesso ao Sistema ISS Digital  intransferível e que representa a sua assinatura eletrônica.\n
                                ASSUME total responsabilidade decorrente do uso indevido da senha cadastrada no Sistema ISS Digital.";
$pdf->SetY("60");
$pdf->SetX("10"); 
$pdf->MultiCell(0,5,$paragrafo01,0,'L'); 
$pdf->Ln(8); 

//assinatura
setlocale (LC_ALL, 'pt_BR');
$pdf->SetY("120");	
$pdf->SetX("70"); 	
$pdf->MultiCell(0,5,$MUNICIPIO.", ".date("d")." de ".$mes." de ".date("Y").".\n \n ____________________________ \n Assinatura",0,'C');
$pdf->SetFont('arial','',10);		
$pdf->SetY("150");	
$pdf->SetX("10"); 	
$pdf->MultiCell(0,5,"CNPJ/CPF ".$empresacnpjcpf."  -  Cdigo de Verificao: ".$codigo,0,'L');

$paragrafo02 = "A SOLICITAÇÃO DE DESBLOQUEIO DE ACESSO AO SISTEMA ISS Digital devera ser entregue na Prefeitura Municipal. Sem isso, o acesso e informaçoes de interesse exclusivo da pessoa física/jurdica supramencionada, nao pode ser desbloqueada.\n
Apresentar documento original do outorgante com fotografia para possibilitar a conferencia da assinatura pelo servidor responsavel. Para os casos em que o signatario desta Solicitaçao de Desbloqueio de Acesso ao Sistema ISS Digital for procurador, obrigatorio anexar a procuraçao do interessado, autorizando o procurador a representá-lo neste ato, e documento original do outorgante com fotografia para possibilitar a conferencia da assinatura pelo servidor responsável.\n
Esta solicitação tem validade de 60 (sessenta) dias a partir de sua emissão.";
$pdf->SetY("155");
$pdf->SetX("10"); 
$pdf->MultiCell(0,5,$paragrafo02,1,'J'); 
$pdf->Ln(4);
//imprime uma linha
$pdf->Cell(0,3,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,1,'C'); 

$pdf->Cell(0,5,"PROTOCOLO - Desbloqueio da Senha Sistema NF-e Prefeitura Municipal",0,0,'L'); 
$pdf->Ln(); 
$pdf->Cell(0,5,"CPF: ".$empresacnpjcpf,0,0,'L'); 
$pdf->Ln(); 
$pdf->Cell(0,5,"CODIGO DE VERIFICAO: ".$codigo."                                                                 Recebido em ____/____/______",0,0,'L'); 
$pdf->Ln(); 
$pdf->SetY("250");	
$pdf->SetX("70"); 	
$pdf->MultiCell(0,5,"_________________________________ \n Assinatura e carimbo do \n funcionario da Prefeitura Municipal",0,'C');


//imprime a saida do arquivo..
$pdf->Output("arquivo.pdf","I");


?>