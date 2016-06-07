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
    session_name("emissores_iss");
    session_start();

    include("../funcoes/util.php");

    // recebe a variavel que contem o número de verificação e a variavel que contém o número que o usuário digitou.
    $autenticacao = $_SESSION['autenticacao'];
    $cod_seguranca= $_POST['codseguranca'];
    $login=$_POST['txtLogin'];
    $senha=md5(addslashes(strip_tags($_POST['txtSenha'])));
    $codtipo=$_POST['txtCodTipo'];
	if(!$codtipo){
		$tipo=$_SESSION["TIPO"];
		if( $cod_seguranca == $_SESSION['autenticacao'] && $cod_seguranca ){
			include("conect.php");
			switch($tipo){
				case ("des"):
					include("verifica_des.php");
					break;
				case ("decc"):
					include("verifica_decc.php");
					break;		 	
				case ("simples"):
					include("verifica_simples.php");		 			 			 		
					break;	 
				case ("mei"):
					include("verifica_mei.php");		 			 			 		
					break;	
				default:
					print("<script language=JavaScript>alert('Erro inesperado! tente novamente');parent.location='../principal.php';</script>");
			}//fim switch	
			exit;
		}else{
			print("<script language=JavaScript>alert('Favor verificar código de segurança!');parent.location='../login.php';</script>");
			exit;
		} 

	}
	
	

    ?>
        <form name="frmRetorno" id="frmRetorno" action="../login.php" method="post"> 
            <input type="hidden" name="txtCodTipo" value="<?php echo $codtipo; ?>" />
        </form>
    <?php
    
    if($cod_seguranca == $autenticacao)
    {
        include("conect.php");
		//include("../../midware/conecta.pg.php");

        /*
		//verifica se ha algum prestador cadastrado com o cpf ou cnpj digitado
        $sql_cpf=mysql_query("SELECT codigo FROM cadastro WHERE cpf='$login'");
        $sql_cnpj=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$login'");
        if(mysql_num_rows($sql_cpf)>0){
            $campo="cpf";
        }elseif(mysql_num_rows($sql_cnpj)>0){
            $campo="cnpj";
        }else{
            echo "<script language=JavaScript>alert('CNPJ/CPF inválido! Favor verifique seu CNPJ/CPF e tente novamente.');parent.location='../login.php';</script>";
        }
		*/
		
		$campo = tipoPessoa($login);
		if(!$campo){
			Mensagem("CNPJ/CPF inválido! Favor verifique seu CNPJ/CPF e tente novamente.");
			Redireciona("../login.php");
			exit;
		}
		
		
		

        // verifica o usuario
        $sql_verifica=mysql_query("
			SELECT 
				cadastro.codigo,
				cadastro.estado,
				cadastro.codtipo,
				tipo.tipo
		    FROM 
				cadastro
		    INNER JOIN tipo ON 
				cadastro.codtipo = tipo.codigo
		    WHERE 
				cadastro.$campo = '$login' AND 
				cadastro.senha = '$senha'
	    ");
        if(mysql_num_rows($sql_verifica)>0){
            $dados=mysql_fetch_array($sql_verifica);
            if($dados['estado']!="A"){
                echo "
                    <script language=JavaScript>
                        alert('Prestador de serviços inativo ou não liberado! Favor entre em contato com a prefeitura.');
                        onload=function(){document.getElementById('frmRetorno').submit();};
                    </script>
                ";
            }elseif($dados['codtipo']!=$codtipo){
                echo "
                    <script language=JavaScript>
                        alert('Este menu é exclusivo para outro tipo de prestador de serviços!');
                        onload=function(){document.getElementById('frmRetorno').submit();};
                    </script>
                ";
            }else{
            	$_SESSION['empresa']=$dados['tipo'];
				$_SESSION['login']=$login;
            	echo "<script language=JavaScript>parent.location='../principal.php';</script>";
				//Aqui testa se o cnpj existe no postgres
				/*$sql_pg = pg_query("SELECT codigo FROM tcaunico WHERE codigo = '{$dados['codigo']}'");
				if(pg_num_rows($sql_pg)){
					$_SESSION['empresa']=$dados['tipo'];
					$_SESSION['login']=$login;
					echo "<script language=JavaScript>parent.location='../principal.php';</script>";
				}else{
					echo "
						<script language=JavaScript>
							alert('O cnpj não está registrado no PG!');
							onload=function(){document.getElementById('frmRetorno').submit();};
						</script>
					";
				}	*/	
            }

        }else{
            echo "
                <script language=JavaScript>
                    alert('Senha inválida! Favor verifique sua senha e tente novamente.');
                    onload=function(){document.getElementById('frmRetorno').submit();};
                </script>
            ";
        }

        //verifica o estado
        
    }else{
        echo "
            <script language=JavaScript>
                alert('Código de verificação inválido!');
                onload=function(){document.getElementById('frmRetorno').submit();};
            </script>
        ";
    }
?>