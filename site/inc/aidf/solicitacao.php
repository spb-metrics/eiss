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
<script language="JavaScript">
function CancelaEnter(e) {
	var tecla= document.all ? e.keyCode : e.which;
	
	if (tecla==13) {
		document.getElementById('btVerificar').onclick();
 		return false;
	}

}
</script>
<?php

if($_POST["btConfirmar"] == "Confirmar"){
	$codigo_emissor	= $_POST["txtCodemissor"];
	$codigo_grafica	= $_POST["txtCodgrafica"];
	$observacoes 	= $_POST["txtObservacoes"];
		$data = date('Y-m-d');
		mysql_query("INSERT INTO aidf_solicitacoes SET codemissor = '$codigo_emissor', codgrafica = '$codigo_grafica', observacoes = '$observacoes', data = '$data'");
		list($cod_aidf) = mysql_fetch_array(mysql_query("SELECT MAX(codigo) FROM aidf_solicitacoes"));// pega o codigo da solicitacao recem cadastrada.
		
		//verifica quais os documentos foram preenchidos e quantos.
		$contdoc=0;
		for($cont=1;$cont<=5;$cont++){
			$especie    = $_POST["txtEspecie".$cont];
			$serie      = $_POST["txtSerie".$cont];
			$subserie   = $_POST["txtSubserie".$cont];
			$nroinicial = $_POST["txtNroinicial".$cont];
			$nrofinal   = $_POST["txtNrofinal".$cont];
			$quantidade = $_POST["txtQuantidade".$cont];
			$tipo       = $_POST["txtTipo".$cont];
			
			//verifica se os dados dos documentos solicitados foram digitados
			if(($especie)&&(($nroinicial)||($nrofinal))){
			mysql_query("INSERT INTO aidf_docs SET codsolicitacao = '$cod_aidf', especie = '$especie', serie = '$serie', subserie = '$subserie', nroinicial = '$nroinicial', nrofinal = '$nrofinal', quantidade = '$quantidade', tipo = '$tipo'");
			$contdoc++; //contador de documentos registrados.
			}//fim if se a especie e numeracao de inicio e fim estao prenchidas e insere no banco os documentos.
		}//fim for de documentos
		if($contdoc>0){
			Mensagem("Solicitação registrada, aguarde a confirmação da prefeitura.");
			Redireciona("aidf.php");
		}else{
			
			//exclui a solicitacao sem documentos selecionados.
			mysql_query("DELETE FROM aidf_solicitacoes WHERE codigo = '$cod_aidf'");
			Mensagem("Defina a espécie e numeração de pelo menos um documento para fazer a solicitação.");?>
			<form method="post" id="formAIDF">
			<input type="hidden" name="txtMenu" value="<?php echo $_POST['txtMenu'];?>">
			<input type="hidden" name="txtCNPJ" value="<?php echo $_POST['txtCNPJ']; ?>">
			<input type="hidden" name="txtCNPJGrafica" value="<?php echo $_POST['txtCNPJGrafica']; ?>">
			</form>
			<script>document.getElementById('form').submit();</script>
			<?php //o form acima serve se nenhum documento foi selecionado voltar para a mesma pagina com os dados de post.
		}//fim else se foi preenchido algum documento
}else{//fim if de submit
	
	if(!$_POST['txtCNPJ']||!$_POST["txtSenha"]){ //se NAO digitou cnpj e a senha mostra tela de digitar cnpj, se digitou cnpj mostra a consulta
		include("login.php");
	}else{//else se digitou cnpj e a senha
		if( $_SESSION['autenticacao'] != $_POST['codseguranca']){
			Mensagem("Favor verificar codigo de segurança!");
			?>
			<form method="post" id="frmCodSeg">
				<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
			</form>
			<script>document.getElementById('frmCodSeg').submit();</script>
			<?php
		}else{//fim if do codigo de verificacao.
			
			$cnpj = $_POST['txtCNPJ'];
			$codtipo_tomador = codtipo('tomador');
			$sql_verifica = mysql_query("SELECT codtipo FROM cadastro WHERE cnpj = '$cnpj' OR cpf = '$cnpj'");
			list($codtipo_usuario) = mysql_fetch_array($sql_verifica);
			if($codtipo_tomador == $codtipo_usuario){
				Mensagem("Somente prestadores podem solicitar aidf!");
				?>
				<form method="post" id="frmCodSeg">
					<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
				</form>
				<script>document.getElementById('frmCodSeg').submit();</script>
				<?php
			}
				$senha = md5(addslashes($_POST['txtSenha']));//evita sql injection
				
				//pega dados do solicitande
				$sql_emissor=mysql_query("SELECT codigo, nome, razaosocial, inscrmunicipal,
								logradouro,
								numero,
								complemento,
								bairro,
								cep,		
								municipio,
								uf,
								email 
								FROM cadastro 
								WHERE cnpj='$cnpj' OR cpf='$cnpj' AND senha='$senha'");
				
				//pega dados da empresa grafica, vereficando se esta na categegoria 28="graficas"
				
				if(mysql_num_rows($sql_emissor)<=0){
					 Mensagem("CNPJ ou Senha incorreto, verifique os dados digitados");
				?>
				<form method="post" id="frmCodSeg">
					<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
				</form>
				<script>document.getElementById('frmCodSeg').submit();</script>
				<?php
				}else{//fim if se emissor esta cadastrado
					
					//lista os dados do emissor solicitante.
					list($codigo_emissor, $nome_emissor, $razaosocial_emissor, $inscrmunicipal_emissor, $logradouro_emissor,$numero_emissor,$complemento_emissor,$bairro_emissor,$cep_emissor, $municipio_emissor, $uf_emissor, $email_emissor) = mysql_fetch_array($sql_emissor);
					
					
					
					$sql_verifica_solicitacao = mysql_query("SELECT confirmar FROM aidf_solicitacoes WHERE codemissor = '$codigo_emissor'");
					while(list($confirmar) = mysql_fetch_array($sql_verifica_solicitacao)){
						if($confirmar == "n"){
							$status = "OK";
						}
					}
					//lista os dados da grafica.
		
				?>
				<form method="post" id="frmSolicitacao">
					<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
					<input type="hidden" name="txtCNPJ" value="<?php echo $_POST['txtCNPJ']; ?>">
					<input type="hidden" name="txtCodemissor" value="<?php echo $codigo_emissor; ?>" />
                    
                    <table width="99%" border="0" cellpadding="0" cellspacing="1">
                    <tr>
                          <td width="5%" height="10" bgcolor="#FFFFFF"></td>
                          <td width="30%" rowspan="3" align="center" bgcolor="#FFFFFF">Solicita&ccedil;&atilde;o de Aidf</td>
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
                    
                    
                    
								<table width="100%" border="0" align="left" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC">
<tr>
										<td height="30" colspan="2" align="left"><em><strong>Identifica&ccedil;&atilde;o do estabelecimento Solicitante</strong></em></td>
									</tr>
									<tr>
										<td width="150" align="left">Nome:</td>
										<td bgcolor="#FFFFFF"><?php echo $nome_emissor; ?></td>
									</tr>
									<tr>
										<td align="left">Razão Social:</td>
										<td align="left" bgcolor="#FFFFFF"><?php echo $razaosocial_emissor; ?></td>
									</tr>
									<tr>
										<td align="left">Endereço:</td>
										<td align="left" bgcolor="#FFFFFF"><?php echo "$logradouro_emissor $numero_emissor $complemento_emissor, $municipio_emissor, $uf_emissor"; ?></td>
									</tr>
									<tr>
										<td align="left">Inscrição Municipal:</td>
										<td align="left" bgcolor="#FFFFFF"><?php echo $inscrmunicipal_emissor; ?></td>
									</tr>
									<tr>
										<td align="left">CNPJ/CPF:</td>
										<td align="left" bgcolor="#FFFFFF"><?php echo $cnpj; ?></td>
									</tr>
									<tr>
										<td height="30" colspan="2"><strong><em>Identifica&ccedil;&atilde;o do estabelecimento Gr&aacute;fico</em></strong></td>
                                  </tr>
                                    <tr>
                                        <td align="left">CNPJ/CPF:</td>
                                        <td align="left">
											<input type="text" class="texto" name="txtCNPJGrafica" 
											onkeypress="return CancelaEnter(event);" <?php if($status){ echo "disabled=\"disabled\"";}?> /> 
											<input type="button" name="btVerificar" id="btVerificar" value="Verificar" class="botao" 
											onclick="acessoAjax('inc/aidf/solicitacao.ajax.php','frmSolicitacao','divAjax')" <?php if($status){ echo "disabled=\"disabled\"";}?> />
											<?php if($status){ echo "<br><em><b>H&aacute; uma solicita&ccedil;&atilde;o em andamento</b></em>";}?>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                            <div id="divAjax"></div>
                                      </td>                                    
                                    </tr>
                              </table>                                        
                                        
                                        
                                        
                        </td>
					</tr>
                    <tr>
                        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
                    </tr>
                </table>    
</form>

				<?php
			}//fim else se o emissor esta cadastrado.
		}//fim else se digitou codigo de seguranca
	}//fim else se digitou cnpj e senha
}//fim else se eh submit

?>
