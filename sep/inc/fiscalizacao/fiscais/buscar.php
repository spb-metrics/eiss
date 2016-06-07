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
<fieldset><legend>Procurar Fiscais</legend>	
	<form method="post">
		<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>" />
		<table width="100%">
			<tr>
				<td width="5%">Fiscal:</td>
				<td width="12%"><input type="text" class="texto" name="txtFiscal" /></td>
			  <td width="83%"><input type="submit" class="botao" name="btBuscaFiscal" value="Buscar" /></td>
			</tr>
		</table>
		<input type="hidden" name="btBuscar" value="Buscar" />
	</form>
	<?php
		if($_POST["btBuscaFiscal"] == "Buscar")
			{
				// faz a busca e exibe os resultados em uma table
				$fiscal=strip_tags(addslashes($_POST["txtFiscal"]));
				$sql=mysql_query("SELECT nome, codigo FROM fiscais WHERE nome LIKE '$fiscal%' AND estado='A'");
				if(mysql_num_rows($sql)>0)
					{
						?>
							<form method="post" onSubmit="return Confirma('Deseja desativar este fiscal?')">	
								<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>" />
								<table align="center" width="100%">
									<tr bgcolor="#999999">
										<td align="center">Fiscal</td>
										<td width="1" align="center">Matrícula</td>
										<td width="1" align="center">Ações</td>
									</tr>
									<?php
										while(list($nomefiscal,$codfiscal)=mysql_fetch_array($sql))
											{
												echo "
													<tr bgcolor=\"#FFFFFF\">
														<td align=\"left\">$nomefiscal</td>
														<td align=\"center\">$codfiscal</td>
														<td align=\"center\">
															<input type=\"submit\" class=\"botao\" name=\"btDesativar\" value=\"Desativar\" onClick=\"document.getElementById('txtFiscalSelecionado').value=$codfiscal\" />
														</td>
													</tr>
												";
											}
									?>
								</table>
								<input type="hidden" name="btBuscar" value="Buscar" />
								<input type="hidden" name="txtFiscalSelecionado" id="txtFiscalSelecionado">
							</form>	
						<?php
					}
				else
					{
						echo "<p align=\"center\">Nenhum resultado encontrado</p>";
					}	
			}
	?>
</fieldset>
<?php
	if($_POST["btDesativar"]=="Desativar")
		{
			$codfiscal = $_POST["txtFiscalSelecionado"];
			mysql_query("UPDATE fiscais SET estado='D' WHERE codigo='$codfiscal'");
			add_logs('Atualizou um Fiscal: Desativado');
			Mensagem("Fiscal desativado com sucesso!");
		}
?>	
	