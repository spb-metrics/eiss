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
	// recebe os dados do formulario
	
	$nome=strip_tags(addslashes($_POST["txtNome"]));
	$razaosocial=strip_tags(addslashes($_POST["txtRazao"]));
	$cnpj=strip_tags(addslashes($_POST["txtCNPJ"]));
	$diretor=strip_tags(addslashes($_POST["txtDiretor"]));
	$diretor_cpf=$_POST["txtCpfDiretor"];
	$responsavel=strip_tags(addslashes($_POST["txtResponsavel"]));
	$responsavel_cpf=$_POST["txtCpfResponsavel"];
	$inscr_municipal=strip_tags(addslashes($_POST["txtInscrMunicipal"]));
	$logradouro=strip_tags(addslashes($_POST["txtLogradouro"]));
	$logradouronro=strip_tags(addslashes($_POST["txtLogradouroNro"]));
	$bairro=strip_tags(addslashes($_POST["txtBairro"]));
	$complemento=strip_tags(addslashes($_POST["txtComplemento"]));
	$municipio=$_POST["txtInsMunicipioEmpresa"];
	$cep=strip_tags(addslashes($_POST["txtCEP"]));
	$uf=$_POST["txtUfEmpresa"];
	$email=strip_tags(addslashes($_POST["txtEmail"]));
	$fone1=strip_tags(addslashes($_POST["txtFone1"]));
	$fone2=strip_tags(addslashes($_POST["txtFone2"]));
	$admpublica=$_POST["cmbAdmPublica"];
	$nivel=$_POST["cmbNivel"];
	$senha=strip_tags(addslashes($_POST["txtSenha"]));
	$senhaconf=strip_tags(addslashes($_POST["txtSenhaConf"]));
	
	// verifica se já há algum cartorio cadastrado com o cnpj indicado. caso ñ haja, faz o cadastro 
	$sql_verifica=mysql_query("SELECT cnpj FROM cadastro WHERE cnpj='$cnpj'");
	if(mysql_num_rows($sql_verifica)>0)
		{
			Mensagem("Já existe um Cartório cadastrado com este CNPJ");
		}
	else
		{
			$tipocartorio = codtipo('cartorio');
			$codtipodec = coddeclaracao('DES Consolidada');
			$campo = tipoPessoa($cnpj);
			
			// adiciona no banco o cartorio
			mysql_query("INSERT INTO cadastro 
							SET 
							codtipo='$tipocartorio',
							codtipodeclaracao = '$codtipodec',
							nome='$nome',
							razaosocial='$razaosocial',
							$campo='$cnpj',
							inscrmunicipal='$inscr_municipal',
							numero='$logradouronro',
							bairro='$bairro',
							complemento='$complemento',
							cep='$cep',
							logradouro='$logradouro',
							municipio='$municipio',
							uf='$uf',
							email='$email',
							fonecomercial='$fone1',
							fonecelular='$fone2',
							senha=md5('$senha'),
							estado='NL'
			");		
			
			
			
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
		2- Clique no link Cartório<br>
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
			
			// seleciona o cartorio adicionado
			$sql_busca=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$cnpj'");
			list($codigo)=mysql_fetch_array($sql_busca);
			// insere nas outras tabelas s dados restantes do cadastro
			$resp=codcargo('responsavel');
			$diret=codcargo('diretor');
			mysql_query("INSERT INTO cartorios SET codcadastro='$codigo', admpublica='$admpublica', nivel='$nivel'");
			mysql_query("INSERT INTO cadastro_resp SET codemissor='$codigo', codcargo='$diret', nome='$diretor', cpf='$diretor_cpf'");
			mysql_query("INSERT INTO cadastro_resp SET codemissor='$codigo', codcargo='$resp', nome='$responsavel', cpf='$responsavel_cpf'");
			
			Mensagem("Cadastro efetuado com sucesso!");
			?>
				<div style="display:none">
					<form name="frmComprovante" id="teste" method="post" action="../include/dec/comprovante.php" target="_blank">
						<input type="text" name="hdCnpj" id="hdCnpj" value="<?php echo $cnpj; ?>" />
					</form>
				</div>	
				<script language="javascript" type="text/javascript">document.getElementById('teste').submit();</script>			
			<?php
			Redireciona("dec.php");
		}
?>
