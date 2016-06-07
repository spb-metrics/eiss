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
	$detalhes=$_POST["txtDetalhes"];
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$acao=$_POST["txtAcao"];
?>
<table width="700" bgcolor="#CCCCCC">
	<tr>
		<td>
			<fieldset style="margin-left:10px; margin-right:10px;"><legend>Processo Fiscal</legend>
			<form method="post">
			<table width="490">
				<tr>
				 <td></td>
				 <td></td>
				</tr>
				<tr>
				 <td width="150">Filtro:</td>
				 <td><select name="cmbFiltro" id="cmbFiltroOrdem" class="combo">
				   <option value="numero">Número</option>
				   <option value="nome">Nome/Razão</option>
				 </select></td>
				  <td>Ordem:</td>
				  <td>
                      <select name="cmbOrdem" id="cmbOrdem" class="combo">
                          <option value="C">Crescente</option>
                          <option value="D" selected="selected">Decrescente</option>
                      </select>
                  </td>
				 <td>Ano:</td>
				 <td>
				  <select name="cmbAno" id="cmbAno" class="combo">
					<option value="">Todos</option>
					<?php
					for($d=(date("Y")); $d>(date("Y")-5); $d--)
							echo "<option value=\"$d\">$d</option>";
					?>
				  </select></td>
				</tr>
				<tr>
				 <td>Classe:</td>
				 <td>
                     <select name="cmbClasse" id="cmbClasse">
                       <option value="6">Contém</option>
                       <option value="1">Menor/Igual</option>
                       <option value="2">Menor</option>
                       <option value="3">Igual</option>
                       <option value="4">Maior/Igual</option>
                       <option value="5">Maior</option>
                     </select>
                 </td>
				 <td> Situação:</td>
				 <td><select name="cmbSituacao" id="cmbSituacao" class="combo">
				   <option value="T">Todos</option>
				   <option value="A">Aberto</option>
				   <option value="C">Concluído</option>
				 </select></td>
				</tr>
				<tr>
				 <td> Busca por:</td>
				 <td colspan="3"><input name="txtBusca" type="text" class="texto" id="txtBusca" value="" size="50" /></td>
				</tr>
			</table>	
			<table width="50%">
				<tr align="center" style="width:1">
				 <td>
				  <input name="btnLimpar" class="botao" type="reset" value="Limpar"/>
				  <input name="btnConsultar" class="botao" type="submit" value="Consultar"/></td>
				</tr>
			</table>
			<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			</form>
			</fieldset>
			<fieldset style="margin-left:10px; margin-right:10px;<?php if($acao=="legislacao"){echo "display:none;";} ?>" >
			<table>
				<tr>
					<td>
						<input name="btLegislacao" type="button" class="botao" onclick="document.getElementById('txtAcao').value='legislacao'; document.getElementById('frmAcao').submit();" value="Infra&ccedil;&otilde;es" />
					</td>
					<td>
						<input name="btnIncluir" class="botao" type="button" value="Incluir" onClick="document.getElementById('txtAcao').value='inserir'; document.getElementById('frmAcao').submit();"/>
					</td>
				</tr>
			</table>
            </fieldset>
			
			<form method="post" id="frmAcao">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao" />
			</form>	
			
			<table width="100%">
				<tr>
					<td>
			
				<?php
                 //ENCAMINHAMENTO DO BOTAO CONSULTAR
				if($_POST["btnConsultar"]=="Consultar"){
					include("inc/fiscalizacao/processos/busca.php");
				}
				elseif($acao=="legislacao"){
					include("inc/fiscalizacao/processos/legislacao.php");
				}
				elseif($acao=="detalhes"){
					include("inc/fiscalizacao/processos/detalhes.php");
				}
				elseif($acao=="alterar"){
					include("inc/fiscalizacao/processos/inserir.php");
				}
				elseif($acao=="cancelar"){
					include("inc/fiscalizacao/processos/cancelar.php");
				}
				elseif($acao=="estornarcancelamento"){
					include("inc/fiscalizacao/processos/estornarcancelamento.php");
				}
				elseif($acao=="visualizar"){
					include("inc/fiscalizacao/processos/visualizar.php");
				}
				elseif($acao=="emitirtermoinicio"){
					include("inc/fiscalizacao/processos/emitir_termo_inicio.php");
				}
				elseif($acao=="intimacao"){
					include("inc/fiscalizacao/processos/intimacao.php");
				}
				elseif($acao=="intimacao_detalhes"){
					include("inc/fiscalizacao/processos/intimacao_detalhes.php");
				}
				elseif($acao=="termoentregadocumentos"){
					include("inc/fiscalizacao/processos/ted.php");
				}
				elseif($acao=="apreensaodocumentos"){
					include("inc/fiscalizacao/processos/apreensao_documentos.php");
				}
				elseif($acao=="termoprorrogacao"){
					include("inc/fiscalizacao/processos/prorrogacao.php");
				}
				elseif($acao=="homologacao"){
					include("inc/fiscalizacao/processos/homologacao.php"); 
				}
				elseif($acao=="planilhahomolagacao"){
					include("inc/fiscalizacao/processos/homologacao_planilha.php"); 
				}
				elseif($acao=="documentosautuacao"){
					include("inc/fiscalizacao/processos/docs_autuacao.php");
				}
				elseif($acao=="documentosautuacao_inserir"){
					include("inc/fiscalizacao/processos/docs_autuacao_inserir.php");
				}
				elseif($acao=="documentosautuacao_inserir_autoinfracao"){
					include("inc/fiscalizacao/processos/docs_autuacao_inserir_autoinfracao.php");
				}
				elseif($acao=="documentosautuacao_alterar"){
					include("inc/fiscalizacao/processos/docs_autuacao_alterar.php");
				}
				elseif($acao=="datacientevencimento"){
					include("inc/fiscalizacao/processos/vencimento.php");
				}
				elseif($acao=="guiasparcelamento"){
					include("inc/fiscalizacao/processos/processo_guias.php");
				}
				elseif($acao=="parcelas"){
					include("inc/fiscalizacao/processos/processos_guias_vizualizar.php");
				}
				elseif($acao=="dividaativa"){
					include("inc/fiscalizacao/processos/divida_ativa.php");
				}
				elseif($acao=="fechamento"){
					include("inc/fiscalizacao/processos/fechamento.php");
				}
				elseif($acao=="inserir_intimacao"){
					include("inc/fiscalizacao/processos/inserir_intimacao.php");
				}
				elseif($acao=="inserir"){
					include('inc/fiscalizacao/processos/inserir.php');
				} 
				elseif($acao=="visualizarautuacao"){
					include('inc/fiscalizacao/processos/docs_autuacao_visualizar.php');
				}
				elseif($acao=="docsprevia"){
					include('inc/fiscalizacao/processos/docs_autuacao_previa.php');
				}
				elseif($acao=="termoentregarecebimento"){
					include('inc/fiscalizacao/processos/termo_entrega_recebimento.php');
				}
					
					
				?>
			</td>
            </tr>
            </table>	
			</fieldset>
		</td>
	</tr>
</table>