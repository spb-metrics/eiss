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
<script>
  function CancelaNota(codnota,msg)
  {	
	if(confirm(msg)){
		document.getElementById('hdPrimeiro').value=1; //mantem a paginacao na mesma pagina
		document.getElementById('txtCodigoCancela').value=codnota;
		acessoAjax('inc/nfe/pesquisar_resultado.ajax.php','frmNfe','divResultado');
		alert('Nota cancelada!');
	}
  }			
</script>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;NFe - Pesquisa </td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<form method="post" name="frmNfe" id="frmNfe" onsubmit="return false">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"]; ?>" />
				<fieldset style="width:800px">
				<legend>Pesquisar Nota</legend>
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td align="left" width="30%">Número da Nota</td>
						<td align="left" width="70%">
							<input name="txtNumeroNota" type="text" size="10" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left">Código de Verificação</td>
						<td align="left">
							<input name="txtCodigoVerificacao" type="text" size="10" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left">Tomador - CNPJ/CPF</td>
						<td align="left">
							<input name="txtCNPJ" id="txtCNPJ" type="text" size="20" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left" colspan="2">
							<input name="btPesquisar" type="submit" value="Pesquisar" class="botao" onclick="
							acessoAjax('inc/nfe/pesquisar_resultado.ajax.php','frmNfe','divResultado')">
						</td>
					</tr>
				</table>
				</fieldset>
				<div id="divResultado"></div>
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
