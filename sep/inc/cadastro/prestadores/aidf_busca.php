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
	
	if($_GET['txtCodAidf']){
		require_once("aidf_liberar.php");
		echo "utafoka modafoka";
	}
	
	$cnpj    = $_GET['txtCNPJ'];
	$emissor = $_GET['txtEmissor'];
	if($cnpj){
		$str_where .= " AND emissores.razaosocial = '$cnpj'";
	}
	if($emissor){
		$str_where .= " AND emissores.cnpjcpf = '$emissor'";
	}
	$query = ("SELECT aidf_solicitacoes.codigo,emissores.codigo,emissores.nome, emissores.cnpjcpf, aidf_solicitacoes.data FROM emissores INNER JOIN aidf_solicitacoes ON aidf_solicitacoes.codemissor = emissores.codigo WHERE aidf_solicitacoes.confirmar = 'n' $str_where ORDER BY aidf_solicitacoes.data DESC");
	$sql = Paginacao($query,'frmAidf','divaidf',18);
if(mysql_num_rows($sql)){
?>
<table align="left" width="100%" cellpadding="0" cellspacing="1">
    <tr bgcolor="#999999">
        <td width="40%" align="center" bgcolor="#999999">Prestador</td>
        <td width="20%" align="center">CNPJ/CPF</td>
        <td width="15%" align="center">AIDF</td>
        <td width="15%" align="center"></td>	
    </tr>
    <?php		
    while(list($codaidf,$codemissor,$emissores_nome, $emissores_cnpjcpf, $aidf_data) = mysql_fetch_array($sql))
        {?>
    <tr>
        <td align="left" bgcolor="FFFFFF">&nbsp;<?php echo $emissores_nome; ?></td>
        <td align="center" bgcolor="FFFFFF"><?php echo $emissores_cnpjcpf; ?></td>
        <td align="center" bgcolor="FFFFFF"><?php echo DataPt($aidf_data); ?></td>
        <td align="center">
          <input type="submit" name="btVisualizar" value="Visualizar" class="botao" 
          onClick="document.getElementById('hdCodAidf').value='<?php echo $codaidf;?>';
          acessoAjax('inc/prestadores/aidf_liberar.ajax.php','frmAidf','divaidf')" />
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