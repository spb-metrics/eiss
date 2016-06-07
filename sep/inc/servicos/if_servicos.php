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

	if($_POST['COD']){
		include("if_servico_editar.php");
		
	}else{
		if($_POST['excluir']){
			$codigo = $_POST['excluir'];
			//Mensagem('Serviço excluido!');
			mysql_query("DELETE FROM dif_contas WHERE codigo='$codigo'");
			add_logs('Excluiu uma conta de Insituição Financeira');
			Mensagem('Serviço excluído!');
			unset($codigo);
		}
	?>
	<form name="frmBusca" method="post" id="frmBusca" onsubmit="acessoAjax('inc/servicos/if_servico_busca.ajax.php','frmBusca','dvResult'); return false;">
	<fieldset style="margin-left:10px; margin-right:10px;">
		<legend>Filtros</legend>
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<table width="100%">
				<tr>
					<td align="left">Conta</td>
			    	<td align="left">
			    		<input type="text" size="15"  name="txtBuscaConta" id="txtBuscaConta" class="texto" />
			    	</td>
			    </tr>
				<tr>
					<td>Descri&ccedil;&atilde;o</td>
				  	<td colspan="3"><input type="text" size="50" maxlength="50" name="txtBuscaDescricao" class="texto" /></td>
				</tr>
				<tr>
				  <td>Estado</td>
				  <td colspan="">
					<select name="cmbEstado" class="combo">
						<option value=""></option>
						<option value="A">Ativo</option>
						<option value="I">Inativo</option>
					</select>
				  </td>
			  </tr>
				<tr>
				  <td><input type="submit" name="btFiltro" value="Buscar" class="botao" /></td>
				  <td><input type="reset" name="" value="Limpar" class="botao" /></td>
				  <td colspan="2">&nbsp;</td>
			  </tr>
			</table>
	</fieldset>
	<?php
		if($_POST["btFiltro"] == "Pesquisar"){
			include("if_servicos_busca.php");
		}
	}
	?>
	<div id="dvResult"></div>
	</form>