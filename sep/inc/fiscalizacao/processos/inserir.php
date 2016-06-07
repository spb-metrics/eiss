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
	//RECEBE OS DADOS DA PAGINA PRINCIPAL
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	
	//RECEBE OS DADOS DESTA MESMA PAGINA
	$abertura=$_POST["cmbAbertura"];
	$codemissor=$_POST["cmbEmissor"];
	$dataini=implode("-",array_reverse(explode("/",$_POST["txtDatainicial"])));
	$datafim=implode("-",array_reverse(explode("/",$_POST["txtDatafinal"])));
	$dataabertura=date("Y-m-d");
	$observacoes=strip_tags(addslashes($_POST["txtObs"]));
	$fiscal1=$_POST["cmbFiscal1"]; 
	$fiscal2=$_POST["cmbFiscal2"]; 
	$fiscal3=$_POST["cmbFiscal3"]; 
	$fiscal4=$_POST["cmbFiscal4"]; 
	$fiscal5=$_POST["cmbFiscal5"]; 
	$btEnviar=$_POST["btEnviar"];
	$btAlterar=$_POST["btAlterar"];
	
	if($acao=="alterar")
		{
			//BUSCA OS DADOS DO PROCESSO PARA FAZER ALTERACAO
			$sql_select=mysql_query("SELECT processosfiscais.codigo,
                                     processosfiscais. nroprocesso,
                                     processosfiscais.anoprocesso,
                                     processosfiscais.codemissor,
                                     processosfiscais.abertura,
                                     processosfiscais.data_inicial,
                                     processosfiscais.data_final,
                                     processosfiscais.observacoes,
                                     cadastro.razaosocial
                                     FROM processosfiscais
                                     INNER JOIN cadastro
                                     ON processosfiscais.codemissor=cadastro.codigo
                                     WHERE processosfiscais.nroprocesso='$nroprocesso'
                                     AND processosfiscais.anoprocesso='$anoprocesso'
                                     AND processosfiscais.cancelado='N'
                                     AND processosfiscais.situacao='A'");
			list($codprocesso,$nroprocesso,$anoprocesso,$codemissor,$abertura,$dataini,$datafim,$observacoes,$razaosocial)=mysql_fetch_array($sql_select);	
			if($abertura=="I"){$open="Individual";}
			else{$open="Geral";}
			$dataini=implode("/",array_reverse(explode("-",$dataini)));
			$datafim=implode("/",array_reverse(explode("-",$datafim)));
			
			
			//BUSCA OS DADOS DOS FISCAIS REPONSAVEIS PELO PROCESSO
			$sql_fiscais=mysql_query("SELECT fiscais.codigo,
                                      fiscais.nome
                                      FROM fiscais
                                      INNER JOIN processosfiscais_fiscais
                                      ON fiscais.codigo=processosfiscais_fiscais.codfiscal
                                      WHERE processosfiscais_fiscais.codprocesso='$codprocesso'
                                      AND fiscais.estado = 'A'
                                      ORDER BY fiscais.codigo");
			$x=0;
			while(list($codfiscal,$nomefiscal)=mysql_fetch_array($sql_fiscais))
				{
					$option[$x]="<option value=\"$codfiscal\">$nomefiscal</option>";
					$x++;
				}
		}							
	
	if($btEnviar=="Enviar")
		{
			//RETORNA O NUMERO DO ULTIMO PROCESSO DO ANOE CORRENTE E GERA O NUMERO DO PROXIMO PROCESSO 
			$ano=date("Y");
			$anoprocesso = $ano;
			$sql=mysql_query("SELECT MAX(nroprocesso) FROM processosfiscais WHERE anoprocesso='$ano'");
			list($nroprocesso)=mysql_fetch_array($sql);
			$nroprocesso++;
			
			//CADASTRA O PROCESSO NO BANCO
			mysql_query("INSERT INTO processosfiscais SET codemissor='$codemissor', nroprocesso='$nroprocesso', anoprocesso='$ano', abertura='$abertura', data_abertura='$dataabertura', data_inicial='$dataini', data_final='$datafim', observacoes='$observacoes', cancelado='N'");
			add_logs('Inseriu um Processo Fiscal');
			
			//CADASTRA OS FISCAIS RESPONSAVEIS PELO PROCESSO
			$sql=mysql_query("SELECT MAX(codigo) FROM processosfiscais");
			list($codprocesso)=mysql_fetch_array($sql);
			if($fiscal1)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal1'");
				}	
			if($fiscal2)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal2'");
				}	
			if($fiscal3)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal3'");
				}	
			if($fiscal4)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal4'");
				}	
			if($fiscal5)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal5'");
				}	
			add_logs('Abriu um Processo Fiscal');
			Mensagem("Processo aberto com sucesso: $nroprocesso/$anoprocesso");
			?>
			<form method="post" id="form">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" value="visualizar" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
			</form>
			<?php
		}// fim do if se incluir
		
	if($btAlterar=="Alterar")
		{
			$abertura=$_POST["cmbAbertura"];
			$codemissor=$_POST["cmbEmissor"];
			$dataini=implode("-",array_reverse(explode("/",$_POST["txtDatainicial"])));
			$datafim=implode("-",array_reverse(explode("/",$_POST["txtDatafinal"])));
			$observacoes=strip_tags(addslashes($_POST["txtObs"]));
			$sql=mysql_query("SELECT codigo FROM processosfiscais WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
			list($codprocesso)=mysql_fetch_array($sql);
            $dataini=implode("-",array_reverse(explode("/",$dataini)));
            $datafim=implode("-",array_reverse(explode("/",$datafim)));
			mysql_query("UPDATE processosfiscais SET abertura='$abertura',
                         codemissor='$codemissor',
                         data_inicial='$dataini',
                         data_final='$datafim',
                         observacoes='$observacoes'
                         WHERE nroprocesso='$nroprocesso'
                         AND anoprocesso='$anoprocesso'");
			add_logs('Atualizou uma Abertura de Processo Fiscal');			 
			mysql_query("DELETE FROM processosfiscais_fiscais WHERE codprocesso='$codprocesso'");
			if($fiscal1)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal1'");
				}	
			if($fiscal2)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal2'");
				}	
			if($fiscal3)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal3'");
				}	
			if($fiscal4)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal4'");
				}	
			if($fiscal5)
				{
					mysql_query("INSERT INTO processosfiscais_fiscais SET codprocesso='$codprocesso', codfiscal='$fiscal5'");
				}	
			add_logs('Alterou uma Abertura de Processo Fiscal');		
			Mensagem("Processo alterado com sucesso: $nroprocesso/$anoprocesso");
			?>
			<form method="post" id="form">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" value="visualizar" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
			</form>
			<?php
		}//fim if se alterar
