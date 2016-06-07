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
<!-- Formulário com o filtro de empresas------------------------->


<?php

//ativa a empresa para emitir nfe

if($_POST['btLiberarEmpresa'] == "T") {

	$CODEMPRESA = $_POST['COD'];

	$sql_empresa = mysql_query("SELECT codigo, nome, razaosocial, cnpjcpf, inscrmunicipal, endereco, municipio, uf, email, senha, simplesnacional, fonecomercial, fonecelular FROM emissores WHERE codigo = '$CODEMPRESA'");
	
	// Pega as variaveis
	list($codigo, $nome, $razaosocial, $cnpjcpf, $inscrmunicipal, $endereco, $municipio, $uf, $email, $senha, $simplesnacional, $tipo, $fone, $celular) = mysql_fetch_array($sql_empresa);
	
	if ($simplesnacional == "") {
		$simplesnacional = "N";
	}
	$CODEMPR = $codigo;
	
	//Verifica se o login jah existe	
	$sql = mysql_query("SELECT login FROM usuarios WHERE login = '$cnpjcpf'");
	
	if(mysql_num_rows($sql) == 0) {	   
		//Insere o usuário no banco de dados	
		$sql_login = mysql_query("INSERT INTO usuarios SET nome = '$nome', login = '$cnpjcpf', senha = '$senha', tipo = '$tipo'");
			
		// atualiza o estado do prestador
		$sql = mysql_query("UPDATE emissores SET estado = 'A' WHERE codigo = '$CODEMPR'");	
		add_logs('Ativou empresa');
		
		//depois de cadastrada a empresa recebe um passo a passo com a senha cadastrada
		$msg ="O cadastro da empresa $nome foi efetuado com sucesso.<br>
		Dados da empresa:<br><br>
		Razão Social: $razaosocial<br>
		CPF/CNPJ: $cnpjcpf<br>
		Município: $municipio<br>
		Endereco: $endereco<br>
		Senha de acesso: $senha<br><br>
		  
		Veja passo a passo como acessar o sistema:	<br><br>
		1- Acesse o site $LINK<br>
		2- Clique no link prestadores<br>
		3- Clique na imagem em acessar NF-e<br>
		4- Em login insira o cpf/cnpf da empresa<br>
		5- Sua senha é <b><font color=\"RED\">$senha</font></b><br>
		6- Insira o código de verificação que aparece ao lado<br>";	
		
		$assunto = "Acesso ao Sistema NF-e: LIBERADO [$PREFEITURA]";
	
		$headers  = "MIME-Version: 1.0\r\n";
	
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
		$headers .= "From: $EMAIL \r\n";
	
		$headers .= "Cc: \r\n";
	
		$headers .= "Bcc: \r\n";
			
		mail("$email",$assunto,$msg,$headers);	
			
		/*// INSERCAO DE SERVICOS POR EMPRESA INICIO -----------------------------------------------------------------------
		$sql_servicos = mysql_query("SELECT codservico FROM cadastro_emissores_servicos WHERE codemissor = '$CODEMPRESA'");
	
		//Insere os servicos no banco...
		while(list($codservico) = mysql_fetch_array($sql_servicos)) {   
			$sql = mysql_query("INSERT INTO emissores_servicos SET codservico = '$codservico', codemissor='$CODEMPRESA'");	
		} // fim while 
	
		// INSERCAO DE SERVICOS POR EMPRESA FIM
		
		// INSERCAO DE RESP/SOCIOS POR EMPRESA INICIO-------------------------------------------------------------------------------
		$sql_socios = mysql_query("SELECT nome, cpf FROM cadastro_emissores_socios WHERE codemissor = '$CODEMPRESA'");
				
	   //insere os socios no banco
		while(list($nome, $cpf) = mysql_fetch_array($sql_socios)) {   
			$sql = mysql_query("INSERT INTO emissores_socios SET codemissor='$CODEMPR', nome = '$nome', cpf = '$cpf'");
		} // fim while   
		// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM*/
		
		// APAGA OS DADOS DO CADASTRO DA TABELA TEMPORARIA
		//$sql_socios = mysql_query("DELETE FROM `cadastro_emissores_socios` WHERE `codemissor`= '$CODEMPRESA'");
		//$sql_socios = mysql_query("DELETE FROM `cadastro_emissores_servicos` WHERE `codemissor`= '$CODEMPRESA'");
		//$sql_socios = mysql_query("DELETE FROM `cadastro_emissores` WHERE `codigo`= '$CODEMPRESA'");
			
		print "<script language=JavaScript> alert('Empresa ativada com sucesso!');</script>";
	} // fim if Verifica se o login já existe
	else {
		print "<script language=JavaScript>alert('Login existente');</script>";
	}
} // fim if 

?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Prestadores - Liberar</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
   <fieldset>
   <legend>Liberar Acesso</legend>
<?php    
$sql_buscaempresa = mysql_query("SELECT codigo, nome, cnpj, cpf FROM cadastro WHERE estado = 'NL' ORDER BY nome ASC");
if(mysql_num_rows($sql_buscaempresa)){
?>
   <form action="" method="post" id="frmLiberar">
   		<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
		<input type="hidden" name="COD" id="COD" />
		<input type="hidden" name="btLiberarEmpresa" id="btLiberarEmpresa"/>
   <table width="100%" align="center" cellpadding="0" cellspacing="1">    
    <tr> 
	 <td width="60%" align="center" bgcolor="#999999">Nome</td>
	 <td width="25%" align="center" bgcolor="#999999">CNPJ/CPF</td>
	 <td width="15%" align="center" bgcolor="#999999">Ações</td>
    </tr>
	
	<?php 
while(list($codigo, $nome, $cnpj, $cpf)=mysql_fetch_array($sql_buscaempresa)) {
	if($cnpj){$cnpjcpf=$cnpj;}else{$cnpjcpf=$cpf;}//testa se tem cnpj ou cpf
	?>	
     <tr> 
	  <td align="left" bgcolor="#FFFFFF" >&nbsp;<?php echo $nome; ?></td>
	  <td align="center" bgcolor="#FFFFFF"><?php echo $cnpjcpf; ?></td>
	  <td align="center"><a onclick="document.getElementById('COD').value='<?php echo $codigo; ?>';document.getElementById('btLiberarEmpresa').value='T';document.getElementById('frmLiberar').submit();"><img src="img/botoes/botao_ativar.jpg" /></a></td>
     </tr>  

	<?php
	} // im while
	 ?> 
   	 
   </table>  
   </form> 
<?php
}else{
?>
	<table width="100%">
    	<tr>
        	<td align="center">Não há nenhum prestador aguardando liberação</td>
        </tr>
    </table>
<?php
}
?>
    
   </fieldset>
   
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>

