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
	include("../../conect.php");
	include("../../../funcoes/util.php");
	
	$tipo=$_GET['cmbInconsistencias'];	
	$prestador=$_GET['txtPrestador'];
	$datainicial=$_GET['txtDataIni'];
	$datafinal=$_GET['txtDataFim'];

	$tipo==2?$tipos='sequencia':$tipos='duplicadas';	
	$datainicial = DataMysql($datainicial);
	$datafinal = DataMysql($datafinal);
	
	if($str){$str.="AND emissor.nome LIKE '{$prestador}%'";}
	else{$str = "AND emissor.nome LIKE '{$prestador}%'";}
	
	if($datainicial){$str.=" AND SUBSTRING(inc.datahorainconsistencia,1,10)>='2010-02-10'";}
	if($datafinal){$str.=" AND SUBSTRING(inc.datahorainconsistencia,1,10)<='2010-02-15'";}
	
	switch ($tipo){		
		// inconsistencias de notas duplicadas	
		case 1:
		$query="SELECT emissor.nome,inc.nota_nro, SUBSTRING(inc.datahorainconsistencia,1,10), SUBSTRING(inc.datahorainconsistencia,11,15), inc.estado FROM inconsistencias as inc
 					INNER JOIN cadastro as emissor ON emissor.codigo=inc.codemissor  
					WHERE tipo='{$tipos}' {$str}";
		break;
		// inconsistencias de sequenciamento de notas
		case 2:			 
		$query="SELECT emissor.nome,inc.nota_nro, SUBSTRING(inc.datahorainconsistencia,1,10), SUBSTRING(inc.datahorainconsistencia,11,15), inc.estado FROM inconsistencias as inc
 					INNER JOIN cadastro as emissor ON emissor.codigo=inc.codemissor  
					WHERE tipo='{$tipos}' {$str}";
		break;
	} // fim switch
	
    $sql_auditoria=Paginacao($query,'formAuditoria','container',10);

		if(mysql_num_rows($sql_auditoria)>0){
			echo "<table width=\"650\">
					<tr bgcolor=\"#999999\">
                     <td width=\"250\" align=\"center\">Nome</td>
                     <td width=\"65\" align=\"center\">N° de notas</td>
					 <td width=\"80\" align=\"center\">Data realizada</td>
					 <td width=\"90\" align=\"center\">Horário realizado</td>
					 <td width=\"70\" align=\"center\">Estado</td>
					</tr>";
			while(list($nome,$nro,$data,$hora,$estado)=mysql_fetch_array($sql_auditoria)){
					$data = DataPt($data);
					switch($estado){
					case "A": $estado="Ativo"; break;
					case "I": $estado="Inativo"; break;
					}
					echo "
                     <tr bgcolor=\"#FFFFFF\">
                      <td align=\"center\">$nome</td>
                      <td align=\"center\">$nro</td>
                      <td align=\"center\">$data</td>
                      <td align=\"center\">$hora</td>
                      <td align=\"center\">$estado</td>
                     </tr>
					";
			}
			echo "</table>";
		}else{
			echo "Sem Resultados!";
		}?>