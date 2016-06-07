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
$nome 			= $_POST["txtInsNomeOrgao"];
$razaosocial	= $_POST["txtInsRazaoSocial"];
$cnpj			= $_POST["txtCNPJ"];
$logradouro		= $_POST["txtLogradouro"];
$numero			= $_POST["txtNumero"];
$bairro			= $_POST["txtBairro"];
$complemento	= $_POST["txtComplemento"];
$cep			= $_POST["txtCEP"];
$fone			= $_POST["txtFone"];
$fone_adicional	= $_POST["txtFoneAdicional"];
$uf				= $_POST["txtInsUfOrgao"];
$municipio		= $_POST["txtInsMunicipioEmpresa"];
$admpublica		= $_POST["cmbAdmPublica"];
$nivel			= $_POST["cmbNivel"];
$diretor		= $_POST["txtInsDiretor"];
$diretorcpf		= $_POST["txtInsCPFDiretor"];
$responsavel	= $_POST["txtInsResponsavel"];
$responsavelcpf	= $_POST["txtInsCPFResponsavel"];
$email			= $_POST["txtInsEmailOrgao"];
$senha			= $_POST["txtSenha"];
$senhaconf		= $_POST["txtSenhaConf"];

//verifica se ja tem o cnpj no banco
$sql = mysql_query("SELECT cnpj FROM cadastro WHERE cnpj='$cnpj'");
if(mysql_num_rows($sql)!=0){
	Mensagem("CNPJ ja cadastrado, verifique se o mesmo esta correto.");
}else{
	
	$codtipo = codtipo("orgao_publico");
	$codtipodec = coddeclaracao('DES Consolidada');
	$campo = tipoPessoa($cnpj);
	$sql=mysql_query("
		INSERT INTO cadastro SET
		codtipo='$codtipo', codtipodeclaracao = '$codtipodec', nome='$nome', razaosocial='$razaosocial', $campo='$cnpj', senha=md5('$senha'), logradouro='$logradouro',
		numero='$numero', complemento='$complemento', bairro='$bairro', cep='$cep', municipio='$municipio', uf='$uf',
		email='$email', fonecomercial='$fone', fonecelular='$fone_adicional'
	");
	if(!$sql)die(mysql_error());
	//pega o codigo recem cadastrado
	$sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$cnpj'");
	list($cod_dop)=mysql_fetch_array($sql);
	
	//depois de cadastrada a empresa envia-se um passo a passo com  senha para a empresa cadastrada
	$sql_url_site = mysql_query("SELECT site FROM configuracoes");
	list($LINK_ACESSO) = mysql_fetch_array($sql_url_site);
	
	$msg = "O cadastro da empresa $nome foi efetuado com sucesso.<br>
	Dados da empresa:<br><br>
	Razão Social: $razaosocial<br>
	CPF/CNPJ: $cpfcnpj<br>
	Município: $municipio<br>
	Endereco: $logradouro, $numero<br><br>
	  
	Veja passo a passo como acessar o sistema:	<br><br>
	1- Acesse o site <a href=\"$LINK_ACESSO\"><b>ISS Digital</b></a><br>
	2- Clique no link Órgão Público<br>
	3- Clique em consultar, coloque seu CPF/CNPJ e verifique se ja foi liberado o acesso ao sistema<br>
	4- Entre em acessar o sistema<br>
	5- Em login insira o cpf/cnpf da empresa<br>
	6- Sua senha é <b><font color=\"RED\">$senha</font></b><br>
	7- Insira o código de verificação que aparece ao lado<br>";
	
	$assunto = "Acesso ao Sistema ISSdigital ($CONF_CIDADE).";

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	$headers .= "From: $CONF_SECRETARIA de $CONF_CIDADE <$CONF_EMAIL>  \r\n";

	$headers .= "Cc: \r\n";

	$headers .= "Bcc: \r\n";
	
	mail("$email",$assunto,$msg,$headers);
	
	//insere as informacoes restantes nas outras tabelas
	mysql_query("INSERT INTO orgaospublicos SET codcadastro='$cod_dop', admpublica='$admpublica', nivel='$nivel'");

	
	//pega do banco o codigo dos cargos
	//insere os dados do diretor e do responsavel do orgao publico
	$cargo_diretor=codcargo("Diretor");
	mysql_query("INSERT INTO cadastro_resp SET codemissor='$cod_dop', codcargo='$cargo_diretor', nome='$diretor', cpf='$diretorcpf'");
	$cargo_responsavel=codcargo("Responsavel");
	mysql_query("INSERT INTO cadastro_resp SET codemissor='$cod_dop', codcargo='$cargo_responsavel', nome='$responsavel', cpf='$responsavelcpf'");
	
	Mensagem("Orgão Público Cadastrado! Não esqueça de Imprimir o comprovante de cadastro que abrira em uma nova janela!");
	?>
	<form method="post" id="frmComprovante" action="../include/dop/comprovante.php" target="_blank">
		<input type="hidden" value="<?php echo $cnpj;?>" name="txtCNPJ">
	</form>
	<script>document.getElementById('frmComprovante').submit();</script>
	<?php
	Redireciona("dop.php");
}//fim do if para gravar no banco.

?>
