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
<fieldset style="margin-left:7px; margin-right:7px;">
	<legend>Infra&ccedil;&otilde;es</legend>	
	<form method="post">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="legislacao" />
		<table align="center">
			<tr>
				<td><input type="submit" class="botao" name="btVisualizar" value="Visualizar" /></td>
				<td><input type="submit" class="botao" name="btIncluir" value="Incluir" /></td>
			</tr>
		</table>
	</form>
	<?php
		if($_POST["btVisualizar"]=="Visualizar")
			{
				include("inc/fiscalizacao/processos/legislacao_visualizar.php");
			}
		elseif($_POST["btIncluir"]=="Incluir")
			{
				include("inc/fiscalizacao/processos/legislacao_form.php");
			}	
	?>
</fieldset>	