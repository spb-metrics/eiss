<?php  
$prestador_login = $_SESSION['login'];
$sql_prestador_codigo = mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$prestador_login'");
list($prestador_codcadastro) = mysql_fetch_array($sql_prestador_codigo);
$_POST['CODPRESTADOR'] = $prestador_codcadastro; 

$codigo_prestador = $_POST['CODPRESTADOR'];
$codigo_contador  = $_POST['CODCONTADOR'];
$sql_prestador = mysql_query("
	SELECT
		nome,
		razaosocial,
		IF(cnpj <> '',cnpj,cpf) AS cnpjcpf,
		codcontador
	FROM
		cadastro
	WHERE 
		codigo = '$codigo_prestador'
");
?>
	
<table width="580" border="0" cellpadding="0" cellspacing="1">
	<tr>
	  <td width="5%" height="10" bgcolor="#FFFFFF"></td>
	  <td width="40%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">Prestador - Definir Contador</td>
      <td width="55%" bgcolor="#FFFFFF"></td>
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

<style type="text/css" media="all">
<!--
	#divBuscaPrestador {
		position:absolute;
		left:40%;
		top:20%;
		width:298px;
		height:276px;
		z-index:1;
	 visibility:<?php if(isset($btBuscarPrestador)) { echo"visible"; } else { echo"hidden";}?>
	}
	
	#divBuscaContador {
		position:absolute;
		left:40%;
		top:20%;
		width:298px;
		height:276px;
		z-index:1;
	 visibility:<?php if(isset($btBuscarContador)) { echo"visible"; } else { echo"hidden"; }?>
	}
	
	
	input[type*="text"]{
		text-transform:uppercase;
	}
 -->
</style>
<div id="divBuscaPrestador"  >
	<?php //include("inc/cadastro/prestadores/busca_prestador_cont.php"); ?>
</div>
<div id="divBuscaContador"  >
	<?php include("include/des/busca_contador.php"); ?>
