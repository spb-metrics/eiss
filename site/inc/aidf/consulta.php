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
if(!$_POST['txtCNPJ']||!$_POST["txtSenha"]){ //se NAO digitou cnpj e a senha mostra tela de digitar cnpj, se digitou cnpj mostra a consulta
include("login.php");

}else{//else se digitou cnpj e a senha
	if( $_SESSION['autenticacao'] != $_POST['codseguranca']){
		Mensagem("Favor verificar código de segurança!");
		?>
		<form method="post" id="frmCodSeg">
			<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
		</form>
		<script>document.getElementById('frmCodSeg').submit();</script>
		<?php
	}else{//fim if do codigo de verificação.
		
		$cnpj = $_POST['txtCNPJ'];
		$senha = md5(addslashes($_POST['txtSenha']));
		$sqltipo=mysql_query("SELECT codigo FROM tipo WHERE tipo='grafica'");
		$result=mysql_fetch_object($sqltipo);
		
		//pega dados do solicitande
		$sql_emissor=mysql_query("SELECT codigo, nome, razaosocial, inscrmunicipal,logradouro,
								  numero,
								  complemento,
								  bairro,
								  cep, municipio, uf, email 
								  FROM cadastro
								  WHERE cnpj='$cnpj' OR cpf='$cnpj' AND senha='$senha' AND codtipo={$result->codigo}");
		
		//pega dados da empresa grafica, vereficando se esta na categegoria 28="graficas"
		
		if(mysql_num_rows($sql_emissor)<=0){
			 Mensagem("CNPJ ou Senha incorreta, verifique os dados digitados");
		?>
		<form method="post" id="frmCodSeg">
			<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
		</form>
		<script>document.getElementById('frmCodSeg').submit();</script>
		<?php
		}else{//fim if se emissor esta cadastrado

			//---------------------------------
			list($cod_emissor,$nome_emissor,$razao_emissor,$im_emissor,$logradouro_emissor,$numero_emissor,$complemento_emissor,$bairro_emissor,$cep_emissor,$municipio_emissor,$uf_emissor,$email_emissor)=mysql_fetch_array($sql_emissor);
			
			$sql_solicitacoes = mysql_query("SELECT aidf_solicitacoes.codigo,
													cadastro.razaosocial, 
													aidf_solicitacoes.observacoes, 
													aidf_solicitacoes.confirmar, 
													aidf_solicitacoes.data 
											 FROM aidf_solicitacoes
											 INNER JOIN cadastro ON aidf_solicitacoes.codgrafica = cadastro.codigo
											 WHERE aidf_solicitacoes.codemissor = '$cod_emissor'
											 ORDER BY aidf_solicitacoes.codigo DESC");
			$existe_solicitacoes = mysql_num_rows($sql_solicitacoes);
			
			?>
			
			
			
			<form id="frmAidf" method="post" name="frmDesSegundaVia" action="inc/aidf/aidf_imprimir.php" target="_blank">
			<input type="hidden" name="hdCodAidf" id="hdCodAidf" value="" />
				
			<table width="99%" border="0" cellpadding="0" cellspacing="1">
<tr>
					<td width="5%" height="10" bgcolor="#FFFFFF"></td>
			<td width="30%" rowspan="3" align="center" bgcolor="#FFFFFF">AIDF - Consulta de Solicitação</td>
		    <td width="65%" bgcolor="#FFFFFF"></td>
			  </tr>
				<tr>
				  <td height="1" bgcolor="#CCCCCC"></td>
				  <td bgcolor="#CCCCCC"></td>
				</tr>
				<tr>
				  <td height="10" bgcolor="#FFFFFF"></td>
				  <td bgcolor="#FFFFFF"></td>
				</tr>
				<tr>
					<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
				</tr>
				<tr>
					<td height="60" colspan="3" bgcolor="#CCCCCC">
			
					<table width="100%" height="100%" border="0" align="center" cellpadding="2" cellspacing="2">
<tr>
							<td colspan="2" align="left"><strong>Prestador: Verificação de solicitação a Prefeitura Municipal.</strong></td>
						</tr>
						<tr>
							<td width="27%" align="left" valign="middle">CNPJ:</td>
							<td width="73%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $cnpj ?></td>
					  </tr>
						<tr>
						  <td align="left" valign="middle">Inscri&ccedil;&atilde;o Municipal:</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $im_emissor;?></td>
					  </tr>
						<tr>
						  <td align="left" valign="middle">Raz&atilde;o Social:</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $razao_emissor;?></td>
					  </tr>
						<tr>
						  <td align="left" valign="middle">Endere&ccedil;o:</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$logradouro_emissor $numero_emissor $complemento_emissor - $municipio_emissor - $uf_emissor";?></td>
					  </tr>
						<tr>
							<td colspan="2" align="center" valign="top">
							  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
								<tr>
								  <td align="center" bgcolor="#CCCCCC">Código Solicitação</td>
								  <td align="center" bgcolor="#CCCCCC">Gráfica</td>
								  <td align="center" bgcolor="#CCCCCC">Data</td>
								  <td align="center" bgcolor="#CCCCCC">Imprimir/ Confirmado</td>
								</tr>
							<?php 
							if(mysql_num_rows($sql_solicitacoes)==0){
							?> 
							<tr>
								<td align="center" colspan="100"><strong>Não ha solicitações!</strong></td>
							</tr>
							<?php 
							}
							while(list($codsolicitacao,$grafica,$observacoes,$confirmar,$data)=mysql_fetch_array($sql_solicitacoes)){
								if($confirmar=="s"){
									$imprimir = "<input name=\"imgImprimir$cont\" id=\"imgImprimir$cont\" type=\"image\" src=\"../img/botoes/botao_imprimir.jpg\" onClick=\"return SubmitImprimirAidf('$cont');\">";
								} else {
									$imprimir = "aguardando";
								}
								?>
								<tr>
								  <td align="center">
									<input name="txtCodigo<?php echo $cont;?>" type="text" class="texto" id="txtCodigo<?php echo $cont;?>" value="<?php echo $codsolicitacao; ?>" size="10" style="text-align:center" readonly />
								  </td>	
								  <td align="center">
									<input name="txtGrafica<?php echo $cont;?>" type="text" class="texto" id="txtGrafica<?php echo $cont;?>" value="<?php echo $grafica; ?>" size="40" style="text-align:center" readonly />
								  </td>	
								  <td align="center">
									<input name="txtData<?php echo $cont;?>" type="text" class="texto" id="txtData<?php echo $cont;?>" value="<?php echo DataPt($data); ?>" size="10" style="text-align:center" readonly />
								  </td>
								  <td align="center">
									<?php echo $imprimir;?>
								  </td>
								</tr>	
							<?php
							 $cont++;
							}//fim while list
							?>
							  </table>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="middle"><em>* Confira seus dados antes de continuar<br>
						  ** Desabilite seu bloqueador de pop-up</em></td>
						</tr>
						<tr>
							<td height="40" colspan="2" align="left" valign="middle"><input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='aidf.php'"></td>
						</tr>
					</table>		
				  </td>
				</tr>
			</table>    
					
					
					
</form>
			<?php
		}//fim else se o emissor esta cadastrado.
	}//fim else se digitou codigo de seguranca
}//fim else se digitou cnpj e senha
?>