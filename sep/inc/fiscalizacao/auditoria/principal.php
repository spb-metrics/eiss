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
<form method="post" name="formAuditoria" id="formAuditoria">
<table width="100%" height="120" border="0">
	<tr>
		<td valign="top">
			<fieldset><legend>Pesquisa</legend>
			<table border="0">
				<tr>
					<td>
						Tipo de Inconsistência
					</td>	
					<td colspan="3">
						<select name="cmbInconsistencias" id="cmbInconsistencias">						
							<option value="1">Notas Duplicadas</option>
							<option value="2">Sequênciamento de notas</option>
						</select>
					</td>	
				</tr>	
				<tr>
					<td>
						Prestador
					</td>	
					<td colspan="3">
						<input type="text" class="texto" name="txtPrestador" id="txtPrestador" size="50">
					</td>	
				</tr>				
				<tr>
					<td>
						Data Ini
					</td>						
					<td>
						<input type="text" class="texto" name="txtDataIni" id="txtDataIni" size="10" maxlength="10">
					</td>	
					<td>
						Data Fim
					</td>	
					<td>
						<input type="text" class="texto" name="txtDataFim" id="txtDataFim" size="10" maxlength="10">
					</td>	
				</tr>	
				<tr>
					<td colspan="4" align="left" >
						<input type="button" class="botao" name="btBuscarInconsistencias" id="btBuscarInconsistencias" value="Pesquisar" onClick="acessoAjax('inc/fiscalizacao/auditoria/pesquisa.ajax.php','formAuditoria','container',true);">
					</td>	
				</tr>						
			</table>
			
			<div id="container" align="center">
			
			</div>
			
			</fieldset>			
		</td>
	</tr>
</table>
</form>