</div>
<?php
	//Testa se o usuario acionou o botao de inserção de novo contador se sim direciona para o cadastro de prestadores
	if($_POST['btNovoContador']){
		RedirecionaPost("principal.php?include=inc/cadastro/prestadores/cadastro.php");
		die();
	}


	//Testa se algum dos botões foi acionado
	if(($_POST['btAdcionar'] == "Adicionar Contador")
		|| ($_POST['btAtualizar'] == "Atualizar Contador")
	 	|| ($_POST['btRemoverContador'] == "Remover Contador")){
		$cod_prest = $_POST['CODPRESTADOR'];
		$cod_cont  = $_POST['CODCONTADOR'];
		mysql_query("UPDATE cadastro SET codcontador = '$cod_cont' WHERE codigo = '$cod_prest'");
		if($_POST['btAdcionar'] == "Adicionar Contador"){
			//add_logs('Inseriu Contador para uma Empresa');
			Mensagem("Inserido contador para a empresa!");
		}else{
			//add_logs('Atualizou Contador para uma Empresa');
			Mensagem("Contador da empresa atualizado!");
		}
	}
		
	//Verifica se foi feita uma busca pelo prestador se sim traz as informações do banco sobre o mesmo
	if($_POST['CODPRESTADOR']){
		$codigo_prestador = $_POST['CODPRESTADOR'];
		$codigo_contador  = $_POST['CODCONTADOR'];
		$sql_prestador = mysql_query("
			SELECT
				nome,
				razaosocial,
				IF(cnpj <> '',cnpj,cpf) AS cnpjcpf,
				codcontador
			FROM
				cadastro
			WHERE 
				codigo = '$codigo_prestador'
		");
		list($nome,$razaosocial,$cnpjcpf,$codcontador) = mysql_fetch_array($sql_prestador);
		
		//testa se o prestador ja possui um contador
		if(!$codigo_contador){
			$codigo_contador = $codcontador;
		}
		
		//busca as informações do contador referente ao prestador ou informações referentes ao contador buscado pelo usuario
		$sql_contador = mysql_query("
			SELECT
				nome,
				IF(cnpj <> '',cnpj,cpf) AS cnpjcpf,
				fonecomercial
			FROM
				cadastro
			WHERE 
				codigo = '$codigo_contador'
		");
		list($nome_cont,$cnpjcpf_cont,$fone_cont) = mysql_fetch_array($sql_contador);
	}
?>
		
			<form method="post">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
				<input type="hidden" name="CODPRESTADOR" value="<?php echo $_POST['CODPRESTADOR'];?>" />
				<input type="hidden" name="CODCONTADOR" id="hdCODCONTADOR" value="<?php echo $_POST['CODCONTADOR']?$_POST['CODCONTADOR']:$codcontador;?>" />
					<table width="100%">
						<tr>
							<td align="left" colspan="2"><b>Informações da Empresa</b></td>
						</tr>
						<tr>
							<td align="left"> Nome </td>
							<td align="left">
								<input readonly="readonly" type="text" size="70" maxlength="100" name="txtNomeEmp" class="texto" value="<?php if(isset($nome)){echo $nome;} ?>">
							</td>
						</tr>
						<tr>
							<td align="left"> Razão Social </td>
							<td align="left">
								<input readonly="readonly" type="text" size="70" maxlength="100" name="txtRazaoEmp" class="texto" 
								value="<?php if(isset($razaosocial)){echo $razaosocial;} ?>">
							</td>
						</tr>
						<tr>
							<td align="left"> CNPJ/CPF </td>
							<td align="left">
								<input readonly="readonly" type="text" size="20"  name="txtCNPJEmp" class="texto" 
								value="<?php if(isset($cnpjcpf)){echo $cnpjcpf;} ?>" maxlength="18" />
							</td>
						</tr>
						<tr>
							<td align="left" colspan="2">
								<input style="display: none" name="btPesquisar" type="button" class="botao" value="Buscar Prestador" 
								onclick="document.getElementById('divBuscaPrestador').style.visibility='visible';document.getElementById('divBuscaContador').style.visibility='hidden'">
							</td>
						</tr>
						<tr>
							<td colspan="2"><hr size="1" color="#000000"></td>
						</tr>
						<tr>
							<td align="left" colspan="2"><b>Informações do Contador</b></td>
						</tr>
						<tr>
							<td align="left"> Nome<font color="#FF0000">*</font> </td>
							<td align="left">
								<input readonly="readonly" type="text" size="70" maxlength="100" name="txtNomeCont" id="txtNomeCont" class="texto"  
								value="<?php if(isset($nome_cont)){echo $nome_cont;} ?>" <?php if(!isset($nome_cont)){ echo "disabled=\"disabled\"";}?>>
							</td>
						</tr>
						<tr>
							<td align="left"> CNPJ/CPF<font color="#FF0000">*</font> </td>
							<td align="left">
								<input readonly="readonly" type="text" size="20"  name="txtCNPJEmp" id="txtCNPJEmp" class="texto" 
								value="<?php if(isset($cnpjcpf_cont)){echo $cnpjcpf_cont;} ?>" maxlength="18" <?php if(!isset($cnpjcpf_cont)){echo "disabled=\"disabled\"";}?> />
							</td>
						</tr>
						<tr>
							<td align="left"> Telefone<font color="#FF0000">*</font> </td>
							<td align="left">
								<input readonly="readonly" type="text" class="texto" size="20" maxlength="15" name="txtFoneComercial" id="txtFoneComercial"
								 value="<?php if(isset($fone_cont)){ echo $fone_cont;} ?>" <?php if(!isset($fone_cont)){ echo "disabled=\"disabled\"";}?>/>
							</td>
						</tr>
					</table>

					<table width="100%">
						<tr>
							<td width="23%" align="left">
								<?php if(!isset($codcontador)){?>
									<input name="btAdcionar" type="submit" class="botao" value="Adicionar Contador" <?php if(!isset($_POST['CODPRESTADOR'])){ echo "disabled=\"disabled\"";}?>
									onclick="return ValidaFormulario('txtNomeCont|txtCNPJEmp|txtFoneComercial','Você deve buscar algum contador cadastrado no sistema!')">
								<?php }?>
								<?php if(isset($codcontador)){?><input name="btAtualizar" type="submit" class="botao" value="Atualizar Contador" <?php if(!isset($cnpjcpf_cont)){echo "disabled=\"disabled\"";}?> /><?php }?>
							</td>
							<td width="77%" align="left">
								<?php
									if(isset($_POST['CODPRESTADOR'])){
								?>
									<input name="btPesquisar" type="button" class="botao" value="Buscar Contador" 
									onclick="document.getElementById('divBuscaPrestador').style.visibility='hidden';document.getElementById('divBuscaContador').style.visibility='visible'">
									<input style="display: none" name="btNovoContador" type="submit" class="botao" value="Novo Contador" />
									<input name="btRemoverContador" id="btRemoverContador" type="submit" class="botao" value="Remover Contador" <?php if(!isset($cnpjcpf_cont)){echo "disabled=\"disabled\"";}?> />
									<script>
										document.getElementById('btRemoverContador').onclick = function(){
											if(confirm('Remover contador?')){
												document.getElementById('hdCODCONTADOR').value = '';
												return true;
											} else {
												return false;
											}
										};
									</script>
								<?php
									}
								?>
							</td>
						</tr>
					</table>

			</form>
		
		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table> 