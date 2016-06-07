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
 <form  method="post" name="frmCadastro" id="frmCadastro">
		  <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
 </form>		  

<?php 

// Pega as variaveis que vieram por POST
$nome =$_POST['txtInsNomeEmpresa'];
$razaosocial =$_POST['txtInsRazaoSocial'];
$cpfcnpj = $_POST['txtInsCpfCnpjEmpresa'];
$endereco=$_POST['txtInsEnderecoEmpresa'];
$inscricaomunicipal=$_POST['txtInsInscMunicipalEmpresa'];
$email=$_POST['txtInsEmailEmpresa'];
$tipopessoa= $_POST['cmbTipoPessoaEmpresa'];
$municipio = $_POST['txtInsMunicipioEmpresa'];
$login = $_POST['txtInsCpfCnpjEmpresa'];
$senha = md5("123456");
$simplesnacional = $_POST['txtSimplesNacional'];
$CODCAT = $_POST['txtMAXCODIGOCAT'];
$nfe = $_POST['txtNfe'];
$uf = $_POST['txtInsUfEmpresa'];
$btCadastrarEmpresa="Cadastrar";
if ($simplesnacional == "")
{
 $simplesnacional = "N";
}

	$sql=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	list($maxcodigo)=mysql_fetch_array($sql);
	$sql_categoria=mysql_query("SELECT codigo FROM servicos_categorias WHERE nome ='Contábil'");	
	list($codigocategoria)=mysql_fetch_array($sql_categoria);
	$categoria=1;
	$servico=1;
	$tipo="empresa";
	while($servico<=5)
		{
			$nomecategoria=explode("|",$_POST['cmbCategoria'.$servico]);
			if($nomecategoria[0]=="$codigocategoria")
				{
					$tipo="contador";					
				}
					
			while($categoria<=$maxcodigo)
				{
					if($_POST['cmbCodigo'.$categoria.$servico]!=""){$cmbCodigo="qualquercoisa";}
					$categoria++;	
				}	
			$servico++;	
		}
		


//Verifica os campos obrigatórios
if(($nome !="") &&($razaosocial !="") &&($endereco !="") && ($municipio != "") && ($txtNomeSocio1 != "")&& ($txtCpfSocio1 != "")&& 
($cpfcnpj !="")&& ($email !="")&&($cmbCodigo!="")) {
  
    //Verifica se o login ja existe e se não há nenhuma empresa cadastrada com o mesmo nome e/ou cnpj
	$teste_login=mysql_query("SELECT codigo FROM usuarios WHERE login='$login'");
	$teste_nome=mysql_query("SELECT codigo FROM emissores WHERE nome='$nome'");
	$teste_razaosocial=mysql_query("SELECT codigo FROM emissores where razaosocial='$razaosocial'");
	$teste_cnpj=mysql_query("SELECT codigo FROM emissores WHERE cnpjcpf='$cpfcnpj'");
	if(mysql_num_rows($teste_login)>0)
		{
			echo "
				<script>
					alert('Já existe uma empresa com este login');
					document.getElementById('frmCadastro').submit();
				</script>
			";
		}
	elseif(mysql_num_rows($teste_nome)>0)
		{
			echo "	
				<script>
					alert('Já existe uma empresa com este nome');
					document.getElementById('frmCadastro').submit();
				</script>
			";
		}	
	elseif(mysql_num_rows($teste_razaosocial)>0)
		{
			echo "	
				<script>
					alert('Já existe uma empresa com esta razão social');
					document.getElementById('frmCadastro').submit();
				</script>
			";
		}	
	elseif(mysql_num_rows($teste_cnpj)>0)
		{
			echo "	
				<script>
					alert('Já existe uma empresa com este CPF/CNPJ');
					document.getElementById('frmCadastro').submit();
				</script>
			";
		}
	else{		
   
	// Insere o usuário no banco de dados
	
 	 	
	 $sql_login = mysql_query("INSERT INTO usuarios SET nome = '$nome', login = '$cpfcnpj', senha = '$senha', tipo = '$tipo'");
	 add_logs('Efetuou Login para o Cadastro');
	
	  
	// insere a empresa no banco
	$sql = mysql_query("INSERT INTO emissores SET nome='$nome', razaosocial='$razaosocial', cnpjcpf= '$cpfcnpj',
	endereco='$endereco', inscrmunicipal='$inscricaomunicipal',  municipio ='$municipio', estado='A', nfe='$nfe', email='$email',uf='$uf', ultimanota= 0,simplesnacional = '$simplesnacional'");	
	add_logs('Inseriu uma Nova Empresa');
	
	
	
	//depois de cadastrada a empresa envia-se um passo a passo com  senha para a empresa cadastrada

	$msg ="O cadastro da empresa $nome foi efetuado com sucesso.<br>
	Dados da empresa:<br><br>
	Razão Social: $razaosocial<br>
	CPF/CNPJ: $cpfcnpj<br>
	Município: $municipio<br>
	Endereco: $endereco<br>
	Senha de acesso: $senha<br><br>
	  
	Veja passo a passo como acessar o sistema:	<br><br>
 	1- Acesse o site $LINK<br>
	2- Clique no link prestadores<br>
	3- Clique na imagem em acessar NF-e<br>
	4- Em login insira o cpf/cnpf da empresa<br>
	5- Sua senha é <b><font color=\"RED\">$senha</font></b><br>
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
	$sql_empresa = mysql_query("SELECT codigo FROM emissores WHERE nome = '$nome' ORDER BY CODIGO DESC LIMIT 0,1");
	list($CODEMPRESA) = mysql_fetch_array($sql_empresa);

	


	// INSERCAO DE SERVICOS POR EMPRESA INICIO----------------------------------------------------------------------------------		
		$nroservicos = 5;
		//$vetor_servicos = array($cmbCodigo1,$cmbCodigo2,$cmbCodigo3,$cmbCodigo4,$cmbCodigo5);		
	//Insere os servicos no banco...		
		
		//vetores para adicionar servicos
		 $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias");
		 
		 $contpos=0;
		 while(list($codcategoria)=mysql_fetch_array($sql_categoria))
		 {   
		   $conts=1;
		   for($conts=1;$conts<=5;$conts++)
		   {    
				$vetor_insere_servico[$contpos]=$_POST['cmbCodigo'.$codcategoria.$conts];
				if($_POST['cmbCodigo'.$codcategoria.$conts])
				{
				 $sql = mysql_query("INSERT INTO emissores_servicos SET codservico = '".$_POST['cmbCodigo'.$codcategoria.$conts]."', codemissor='$CODEMPRESA'");
				 add_logs('Inseriu Novo serviço');	
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
			$sql = mysql_query("INSERT INTO emissores_socios SET codemissor='$CODEMPRESA', nome = '$vetor_sociosnomes[$contsocios]', cpf = '$vetor_socioscpf[$contsocios]'");
			add_logs('Inseriu Novo Sócio');	
		} // fim if	
		$contsocios++;
   } // fim while   
   	// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM
   
   print "<script language=JavaScript> alert('Empresa Inserida Com Sucesso!!');document.getElementById('frmCadastro').submit();</script>";  
  
  
}} // fim if Verifica se os campos foram preenchidos.
else
{
  print "<script language=JavaScript> alert('Favor preencher campos obrigatórios');document.getElementById('frmCadastro').submit();</script>";
}



?>
