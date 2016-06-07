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
	// recebe o codigo que veio da visualizacao e preenche o form para alteracao dos dados
	$codinfracao=$_POST["txtCodinfracao"];
	$sql=mysql_query("SELECT tituloinfracao, descricao, fundamentacaolegal FROM processosfiscais_infracoes WHERE codigo='$codinfracao'");
	list($tituloinfracao,$descricaoinfracao,$fundamentacaolegal)=mysql_fetch_array($sql);
		
?>
<form method="post">
	<table>
		<tr>
			<td width="160">Titulo da infração:</td>
			<td><input type="text" class="texto" name="txtTituloInfracao" maxlength="100" size="53" value="<?php echo $tituloinfracao; ?>" /></td>
		</tr>
		<tr>
			<td valign="top">Descrição:</td>
			<td><textarea class="texto" name="txtDescricao" cols="50" rows="5"><?php echo $descricaoinfracao; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top">Fundamentação legal:</td>
		  <td><textarea class="texto" name="txtFundamentacaoLegal" cols="50" rows="5"><?php echo $fundamentacaolegal; ?></textarea></td>
		</tr>
		<?php
			if(!$codinfracao)
				{echo "<tr><td colspan=\"2\"><input type=\"submit\" class=\"botao\" name=\"btCadastrar\" value=\"Cadastrar\" /></td></tr>";}
			else
				{echo "<tr><td colspan=\"2\"><input type=\"submit\" class=\"botao\" name=\"btEditar\" value=\"Editar\" /></td></tr>";}
		?>
	</table>
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao" value="legislacao" />
	<input type="hidden" name="txtCodinfracao" value="<?php echo $codinfracao; ?>" />
	<input type="hidden" name="btVisualizar" value="Visualizar" />
</form>