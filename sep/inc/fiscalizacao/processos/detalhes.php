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
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Detalhes</legend>
<form>
<?php
	//PEGA A INFORMACAO DE QUAL DADO DO BANCO FOI REQUERIDO OS DETALHES USANDO O CONTADOR
	$x=$_POST["contador"];
	
	for($i=0; $i < $x; $i++)
	{
		if($_POST["txtNroProcesso".$i]){
			$numero=$_POST["txtNroProcesso".$i];
		}
		if($_POST["txtAnoProcesso".$i]){
			$anoprocesso=$_POST["txtAnoProcesso".$i];
		}
	}
?>
<table width="100%">
	<tr bgcolor='#999999'>
	 <td align="center">Nº/Ano</td>
	 <td align="center">Nome/Razão</td>
	 <td align="center">Data Inicial</td>
	 <td align="center">Data Final</td>
	 <td align="center">Situação</td>
	 <td align="center">Cancelado</td>
	 <td align="center">Observações</td>
	</tr>
<?php 
	//TESTA AS INFORMACOES PARA PEGAR OS DADOS CORRETO
	$sql = mysql_query("SELECT processosfiscais.situacao, 
                        processosfiscais.data_inicial,
                        processosfiscais.data_final,
                        processosfiscais.cancelado,
                        processosfiscais.observacoes,
                        cadastro.razaosocial
                        FROM processosfiscais
                        INNER JOIN cadastro
                        ON processosfiscais.codemissor=cadastro.codigo
                        WHERE processosfiscais.nroprocesso = '$numero'
                        AND processosfiscais.anoprocesso = '$anoprocesso'");

	while(list($situacao, $data_inicial, $data_final, $cancelado, $observacoes, $razaosocial) = mysql_fetch_array($sql))
		{ 
			//TRANSFORMA O RESULTADO PARA NAO DEIXAR SIGLAS
			$situacao_tip = $situacao;
			switch($situacao){
			case 'A': $situacao = "Aberto"; break;
			case 'C': $situacao = "Concluído"; break;
			}
				
			switch($cancelado){
			case 'N': $cancelado = "Não"; break;
			case 'S': $cancelado = "Sim"; break;
			}
	
			
			//TRANSFORMA A DATA PARA PADRAO
			$data_inicial = DataPt($data_inicial);
			$data_final = DataPt($data_final);
			
			//JOGA OS DADOS NA TABELA
		print("
				<tr bgcolor='#FFFFFF'>
				 <td align=center>$numero/$anoprocesso</td>
				 <td align=center>$razaosocial</td>
				 <td align=center>$data_inicial</td>
				 <td align=center>$data_final</td>
				 <td align=center>$situacao</td>
				 <td align=center>$cancelado</td>
				 <td align=center>$observacoes</td>
				</tr>
			");
		} 
?>
</table>
</form>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Ações</legend>
 <form id="frmAcao" onsubmit="return ConfirmaAcaoProcesso(cmbAcoes.value)" method="post">
  <table>
   <tr>
    <td>Ações:</td>
	<td><?php if($situacao_tip == "A"){?>
		<select id="cmbAcoes" name="cmbAcoes" class="combo">
       	<option value="alterar">Alterar</option>
       	<option value="cancelar">Cancelar</option>
		<option value="estornarcancelamento">Estornar Cancelamento</option>
		<option value="visualizar">Visualizar</option>
		<option value="emitirtermoinicio">Termo de Início</option>
        <option value="termoentregarecebimento">Termo de Recebimento de Docs.</option>
		<option value="termoentregadocumentos">Termo de Entrega de Docs.</option>
        <option value="intimacao">Intimação</option>
		<option value="apreensaodocumentos">Apreensao de Documentos</option>
		<option value="termoprorrogacao">Termo de Prorrogação</option>
		<option value="homologacao">Homologação</option>
		<option value="planilhahomolagacao">Planilha de Homologação</option>
		<option value="documentosautuacao">Documentos de Autuação</option>
		<option value="datacientevencimento">Data Ciente e Vencimento</option>
		<option value="guiasparcelamento">Guias e Parcelamento</option>
		<option value="dividaativa">Dívida Ativa</option>
		<option value="fechamento">Fechamento</option>
     	</select>
		<?php }else{  ?>
		<select id="cmbAcoes" name="cmbAcoes" class="combo">
		<option value="visualizar">Visualizar</option>
		<option value="intimacao">Intimação</option>
        <option value="termoentregarecebimento">Termo de Recebimento de Docs.</option>
		<option value="termoentregadocumentos">Termo de Entrega de Docs.</option>
		<option value="apreensaodocumentos">Apreensao de Documentos</option>
		<option value="termoprorrogacao">Termo de Prorrogação</option>
		<option value="homologacao">Homologação</option>
		<option value="planilhahomolagacao">Planilha de Homologação</option>
		<option value="documentosautuacao">Documentos de Autuação</option>
		<option value="datacientevencimento">Data Ciente e Vencimento</option>
		<option value="guiasparcelamento">Guias e Parcelamento</option>
		<option value="dividaativa">Dívida Ativa</option>
     	</select>
	<?php }//fim if se cancelado ?>
	</td>
	<td><input type="submit" name="btnSelecionar" class="botao" value="Entrar" onclick="document.getElementById('txtAcao2').value=document.getElementById('cmbAcoes').value;" /></td>
   </tr>
  </table>
  <table>
	  <tr>
		  <td>
			  <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			  <input type="hidden" name="txtAcao" id="txtAcao2" />
			  <input type="hidden" value="<?php echo $numero; ?>" name="txtNroProcesso" />
			  <input type="hidden" value="<?php echo $anoprocesso; ?>" name="txtAnoProcesso"/>
			  <input type="submit" value="Voltar" name="btmVoltar" class="botao"/>
		  </td>
	  </tr>
  </table>
</form>  
</fieldset>