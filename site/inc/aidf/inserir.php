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
include("../../../funcoes/util.php");

// Pega as variaveis que vieram por POST
$nome               = trataString($_POST['txtInsNomeEmpresa']);
$razaosocial        = trataString($_POST['txtInsRazaoSocial']);
$cpfcnpj            = $_POST['txtCNPJ'];
$logradouro         = trataString($_POST['txtLogradouro']);
$numero             = trataString($_POST['txtNumero']);
$complemento        = trataString($_POST['txtComplemento']);
$bairro             = trataString($_POST['txtBairro']);
$cep                = $_POST['txtCEP'];
$fone               = $_POST['txtFoneComercial'];
$celular            = $_POST['txtFoneCelular'];
$inscricaomunicipal = trataString($_POST['txtInsInscMunicipalEmpresa']);
$email              = trataString($_POST['txtInsEmailEmpresa']);
$tipopessoa         = trataString($_POST['cmbTipoPessoaEmpresa']);
$municipio          = $_POST['txtInsMunicipioEmpresa'];
$senha              = md5(trataString($_POST['txtSenha']));
$senha_original		= trataString($_POST['txtSenha']);
$CODCAT             = $_POST['txtMAXCODIGOCAT'];
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
		if($_POST['cmbCodigo'.$categoria.$servico]!=""){
			$cmbCodigo="qualquercoisa";
		}
		$categoria++;	
	}	
	$servico++;	
}

// verifca se o valor da variavel cpfcnpj e valido como cpf ou cmpj
if((strlen($cpfcnpj)!=14)&&(strlen($cpfcnpj)!=18)){
	echo "
		<script>
			alert('O CPF/CNPJ informado não é válido');
			window.location='../../aidf.php';
		</script>
	";
}

//Verifica se não há nenhuma empresa cadastrada com o mesmo nome e/ou cnpj
$campo=tipoPessoa($cpfcnpj);
$teste_nome        = mysql_query("SELECT codigo FROM cadastro WHERE nome = '$nome'");
$teste_razaosocial = mysql_query("SELECT codigo FROM cadastro WHERE razaosocial = '$razaosocial'");
$teste_cnpj        = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cpfcnpj'");
if(mysql_num_rows($teste_nome)>0){
	echo "	
		<script>
			alert('Já existe um prestador de serviços com este nome');
			window.location='../../aidf.php';
		</script>
	";
}elseif(mysql_num_rows($teste_razaosocial)>0){
	echo "	
		<script>
			alert('Já existe um prestador de serviços com esta razão social');
			window.location='../../aidf.php';
		</script>
	";
}elseif(mysql_num_rows($teste_cnpj)>0){
	echo "	
		<script>
			alert('Já existe um prestador de serviços com este CPF/CNPJ');
			window.location='../../aidf.php';
		</script>
	";
}else{		
   	
	// insere a empresa no banco
	$codtipo=codtipo("grafica");
	if($_POST['txtSimplesNacional']){
		$coddeclaracao=coddeclaracao("Simples Nacional");
	}else{
		$coddeclaracao=coddeclaracao("DES Consolidada");	
	}//testa se é simples nacional
	mysql_query("INSERT INTO cadastro SET 
				codtipo='$codtipo',
				codtipodeclaracao='$coddeclaracao',
				nome='$nome',
				senha = '$senha',
				razaosocial='$razaosocial',
				$campo= '$cpfcnpj',
				logradouro='$logradouro',
				numero='$numero',
				complemento='$complemento',
				bairro='$bairro',
				cep='$cep',
				inscrmunicipal='$inscricaomunicipal',
				municipio ='$municipio',
				estado='NL',
				nfe='n',
				email='$email',
				uf='$uf',
				ultimanota= 0,
				fonecomercial = '$fone',
				fonecelular = '$celular'") or die(mysql_error()); 
	
	
	
	//depois de cadastrada a empresa envia-se um passo a passo com  senha para a empresa cadastrada

	$msg ="O cadastro da empresa $nome foi efetuado com sucesso.<br>
	Dados da empresa:<br><br>
	Razão Social: $razaosocial<br>
	CPF/CNPJ: $cpfcnpj<br>
	Município: $municipio<br>
	Endereco: $endereco<br>
	Senha de acesso: $senha_original<br><br>
	  
	Veja passo a passo como acessar o sistema:	<br><br>
	1- Acesse o site $LINK<br>
	2- Clique no link prestadores<br>
	3- Clique na imagem em acessar NF-e<br>
	4- Em login insira o cpf/cnpf da empresa<br>
	5- Sua senha é <b><font color=\"RED\">$senha_original</font></b><br>
	6- Insira o código de verificação que aparece ao lado<br>
	7- Depois de ter acessado o sistema, vá no link usuário e troque sua senha<br>";	
	
	$assunto = "Acesso ao Sistema NF-e ($PREFEITURA).";

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	$headers .= "From: $EMAIL \r\n";

	$headers .= "Cc: \r\n";

	$headers .= "Bcc: \r\n";
	
	mail("$email",$assunto,$msg,$headers);
	
	
		
	
	// busca empresa no banco --------------------------------------------------------------------------------------------------		
	$sql_empresa = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cpfcnpj'");
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
					$sql = mysql_query("INSERT INTO cadastro_servicos
										SET codservico = '".$_POST['cmbCodigo'.$codcategoria.$conts]."',
										codemissor='$CODEMPRESA'");
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
	while($contsocios < $nrosocios) {   
		if($vetor_sociosnomes[$contsocios] != "") {
			if($contsocios==0){
				$sql_cargo=mysql_query("SELECT codigo FROM cargos WHERE cargo='Responsável'");
			}else{
				$sql_cargo=mysql_query("SELECT codigo FROM cargos WHERE cargo='Sócio'");
			}
			list($codcargo)=mysql_fetch_array($sql_cargo);
			$sql = mysql_query("INSERT INTO cadastro_resp
								SET codemissor='$CODEMPRESA',
								nome = '$vetor_sociosnomes[$contsocios]',
								cpf = '$vetor_socioscpf[$contsocios]',
								codcargo = '$codcargo'");
		} // fim if	
		$contsocios++;
   } // fim while   
	// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM
   
	//gera o comprovante em pdf 
	$CodEmp = base64_encode($CODEMPRESA);
	
	print "
		<script language=JavaScript> 
			alert('Empresa cadastrada! Não esqueça de Imprimir o comprovante de cadastro que abrirá em uma nova janela!');
			window.open('../../../reports/cadastro_comprovante.php?COD=$CodEmp');
			window.location='../../aidf.php';
		</script>
	"; 
}
?>
