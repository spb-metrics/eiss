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
	
	//$login = $_POST['txtLogin'];
	//$senha = md5($_POST['txtSenha']);
	
	$sql = mysql_query("SELECT nome, estado, senha, codtipodeclaracao, cadastro.codigo, cadastro.codtipo, razaosocial, nfe FROM cadastro WHERE cnpj= '$login' OR cpf = '$login'");
	if(mysql_num_rows($sql)) { 
		$dados = mysql_fetch_array($sql);
		$sql_simp = mysql_query("SELECT codigo FROM declaracoes WHERE declaracao='DES Consolidada'");
		list($consolidada)=mysql_fetch_array($sql_simp);
		$sql_cons = mysql_query("SELECT codigo FROM declaracoes WHERE declaracao='DES Simplificada'");
		list($simplificada)=mysql_fetch_array($sql_cons);
		if($dados['nfe'] == "N"){		
			if($dados['codtipodeclaracao']==$consolidada||$dados['codtipodeclaracao']==$simplificada){
				//verifica se a empresa esta ativa
				if($dados['estado'] == "A")	{
				 //verifica se a senha digitada confere com a que está armazenada no banco	
					 if($senha == $dados['senha']){	   
						// inicia a sessão e direciona para index.		
						$_SESSION['empresa'] = $dados['senha'];
						$_SESSION['login'] = $login;
						$_SESSION['nome'] = $dados['nome'];
						$_SESSION['razaosocial'] = $dados['razaosocial'];
						$_SESSION['codcadastro'] = $dados['codigo'];
					
					
						//se for contador salva o codigo da tabela cadastro na sessao
						if( $dados['codtipo']==codTipo("contador") ){
							$_SESSION['contador'] = $dados['codigo'];
						}else{
							//se nao for contador deixa a variavel vazia
							$_SESSION['contador'] = "";
						}
						print("<script language=JavaScript>parent.location='../principal.php';</script>");
					}else{
						print("<script language=JavaScript>alert('Senha não confere com a cadastrada no sistema! Favor verificar a senha.');parent.location='../login.php';</script>");	
					}
				}else{
					print("<script language=JavaScript>alert('Empresa desativada! Contate a Prefeitura.');parent.location='../login.php';</script>");
				}
			}else{
				print("<script language=JavaScript>alert('Empresa não habilitada para declarações! Contate a Prefeitura.');parent.location='../login.php';</script>");
			}
		}else{
			print("<script language=JavaScript>alert('Prestadores aptos para a emissão de nota fiscal devem logar-se no sistema NF-e.');parent.location='../login.php';</script>");		
		}
	}else{
		print("<script language=JavaScript>alert('CPF/CNPJ não cadastrado no sistema! Favor verificar usuario.');parent.location='../login.php';</script>");
	}
?>