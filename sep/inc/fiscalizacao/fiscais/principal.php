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
<fieldset><legend>Fiscais</legend>
<form method="post">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<table width="100%" class="form">
		<tr>
		  <td width="7%"><input type="submit" class="botao" name="btCadastrar" value="Cadastrar" /></td>
			<td width="86%"><input type="submit" class="botao" name="btBuscar" value="Buscar" /><td width="7%">
		</tr>
	</table>
</form>
</fieldset>
<?php
	if($_POST["btCadastrar"]=="Cadastrar")
		{
			include("inc/fiscalizacao/fiscais/cadastrar.php");
		}
	elseif($_POST["btBuscar"]=="Buscar")
		{
			include("inc/fiscalizacao/fiscais/buscar.php");
		}	
?>