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
	// recebe os dados do processo
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	if($_POST["btEnviar"]=="Enviar")
		{
			// recebe os dados dos documentos a serem homologados
			$nrodoc=strip_tags(addslashes($_POST["txtNroDoc"]));
			$codservico=$_POST["cmbLS"];
			$emissao=strip_tags(addslashes($_POST["txtDataEmissao"]));
			$observacoes=strip_tags(addslashes($observacoes));
			$aliquota=$_POST["txtAliquota"];
			$situacao=strip_tags(addslashes($_POST["cmbSituacaoTributo"]));
			$vtotal=strip_tags(addslashes($_POST["txtValorTotal"]));
			$iss=strip_tags(addslashes($_POST["txtIss"]));
			$issretido=strip_tags(addslashes($_POST["txtIssRetido"]));
			$lps=strip_tags(addslashes($_POST["txtLocalPS"]));
			$deducao=strip_tags(addslashes($_POST["txtDeducao"]));
			$cpfcnpjtomador=$_POST["txtTomador"];
			
			//Muda o formato da data de 00/00/0000
			$emissao = DataMysql($emissao);
			
			//Pega os valores dos campos que vieram em moeda e converte para decimal
			$vtotal    = MoedaToDec($vtotal);
			$iss       = MoedaToDec($iss);
			$deducao   = MoedaToDec($deducao);
			
			// inseri os dados no banco
			mysql_query("
				INSERT INTO processosfiscais_homologacao 
				SET codservico='$codservico', 
				nrodoc='$nrodoc', 
				nroprocesso='$nroprocesso', 
				anoprocesso='$anoprocesso', 
				situacao_tributo='$situacao', 
				valortotal='$vtotal', 
				iss='$iss', 
				issretido='$issretido', 
				lps='$lps', 
				deducao='$deducao', 
				competencia='$emissao', 
				tipo='P',
				cpfcnpjtomador='$cpfcnpjtomador'
			");
			add_logs('Inseriu um Processo Fiscal com Homologação de Prestador');
			
		}
	elseif($_POST["btHomologar"]=="Homologar")
		{
			//recebe os dados
			$codhomologacao=$_POST["txtHomologacao"];
			
			// homologa o documento
			mysql_query("UPDATE processosfiscais_homologacao SET homologado='S' WHERE codigo='$codhomologacao'");
			add_logs('Autalizou um Processo Fiscal com Homologação de Prestador');
			Mensagem("Documento homologado com sucesso!");
		}	
	
	// busca a(s) categoria(s) dos servicos prestados pelo emissor em questao
	$sql=mysql_query("
		SELECT servicos_categorias.nome 
		FROM servicos_categorias 
		INNER JOIN servicos 
		ON servicos_categorias.codigo=servicos.codcategoria 
		INNER JOIN cadastro_servicos
		ON servicos.codigo=cadastro_servicos.codservico
		INNER JOIN processosfiscais 
		ON cadastro_servicos.codemissor=processosfiscais.codemissor
		WHERE processosfiscais.anoprocesso='$anoprocesso' 
		AND processosfiscais.nroprocesso='$nroprocesso' 
		GROUP BY servicos_categorias.nome
	");
	while(list($nomecategoria)=mysql_fetch_array($sql))
		{
			$categoria.=$nomecategoria.", ";
		}
	$categoria=substr($categoria, 0, -2 );
	
	// busca a razao social do emissor em questao
	$sql=mysql_query("SELECT cadastro.razaosocial,
                      cadastro.codigo
                      FROM cadastro
                      INNER JOIN processosfiscais
                      ON cadastro.codigo=processosfiscais.codemissor
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND anoprocesso='$anoprocesso'"); 
	list($razaosocial,$codemissor)=mysql_fetch_array($sql);
?>
	<table width="100%">
		<tr>
			<td colspan="2"><b>Homologação de serviços prestados</b></td>
		</tr>
		<tr>
			<td width="25%">Processo Fiscal:</td>
			<td><?php echo $nroprocesso."/".$anoprocesso; ?></td>
		</tr>
		<tr>
			<td width="25%">Empresa:</td>
			<td><?php echo $razaosocial; ?></td>
		</tr>
		<tr>
			<td width="25%">Atividade(s):</td>
			<td><?php echo $categoria; ?></td>
		</tr>
	</table>
	<form method="post">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="homologacao" />
		<input type="hidden" name="txtServicos" value="prestados" />
		<table width="100%">	
			<tr>
				<td width="25%">Item da lista de serviços:</td>
				<td>
                    <select name="cmbLS" style="width:100%">
						<?php
							$sql=mysql_query("SELECT servicos.codigo,
                                              servicos.descricao
                                              FROM servicos
                                              INNER JOIN cadastro_servicos
                                              ON servicos.codigo=cadastro_servicos.codservico
                                              INNER JOIN cadastro
                                              ON cadastro.codigo=cadastro_servicos.codemissor
                                              WHERE cadastro_servicos.codemissor='$codemissor'"); 
							while(list($codservico,$descricao)=mysql_fetch_array($sql))
								{
									echo "<option value=\"$codservico\">$descricao</option>"; 
								}
						?>
					</select>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="25%">Nro. Documento:</td>
				<td width="25%"><input type="text" class="texto" name="txtNroDoc" /></td>
				<td width="25%">Emissão:</td>
				<td width="25%"><input type="text" class="texto" name="txtDataEmissao" maxlength="10" /></td>
			</tr>
			<tr>
				<td>CPF/CNPJ Tomador:</td>
				<td>
					<input type="text" class="texto" name="txtTomador" maxlength="18" onkeydown="stopMsk( event );" onkeyup="CNPJCPFMsk( this );return NumbersOnly( event );" />
				</td>
				<td>Situação do tributo:</td>
				<td>
					<select name="cmbSituacaoTributo" class="combo" style="width:134px">
						<option value="N">Não Pago</option>
						<option value="P">Pago</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Valor Total:</td>
				<td><input type="text" class="texto" name="txtValorTotal" id="txtValorTotal" onblur="CalculaIss('txtValorTotal','txtIss')" onkeyup="MaskMoeda(this);return NumbersOnly(event);" /></td>
				<td>ISS</td>
				<td><input type="text" class="texto" name="txtIss" id="txtIss" onkeyup="MaskMoeda(this);return NumbersOnly(event);" /></td>
			</tr>
			<tr>
				<td>ISS Retido:</td>
				<td><input type="text" size="5" class="texto" name="txtIssRetido" id="txtIssRetido" onblur="CalculaIssRetido('txtValorTotal','txtIssRetido')" />%</td>
				<td>Dedução:</td>
				<td><input type="text" class="texto" name="txtDeducao" id="txtDeducao" onblur="SomaDeduc('txtDeducao','txtValorTotal')" onkeyup="MaskMoeda(this);return NumbersOnly(event);" /></td>
			</tr>
			<tr>
				<td>Local da Prestação de Serviço:</td>
				<td><input type="text" class="texto" name="txtLocalPS" /></td>
				<td colspan="2"><input type="submit" class="botao" name="btEnviar" value="Enviar" /></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
				</td>
			</tr>
		</table>
	</form>
    </fieldset>
    <fieldset>
	<?php
		$sql=mysql_query("SELECT codigo,
                          nrodoc,
                          competencia,
                          cpfcnpjtomador,
                          valortotal,
                          iss,
                          issretido,
                          deducao
                          FROM processosfiscais_homologacao
                          WHERE nroprocesso='$nroprocesso'
                          AND anoprocesso='$anoprocesso'
                          AND homologado='N'
                          AND tipo='P'
                          ORDER BY competencia");
		if(mysql_num_rows($sql)>0){
	?>
	<form method="post">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="homologacao" />
		<input type="hidden" name="txtServicos" value="prestados" />
	<table width="100%">
		<tr bgcolor="#999999">
			<td>Nro. Doc</td>
			<td>CPF/CNPJ Tomador</td>
			<td>Valor R$</td>
			<td>ISS R$</td>
			<td>ISS Retido R$</td>
			<td>Deduções R$</td>
			<td>Data</td>
			<td>Homologação</td>
		</tr>
		<?php
			while(list($codhomologacao,$nrodoc,$competencia,$cpfcnpjtomador,$vtotal,$iss,$issretido,$deducao)=mysql_fetch_array($sql))
				{
					//Converte os valores do banco para um modo amigavel para o usuario
					$competencia = DataPt($competencia);
					$vtotal      = DecToMoeda($vtotal);
					$iss         = DecToMoeda($iss);
					$deducao     = DecToMoeda($deducao); 
					
					echo "
						<tr bgcolor=\"#FFFFFF\">
							<td>$nrodoc</td>
							<td>$cpfcnpjtomador</td>
							<td>$vtotal</td>
							<td>$iss</td>
							<td>$issretido</td>
							<td>$deducao</td>
							<td>$competencia</td>
							<td><input type=\"submit\" class=\"botao\" name=\"btHomologar\" value=\"Homologar\" onclick=\"txtHomologacao.value=$codhomologacao\" /></td>
						</tr>
					";
				}
		?>
	</table>
		<input type="hidden" name="txtHomologacao" />
		<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
		<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
	</form>	
	<?php 
		}else{echo "Nenhum documento à ser homologado.";}
	?>
