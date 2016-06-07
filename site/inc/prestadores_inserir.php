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
// Pega as variaveis que vieram por POST
$nome =$_POST['txtInsNomeEmpresa'];
$razaosocial =$_POST['txtInsRazaoSocial'];
$cpfcnpj = $_POST['txtInsCpfCnpjEmpresa'];
$endereco=$_POST['txtInsEnderecoEmpresa'];
$inscricaomunicipal=$_POST['txtInsInscMunicipalEmpresa'];
$email=$_POST['txtInsEmailEmpresa'];
$tipopessoa= $_POST['cmbTipoPessoaEmpresa'];
$municipio = $_POST['txtInsMunicipioEmpresa'];
$uf = $_POST['txtInsUfEmpresa'];
$senha = md5($_POST['txtSenha']);
$senha_original = $_POST['txtSenha'];
$CODCAT = $_POST['txtMAXCODIGOCAT'];
$simplesnacional = $_POST['txtSimplesNacional'];
if ($simplesnacional == "")
{
 $simplesnacional = "N";
}

	$sql=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	list($maxcodigo)=mysql_fetch_array($sql);
	$categoria=1;
	$servico=1;
	while($servico<=5)
		{
			while($categoria<=$maxcodigo)
				{
					if($_POST['cmbCodigo'.$categoria.$servico]!=""){$cmbCodigo="qualquercoisa";}
					$categoria++;	
				}	
			$servico++;	
		}


//Verifica os campos obrigatórios
if(($nome !="") && ($razaosocial !="") && ($endereco !="") && ($municipio != "") && ($uf != "") && ($txtNomeSocio1 != "") && ($txtCpfSocio1 != "") && ($cpfcnpj !="") && ($email !="") && ($txtSenha !="") && ($txtSenhaConf == $txtSenha )&&($cmbCodigo!="")) {
	
	$sql_teste1=mysql_query("SELECT cnpjcpf FROM cadastro_emissores WHERE cnpjcpf='$cpfcnpj'");
	$sql_teste2=mysql_query("SELECT cnpjcpf FROM emissores WHERE cnpjcpf='$cpfcnpj'");
	if((mysql_num_rows($sql_teste1)>0)||(mysql_num_rows($sql_teste2)>0))
		{
			echo "
				<script>
					alert('Já existe um prestador de serviços cadastrado com esse CNPJ / CPF');
					window.location='../index.php';
				</script>
			";
		}
	else{	
	// insere a empresa no banco
	$sql = mysql_query("INSERT INTO cadastro_emissores SET nome='$nome', razaosocial='$razaosocial', cnpjcpf= '$cpfcnpj',
	endereco='$endereco', inscrmunicipal='$inscricaomunicipal',  municipio ='$municipio', email='$email',uf='$UF', senha='$txtSenha', simplesnacional = '$simplesnacional', tipo='empresa'");		
	
	
	// busca empresa no banco --------------------------------------------------------------------------------------------------		
	$sql_empresa = mysql_query("SELECT codigo FROM cadastro_emissores WHERE nome = '$nome'");
	list($CODEMPRESA) = mysql_fetch_array($sql_empresa);

	// INSERCAO DE SERVICOS POR EMPRESA INICIO----------------------------------------------------------------------------------
		$contservicos = 0;
		$nroservicos = 5;
		$vetor_servicos = array($cmbCodigo1,$cmbCodigo2,$cmbCodigo3,$cmbCodigo4,$cmbCodigo5);
		
	//Insere os servicos no banco...
		while($contservicos < $nroservicos) {   
			if($vetor_servicos[$contservicos] != "") { 	    
				$sql = mysql_query("INSERT INTO cadastro_emissores_servicos SET codservico = '$vetor_servicos[$contservicos]', codemissor='$CODEMPRESA'");	
			} // fim if	
			$contservicos++;
	   } // fim while 
   	// INSERCAO DE SERVICOS POR EMPRESA FIM

	// INSERCAO DE RESP/SOCIOS POR EMPRESA INICIO-------------------------------------------------------------------------------
	$contsocios = 0;
	$nrosocios = 10;
	
	$vetor_sociosnomes = array($txtNomeSocio1,$txtNomeSocio2,$txtNomeSocio3,$txtNomeSocio4,$txtNomeSocio5,$txtNomeSocio6,$txtNomeSocio7,$txtNomeSocio8,$txtNomeSocio9,$txtNomeSocio10);
	
	$vetor_socioscpf = array($txtCpfSocio1,$txtCpfSocio2,$txtCpfSocio3,$txtCpfSocio4,$txtCpfSocio5,$txtCpfSocio6,$txtCpfSocio7,$txtCpfSocio8,$txtCpfSocio9,$txtCpfSocio10);
	
   //insere os socios no banco
		while($CODCAT > 0)
		{
		    $contservicos = 0;
			while($contservicos < $nroservicos)
			{   			    
				if($_POST['cmbCodigo'.$CODCAT.$contservicos] != "") 
				{ 
				  $sql = mysql_query("INSERT INTO emissores_servicos SET codservico = '".$_POST['cmbCodigo'.$CODCAT.$contservicos]."', codemissor='$CODEMPRESA'");
				} // fim if	
				$contservicos++;
		   } // fim while 
		   $CODCAT--;
		}  
   	// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM
    
	//gera o comprovante em pdf   
   	print "<script language=JavaScript> alert('Cadastro feito com sucesso!!');window.open('gerapdf.php?CODEMPRESA=$CODEMPRESA');</script>"; 

  
}} // fim if Verifica se os campos foram preenchidos.
else
{
  print "<script language=JavaScript> alert('Favor preencher campos obrigatórios');</script>";
}


?>
