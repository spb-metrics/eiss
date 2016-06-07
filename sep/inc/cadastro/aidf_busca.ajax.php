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
<!--Cria a tela de controle do AIDF-->
<fieldset style="margin-left:10px; margin-right:10px;"><legend>Resultado</legend>
<?php
	require_once('../conect.php');
	require_once('../../funcoes/util.php');
	require_once '../nocache.php';
	/*if($_GET['txtCodAidf']){
		echo "sd";
		require_once("aidf_liberar.php");		
	}*/
	$cnpj    = trataString($_GET['txtCNPJ']);
	$emissor = trataString($_GET['txtEmissor']);
	$estado  = trataString($_GET['cmbEstado']);
	$data1   = DataMysql(trataString($_GET['txtData1']));
	$data2   = DataMysql(trataString($_GET['txtData2']));
	//print_array($_GET);
	
	$str_where = " cadastro.razaosocial LIKE '$emissor%'";
	
	if($cnpj){
		$str_where .= " AND cadastro.cpf = '$cnpj' OR cadastro.cnpj='$cnpj' ";
	}
	if($estado){
		$str_where .= " AND aidf_solicitacoes.confirmar = '$estado'";
	}
	if($data1) {
		$str_where .= "AND aidf_solicitacoes.data >= '$data1'";
	}
	if($data2) {
		$str_where .= "AND aidf_solicitacoes.data <= '$data2'";
	}
	
	$query = ("
		SELECT 
			aidf_solicitacoes.codigo,
			cadastro.codigo,
			cadastro.nome,
			if(cadastro.cnpj <>'', cadastro.cnpj , cadastro.cpf) as cnpjcpf,
			aidf_solicitacoes.data ,
			aidf_solicitacoes.confirmar
		FROM 
			cadastro
		INNER JOIN 
			aidf_solicitacoes ON aidf_solicitacoes.codemissor = cadastro.codigo 
		WHERE  
			$str_where
		ORDER BY 
			aidf_solicitacoes.data 
		DESC
	");
	
	$sql = Paginacao($query,'frmAidf','divaidf',12);
	
if(mysql_num_rows($sql)){
?>
<table align="left" width="100%" cellpadding="0" cellspacing="1">
    <tr bgcolor="#999999">
        <td width="38%" align="center" bgcolor="#999999">Prestador</td>
      <td width="19%" align="center">CNPJ/CPF</td>
      <td width="17%" align="center">AIDF</td>
      <td width="11%" align="center">Liberado</td>
      <td width="15%" align="center"></td>	
    </tr>
    <?php		
    while(list($codaidf,$codemissor,$emissores_nome, $emissores_cnpjcpf, $aidf_data, $aidf_confirmar) = mysql_fetch_array($sql)){
		switch($aidf_confirmar){
			case "s": $str_aidf_confirmar = "Sim"; break;
			case "n": $str_aidf_confirmar = "Não"; break;
		}
	?>
    <tr>
        <td align="left" bgcolor="FFFFFF">&nbsp;<?php echo $emissores_nome; ?></td>
        <td align="center" bgcolor="FFFFFF"><?php echo $emissores_cnpjcpf; ?></td>
        <td align="center" bgcolor="FFFFFF"><?php echo DataPt($aidf_data); ?></td>
        <td align="center" bgcolor="FFFFFF"><?php echo $str_aidf_confirmar; ?></td>
        <td align="center">
          <input type="button" name="btVisualizar" value="Visualizar" class="botao" 
          onClick="document.getElementById('hdCodAidf').value='<?php echo $codaidf;?>';
          acessoAjax('inc/cadastro/aidf_liberar.ajax.php','frmAidf','divaidf')" />
        </td>
    </tr>
 <?php
        } // fim while
?>
<input type="hidden" name="hdCodAidf" id="hdCodAidf" />
</table>
<?php
}else{
	echo "<center>Não há solitações</center>";
}
?>
</fieldset>