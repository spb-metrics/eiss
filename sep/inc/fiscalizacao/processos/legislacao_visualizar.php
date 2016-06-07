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
	// recebe os dados
	$titulo=strip_tags(addslashes($_POST["txtTituloInfracao"]));
	$descricao=strip_tags(addslashes($_POST["txtDescricao"]));
	$fundamentacao=strip_tags(addslashes($_POST["txtFundamentacaoLegal"]));
	$codinfracao=$_POST["txtCodinfracao"];
	
	// faz o cadastro/alteracao
	if($_POST["btCadastrar"]=="Cadastrar")
		{
			//faz o insert no banco
			$ano=date("Y");
			$sql=mysql_query("SELECT MAX(nroinfracao) FROM processosfiscais_infracoes WHERE anoinfracao='$ano'");
			list($nroinfracao)=mysql_fetch_array($sql);
			$nroinfracao++;
			
			mysql_query("INSERT INTO processosfiscais_infracoes SET nroinfracao='$nroinfracao', anoinfracao='$ano', tituloinfracao='$titulo', descricao='$descricao', fundamentacaolegal='$fundamentacao'");
			add_logs('Inseriu uma Infração de um Processo Fiscal');		
			Mensagem("Infração cadastrada com sucesso!");
		}
	elseif($_POST["btEditar"]=="Editar")
		{
			// faz o update no banco
			mysql_query("UPDATE processosfiscais_infracoes SET tituloinfracao='$titulo', descricao='$descricao', fundamentacaolegal='$fundamentacao' WHERE codigo='$codinfracao'");
			add_logs('Atualizou uma Infração de um Processo Fiscal');		
			Mensagem("Infração editada com sucesso!");
		}
?>				
<form method="post">	
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao" value="legislacao" />
	<?php
	$sql=mysql_query("SELECT codigo, nroinfracao, anoinfracao, tituloinfracao, descricao, fundamentacaolegal FROM processosfiscais_infracoes");

	if(mysql_num_rows($sql) == 0){
		echo "<center><b>Infrações não cadastradas</b></center>";
	}else{
	?>
	<div style="height:500px; overflow:auto">	
		<table width="100%">
			<tr bgcolor="#999999">
				<td>Infração</td>
				<td>T&iacute;tulo</td>
				<td>Descri&ccedil;&atilde;o</td>
				<td>Fundamentação legal</td>
				<td></td>
			</tr>
			<?php
					while(list($codinfracao,$nroinfracao,$anoinfracao,$tituloinfracao,$descricao,$fundamentacaolegal) = mysql_fetch_array($sql))
						{
							echo "
								<tr bgcolor=\"#FFFFFF\">	
									<td>$nroinfracao/$anoinfracao</td>
									<td>$tituloinfracao</td>
									<td>$descricao</td>
									<td>$fundamentacaolegal</td>
									<td><input type=\"submit\" class=\"botao\" name=\"btAletrar\" value=\"Alterar\" onClick=\"document.getElementById('txtCodinfracao').value='$codinfracao'\" /></td>
								</tr>
							";
					}
			?>
		</table>
	</div>
	<?php
	}
	?>
	<input type="hidden" name="txtCodinfracao" id="txtCodinfracao" />
	<input type="hidden" name="btIncluir" value="Incluir" />		
</form>	