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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="150" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;SEPISS - Pesquisar</td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" onclick="document.getElementById('divBuscaObra').style.visibility='hidden'" title="Fechar" /></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<form method="post"  name="frmBuscaObra" id="frmBuscaObra">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<table width="100%">
					<tr>
						<td>
							<input name="txtBuscaNome" id="txtBuscaNome" type="text" class="texto" size="39" style="background-color:#255b8f; color:#FFFFFF; text-transform:uppercase"  >
							<input name="btBuscaObra" type="submit" value="" id="btBuscarCliente" title="Buscar">
						</td>
					</tr>
					<tr>
						<td background="img/busca_fundo.jpg" align="center">
							<select name="CODOBRA" id="CODOBRA" size="13" style="width:277px; background-color:#255b8f;color:#FFFFFF;" class="combo" 
							onchange="document.getElementById('frmBuscaObra').submit();">
								<?php 
								if(isset($_POST['txtBuscaNome']))
									{
										$nome = $_POST['txtBuscaNome'];
										$sql_nome_obra  = mysql_query("
											SELECT 
												codigo,
												obra
											FROM
												obras
											WHERE
												obra LIKE '%$nome'
											ORDER BY 
												obra
										");
									while(list($codigo,$obra) = mysql_fetch_array($sql_nome_obra)){
										if($obra){
											echo "<option value=\"$codigo\">$obra</option>";
										}
									}
								}
							?>
							</select>
						</td>
					</tr>
				</table>
			</form>
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>