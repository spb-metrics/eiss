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
	//Recebe as variaveis vindas por post
	$codigo           = $_POST['CODOBRA'];
	$cnpj_empreiteira = $_POST['txtCNPJCPFEmpreiteira'];
	$obra             = trataString($_POST['txtObra']);
	$alvara           = trataString($_POST['txtAlvara']);
	$iptu             = trataString($_POST['txtIptu']);
	$endereco         = trataString($_POST['txtEndereco']);
	$propietario      = trataString($_POST['txtProprietario']);
	$cnpjcpf          = $_POST['txtCNPJCPF'];
	$materiais        = trataString($_POST['txtListaMateriais']);
	$valormateriais   = MoedaToDec($_POST['txtValorMateriais']);
	$estado           = $_POST['rdEstado'];
	
	//Verifica se foi informado o cnpj ou cpf da empreiteira
    $campo   = tipoPessoa($cnpj_empreiteira);
	$codtipo = codtipo('empreiteira'); 
    $sql_empreiteira  = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cnpj_empreiteira' AND codtipo = '$codtipo'");
    list($codcadastro) = mysql_fetch_array($sql_empreiteira);
	
	if(mysql_num_rows($sql_empreiteira)>0){
	
		// verifica se nao ha outra obra com o mesmo alvara ou com o mesmo iptu
		$sql_verifica_alvara = mysql_query("SELECT codigo FROM obras WHERE alvara = '$alvara' AND codigo <> '$codigo'");
		$sql_verifica_iptu   = mysql_query("SELECT codigo FROM obras WHERE iptu = '$iptu' AND codigo <> '$codigo'");
		if(mysql_num_rows($sql_verifica_alvara) > 0){
			Mensagem("Já existe uma obra cadastrada com este alvará!");
		}elseif(mysql_num_rows($sql_verifica_iptu) > 0){
			Mensagem("Já existe uma obra cadastrada com este IPTU!");
		}else{
			if($estado == "C"){
				$string_data = ", datafim = NOW()";
			}else{
				$string_data = ", datafim = NULL";
			}
			
			//Inseri a obra no banco
			mysql_query("
				UPDATE 
					obras 
				SET
					codcadastro = '$codcadastro', 
					obra = '$obra',
					alvara = '$alvara',
					iptu = '$iptu',
					endereco = '$endereco',
					proprietario = '$propietario',
					proprietario_cnpjcpf = '$cnpjcpf',
					listamateriais = '$materiais',
					valormateriais = '$valormateriais',
					estado = '$estado'
					$string_data				
				WHERE
					codigo = '$codigo'
				");
			Mensagem("Obra atualizada!");
		}
	}else{
		Mensagem("Empreiteira não cadastrada no sistema!");
	}
?>