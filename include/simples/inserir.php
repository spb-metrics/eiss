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
	include("../conect.php");
	include("../../funcoes/util.php");
	// Pega as variaveis que vieram por POST
	$nome               = $_POST['txtInsNomeEmpresa'];
	$razaosocial        = $_POST['txtInsRazaoSocial'];
	$cpfcnpj            = $_POST['txtCNPJ'];
	$endereco           = $_POST['txtInsEnderecoEmpresa'];
	$numero				= $_POST['txtInsNumeroEmpresa'];
	$complemento		= $_POST['txtInsComplementooEmpresa'];
	$bairro				= $_POST['txtBairro'];
	$CEP				= $_POST['txtCEP'];
	$fone               = $_POST['txtFoneComercial'];
	$celular            = $_POST['txtFoneCelular'];
	$inscricaomunicipal = $_POST['txtInsInscMunicipalEmpresa'];
	$pispasep			= $_POST['txtPispasep'];
	$email              = $_POST['txtInsEmailEmpresa'];
	$tipopessoa         = $_POST['cmbTipoPessoaEmpresa'];
	$municipio          = $_POST['txtInsMunicipioEmpresa'];
	$login              = $_POST['txtInsCpfCnpjEmpresa'];
	$senha              = $_POST['txtSenha'];
	$CODCAT             = $_POST['txtMAXCODIGOCAT'];
	$nfe                = $_POST['txtNfe'];
	$uf                 = $_POST['txtInsUfEmpresa'];
	$btCadastrarEmpresa = "Cadastrar";

	$sql=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	list($maxcodigo)=mysql_fetch_array($sql);
	$sql_categoria=mysql_query("SELECT codigo FROM servicos_categorias WHERE nome ='Contábil'");	
	list($codigocategoria)=mysql_fetch_array($sql_categoria);
	$categoria=1;
	$servico=1;
	$tipo="empresa";
	while($servico<=5){
		$nomecategoria=explode("|",$_POST['cmbCategoria'.$servico]);
		if($nomecategoria[0]=="$codigocategoria"){
				$tipo="contador";					
		}
				
		while($categoria<=$maxcodigo){
			if($_POST['cmbCodigo'.$categoria.$servico]!=""){$cmbCodigo="qualquercoisa";}
			$categoria++;	
		}	
		$servico++;	
	}
		

    //Verifica se o login ja existe e se não há nenhuma empresa cadastrada com o mesmo nome e/ou cnpj
	//$teste_login       = mysql_query("SELECT codigo FROM cadastro WHERE login = '$login'");
	$teste_nome        = mysql_query("SELECT codigo FROM cadastro WHERE nome = '$nome'");
	$teste_razaosocial = mysql_query("SELECT codigo FROM cadastro WHERE razaosocial = '$razaosocial'");
	$teste_cnpj        = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cpfcnpj' OR cpf='$cpfcnpj'");
	
	/*if(mysql_num_rows($teste_login)>0){
		echo "
			<script>
				alert('Já existe uma empresa com este login!');
				window.location='../../simples.php';
			</script>
		";
	}else*/
	if(mysql_num_rows($teste_nome)>0){
		echo "	
			<script>
				alert('Já existe uma empresa com este nome!');
				window.location='../../simples.php';
			</script>
		";
	}elseif(mysql_num_rows($teste_razaosocial)>0){
		echo "	
			<script>
				alert('Já existe uma empresa com esta razão social!');
				window.location='../../simples.php';
			</script>
		";
	}elseif(mysql_num_rows($teste_cnpj)>0){
		echo "	
			<script>
				alert('Já existe uma empresa com este CPF/CNPJ!');
				window.location='../../simples.php';
			</script>
		";
	}else{		
	   $tipocnpjcpf=(strlen($cpfcnpj)==18)?'cnpj':'cpf';
		// insere a empresa no banco e com os seguites padroes: estado = NL e nfe = n
	   $sql = mysql_query("
			INSERT INTO 
				cadastro 
			SET 
				codtipo=(SELECT codigo FROM tipo WHERE tipo='prestador'),
				codtipodeclaracao=(SELECT codigo FROM declaracoes WHERE declaracao='Simples Nacional'),
				nome='$nome', 
				senha = md5('$senha'), 
				razaosocial='$razaosocial', 
				$tipocnpjcpf = '$cpfcnpj',
				logradouro='$endereco',
				numero = '$numero',
				complemento = '$complemento', 
				bairro='$bairro',
				cep='$CEP',
				inscrmunicipal='$inscricaomunicipal',  
				municipio ='$municipio', 
				estado='NL', 
				nfe='n', 
				email='$email',
				uf='$uf', 
				ultimanota= 0,
				fonecomercial = '$fone', 
				fonecelular = '$celular',
				pispasep='$pispasep'
		")or die(mysql_error());
		
		
		
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
		2- Clique no link Simples Nacional<br>
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
		
		
			
		
		// busca empresa no banco --------------------------------------------------------------------------------------------------		
		$sql_empresa = mysql_query("SELECT codigo FROM cadastro WHERE nome = '$nome' ORDER BY CODIGO DESC LIMIT 0,1");
		list($CODEMPRESA) = mysql_fetch_array($sql_empresa);
	
		
	
		// INSERCAO DE SERVICOS POR EMPRESA INICIO----------------------------------------------------------------------------------		
			$nroservicos = 5;
			//$vetor_servicos = array($cmbCodigo1,$cmbCodigo2,$cmbCodigo3,$cmbCodigo4,$cmbCodigo5);		
		//Insere os servicos no banco...		
			
			//vetores para adicionar servicos
			 $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias");
			 
			 $contpos=0;
			 while(list($codcategoria)=mysql_fetch_array($sql_categoria)) {   
			   $conts=1;
			   for($conts=1;$conts<=5;$conts++) {    
					$vetor_insere_servico[$contpos]=$_POST['cmbCodigo'.$codcategoria.$conts];
					if($_POST['cmbCodigo'.$codcategoria.$conts]){
						$sql = mysql_query("INSERT INTO cadastro_servicos SET codservico = '".$_POST['cmbCodigo'.$codcategoria.$conts]."', codemissor='$CODEMPRESA'");
					} 
					$contpos++;	
			   }		
			 }			
			
			
		// INSERCAO DE SERVICOS POR EMPRESA FIM
	
		// INSERCAO DE RESP/SOCIOS POR EMPRESA INICIO-------------------------------------------------------------------------------
		$contsocios = 0;
		$nrosocios = 10;
		
		$vetor_sociosnomes = array($txtNomeSocio1,$txtNomeSocio2,$txtNomeSocio3,$txtNomeSocio4,$txtNomeSocio5,$txtNomeSocio6,$txtNomeSocio7,$txtNomeSocio8,$txtNomeSocio9,$txtNomeSocio10);	
		$vetor_socioscpf = array($txtCpfSocio1,$txtCpfSocio2,$txtCpfSocio3,$txtCpfSocio4,$txtCpfSocio5,$txtCpfSocio6,$txtCpfSocio7,$txtCpfSocio8,$txtCpfSocio9,$txtCpfSocio10);	
	   //insere os socios no banco
	   $socio=codcargo('responsavel');
		while($contsocios < $nrosocios) {   
			if($vetor_sociosnomes[$contsocios] != "") {
				
				$sql = mysql_query("
					INSERT INTO 
						cadastro_resp 
					SET 
						codemissor='$CODEMPRESA', 
						codcargo='$socio', 
						nome = '{$vetor_sociosnomes[$contsocios]}', 
						cpf = '{$vetor_socioscpf[$contsocios]}'
				");
				$socio=codcargo('socio');
			} // fim if	
			$contsocios++;
	   } // fim while   
		// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM
		//gera o comprovante em pdf   
		print "<script language=JavaScript>alert('Cadastro feito com sucesso!!');window.location='../../site/simples.php'</script>"; 
	}
?>