?>
<script>document.getElementById('form').submit();</script>

<fieldset style="margin-left:7px; margin-right:7px;"><legend>Inserir novo processo</legend>
	<form method="post" name="frmProcessosFiscais" id="frmProcessosFiscais" onsubmit="return ValidaFormulario('cmbAbertura|cmbEmissor|txtDatainicial|txtDatafinal')"> 	
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao_inserir" />
        <input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
		<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
		<table width="500" align="left">
			<tr align="left">
				<td align="left">Abertura:</td>
				<td>
					<select name="cmbAbertura" class="combo" id="cmbAbertura">
						<option value="I"<?php if("I" == $abertura){ echo "selected=selected";}?>>Individual</option>
						<option value="G"<?php if("G" == $abertura){ echo "selected=selected";}?>>Geral</option>
					</select>
				</td>
			</tr>
			<tr align="left">
				<td>Emissor processado:</td>
				<td>
					<select name="cmbEmissor" id="cmbEmissor" class="combo">
						<?php
							//echo "<option value=\"$codemissor\">$razaosocial</option>";
							$sql=mysql_query("SELECT codigo, razaosocial FROM cadastro ORDER BY razaosocial");
							while(list($cod_emissor,$razaosocial)=mysql_fetch_array($sql))
								{
									if($razaosocial){
										echo "<option value=\"$cod_emissor\"";if($cod_emissor == $codemissor){ echo "selected=selected";}echo ">$razaosocial</option>";
									}
								}
						?>
					</select>
				</td>
			</tr>
			<tr align="left">
				<td align="left">Data inicial a ser fiscalizada: </td>
				<td><input name="txtDatainicial" type="text" class="texto" maxlength="10" id="txtDatainicial" value="<?php echo $dataini; ?>" /></td>
		  </tr>
			<tr align="left">
			  <td align="left">Data final a ser fiscalizada: </td>
			  <td><input name="txtDatafinal" type="text" class="texto" maxlength="10" id="txtDatafinal" value="<?php echo $datafim; ?>" /></td>
		  </tr>
			<tr align="left">
			  <td align="left">Observa&ccedil;&otilde;es:</td>
			  <td><textarea name="txtObs" rows="5" cols="40" class="texto" id="txtObs"><?php echo $observacoes; ?></textarea></td>
		  </tr>
		  <tr>
			  <td align="left">1º Fiscal:</td>
			  <td>
			      <select name="cmbFiscal1" class="combo">
					<?php
						if($option[0]){echo $option[0];}
						else{echo "<option></option>";}	
						$sql = mysql_query("SELECT codigo, nome FROM fiscais WHERE fiscais.estado = 'A' ORDER BY nome");
						while(list($codfiscal, $nomefiscal)= mysql_fetch_array($sql))
						{
							echo"<option value=\"$codfiscal\">$nomefiscal</option>";
						}
					?>	
			      </select>
			</td>
	      </tr>	
		  <tr>
			  <td align="left">2º Fiscal:</td>
			  <td>
			      <select name="cmbFiscal2" class="combo">
					<?php
						if($option[1]){echo $option[1];}
						else{echo "<option></option>";}	
						$sql = mysql_query("SELECT codigo, nome FROM fiscais WHERE fiscais.estado = 'A' ORDER BY nome");
						while(list($codfiscal, $nomefiscal)= mysql_fetch_array($sql))
						{
							echo"<option value=\"$codfiscal\">$nomefiscal</option>";
						}
					?>	
			      </select>
			</td>
	      </tr>	
		  <tr>
			  <td align="left">3º Fiscal:</td>
			  <td>
			      <select name="cmbFiscal3" class="combo">
					<?php
						if($option[2]){echo $option[2];}
						else{echo "<option></option>";}	
						$sql = mysql_query("SELECT codigo, nome FROM fiscais WHERE fiscais.estado = 'A' ORDER BY nome");
						while(list($codfiscal, $nomefiscal)= mysql_fetch_array($sql))
						{
							echo"<option value=\"$codfiscal\">$nomefiscal</option>";
						}
					?>	
			      </select>
			</td>
	      </tr>	
		  <tr>
			  <td align="left">4º Fiscal:</td>
			  <td>
			      <select name="cmbFiscal4" class="combo">
					<?php	
						if($option[3]){echo $option[3];}
						else{echo "<option></option>";}	
						$sql = mysql_query("SELECT codigo, nome FROM fiscais WHERE fiscais.estado = 'A' ORDER BY nome");
						while(list($codfiscal, $nomefiscal)= mysql_fetch_array($sql))
						{
							echo"<option value=\"$codfiscal\">$nomefiscal</option>";
						}
					?>	
			      </select>
			</td>
	      </tr>	
		  <tr>
			  <td align="left">5º Fiscal:</td>
			  <td>
			      <select name="cmbFiscal5" class="combo">
					<?php	
						if($option[4]){echo $option[4];}
						else{echo "<option></option>";}	
						$sql = mysql_query("SELECT codigo, nome FROM fiscais WHERE fiscais.estado = 'A' ORDER BY nome");
						while(list($codfiscal, $nomefiscal)= mysql_fetch_array($sql))
						{
							echo"<option value=\"$codfiscal\">$nomefiscal</option>";
						}
					?>	
			      </select>
			</td>
	      </tr>	
		  <tr align="left">
		  	<td colspan="2">
				<?php
					if($acao=="alterar")
						{?>
							<input type="submit" name="btAlterar" value="Alterar" class="botao" onclick="document.getElementById('txtAcao_inserir').value='alterar'" />
						<?php }
					else
						{?>
							<input type="submit" name="btEnviar" value="Enviar" class="botao" onclick="document.getElementById('txtAcao_inserir').value='inserir'" />
						<?php }	
				?>
		</td>	
		</tr>
	</table>
    </form>
</fieldset>