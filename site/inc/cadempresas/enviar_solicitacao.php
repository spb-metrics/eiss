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

// Pega as variaveis que vieram por POST do arquivo requerimento_viabilidade.php
$nome               = $_POST['txtNome'];
$razaosocial        = $_POST['txtRazao'];
$cpfcnpj            = $_POST['txtCNPJ'];
$logradouro         = $_POST['txtLogradouro'];
$numero             = $_POST['txtNumero'];
$complemento        = $_POST['txtComplemento'];
$bairro             = $_POST['txtBairro'];
$cep                = $_POST['txtCEP'];
$fone               = $_POST['txtFoneComercial'];
$celular            = $_POST['txtFoneCelular'];
$inscricaomunicipal = $_POST['txtInscrMunicipal'];
$email              = $_POST['txtEmail'];
$tipopessoa         = $_POST['cmbTipoPessoaEmpresa'];
$municipio          = $_POST['txtInsMunicipioEmpresa'];
$simplesnacional    = $_POST['txtSimplesNacional'];
$CODCAT             = $_POST['txtMAXCODIGOCAT'];
$nfe                = $_POST['txtNfe'];
$uf                 = $_POST['txtInsUfEmpresa'];

	//Verifica se o formato do cnpj ou cpf eh valido
    if((strlen($cpfcnpj)!=14)&&(strlen($cpfcnpj)!=18)){
        Mensagem('O CPF/CNPJ informado não é válido');
		Redireciona('../../cadempresas.php');
		
    }

    //Verifica se nao ha nenhuma empresa cadastrada com o mesmo nome e/ou cnpj
    $campo = tipoPessoa($cpfcnpj);
	$teste_nome        = mysql_query("SELECT codigo FROM cadastro WHERE nome = '$nome'");
	$teste_razaosocial = mysql_query("SELECT codigo FROM cadastro WHERE razaosocial = '$razaosocial'");
	$teste_cnpj        = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cpfcnpj'");
	if(mysql_num_rows($teste_nome)>0){
		Mensagem('Já existe um prestador de serviços com este nome');
		Redireciona('../../cadempresas.php');
		
	}elseif(mysql_num_rows($teste_razaosocial)>0){
		Mensagem('Já existe um prestador de serviços com esta razão social');
		Redireciona('../../cadempresas.php');
		
	}elseif(mysql_num_rows($teste_cnpj)>0){
		Mensagem('Já existe um prestador de serviços com este CPF/CNPJ');
		Redireciona('../../cadempresas.php');
		
	}else{
	   
		//Verifica o e-mail da prefeitura na tabela configuracoes
		$sql_emailpref = mysql_query("SELECT email FROM configuracoes");
		list($EMAIL_PREF) = mysql_fetch_array($sql_emailpref);
		
		//Verifica se o prestador eh simples nacional ou nao
		if($simplesnacional){
			$tipodec_str = "Simples Nacional";
		}else{
			$tipodec_str = "DES Simplificada";
		}
		
		//Inicia o contador e a variavel que recebera os servicos
		$lista_servico = "";
		$contpos=0;
		
		$sql_categoria=mysql_query("SELECT codigo, nome FROM servicos_categorias");
		while(list($codcategoria)=mysql_fetch_array($sql_categoria)) {   
			$conts=1;
			for($conts=1;$conts<=5;$conts++) {    
				$vetor_insere_servico[$contpos]=$_POST['cmbCodigo'.$codcategoria.$conts];
				if($_POST['cmbCodigo'.$codcategoria.$conts]){
					//Se existir servico pega-se o codigo e busca seus dados no banco e o codigo da categoria
					$cod = $_POST['cmbCodigo'.$codcategoria.$conts];
					$sql_servico = mysql_query("SELECT codservico, descricao, codcategoria FROM servicos WHERE codigo = '$cod'");
					list($codservico,$desc,$codcate) = mysql_fetch_array($sql_servico);
					
					//Busca o nome da categoria referente ao servico selecionado
					$sql_categoria = mysql_query("SELECT nome FROM servicos_categorias WHERE codigo = '$codcate'");
					list($nomecate) = mysql_fetch_array($sql_categoria);
					
					//Recebe na variavel os servicos concatenados com suas respectivas categorias
					$lista_servico .= $nomecate."<br>".$codservico." - ".$desc."<br><br>";
				} 
			$contpos++;	
			}		
		}			
		
		//Gera o e-mail que sera enviado para a prefeitura	
		$msg ="
			Foi enviado um requerimento de viabilidade para a prefeitura<br>
			A baixo as informações do solicitante:<br><br>
			
			Nome: $nome<br>
			Razão Social: $razaosocial<br>
			CNPJ/CPF: $cpfcnpj<br>
			Logradouro: $logradouro<br>
			Número: $numero<br>
			Complemento: $complemento<br>
			Bairro: $bairro<br>
			CEP: $cep<br>
			Telefone comercial: $fone<br>
			Telefone: $celular<br>
			Inscr. Municipal: $inscricaomunicipal<br>
			Email: $email<br>
			Municipio: $municipio<br>
			Tipo de declaração: $tipodec_str <br>	
			Unidade federal: $uf<br><br>
			
			Lista de Serviços:<br><br>
			
			$lista_servico<br>
		";
		  
		$assunto = "Requerimento de viabilidade";
	
		$headers  = "MIME-Version: 1.0\r\n";
	
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
		$headers .= "From: $email \r\n";
	
		$headers .= "Cc: \r\n";
	
		$headers .= "Bcc: \r\n";
		
		mail($EMAIL_PREF,$assunto,$msg,$headers);
		
		Mensagem("Sua solicitação de requerimento de viabilidade foi enviada para a prefeitura!");
		Redireciona("../../cadempresas.php");
	}
?>
