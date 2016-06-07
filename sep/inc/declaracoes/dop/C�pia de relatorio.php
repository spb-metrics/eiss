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
$ativos = mysql_query("SELECT nome, razaosocial, cnpj, municipio, uf, estado, responsavel_nome, diretor_nome, codigo FROM orgaospublicos WHERE estado ='A' ORDER BY nome");
$inativos = mysql_query("SELECT nome, razaosocial, cnpj, municipio, uf, estado, responsavel_nome, diretor_nome, codigo FROM orgaospublicos WHERE estado ='I' ORDER BY nome");
$nl = mysql_query("SELECT nome, razaosocial, cnpj, municipio, uf, estado, responsavel_nome, diretor_nome, codigo FROM orgaospublicos WHERE estado ='NL' ORDER BY nome");
$numativos = mysql_num_rows($ativos);
$numinativos = mysql_num_rows($inativos);
$numnl = mysql_num_rows($nl);
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="850" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;&Oacute;rg&atilde;os P&uacute;blicos - Relatório</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="left">
		<fieldset style="width:850px"><legend>Relatórios de Órgãos Públicos:</legend>
			<table width="100%">
				<tr>
					<td width="250">
						Total de Órgãos Públicos Ativos:
					</td>
					<td>
						<?php echo "$numativos"; ?>
					</td>
				</tr>
				<tr>
					<td>
						Total de Órgãos Públicos Inativos:
					</td>
					<td>
						<?php echo "$numinativos"; ?>
					</td>
				</tr>
				<tr>
					<td>
						Total de Órgãos Públicos Não Liberados:
					</td>
					<td>
						<?php echo "$numnl"; ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset style="width:850px"><legend>Buscar:</legend>
			<form method="post" id="frmRelatorio" name="frmRelatorio">
			<input type="hidden" name="include" id="include" value="<?php echo $_POST['include']; ?>">
				<table width="100%" border="0" cellpadding="0"align="center">
					<tr>
						<td width="100">
							Nome:
						</td>
						<td>
							<input type="text" name="txtNome" class="texto" size="30" maxlength="30">
							<input type="button" name="btnNome" value="Consulta" class="botao" onclick="acessoAjax('inc/orgaospublicos/relatorios/busca_estado.ajax.php','frmRelatorio','divBuscar');" >
						</td>
					</tr>								
					<tr>
						<td colspan="2"><br />					
							<input type="button" name="btnInativos" value="Inativos" class="botao" onclick="acessoAjax('inc/orgaospublicos/relatorios/busca_inativosestado.ajax.php','frmRelatorio','divBuscar');"/>
							<input type="button" name="btnAtivos" value="Ativos" class="botao" onclick="acessoAjax('inc/orgaospublicos/relatorios/busca_ativosestado.ajax.php','frmRelatorio','divBuscar');"/>
							<input type="button" name="btnNL" value="Não Liberados" class="botao" onclick="acessoAjax('inc/orgaospublicos/relatorios/busca_nlestado.ajax.php','frmRelatorio','divBuscar');"/>				
						</td>
					</tr>
				</table>
			
			</form>
		</fieldset>
		<div id="divBuscar"></div>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>