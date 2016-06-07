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

//se nao eh contador nao pode entrar nessa tela
if (!$_SESSION['contador']) {
	Redireciona("principal.php");
	die();
}

$codcontador = $_SESSION['contador'];
$sql = mysql_query("SELECT razaosocial FROM cadastro WHERE codigo = '$codcontador'");
list($contador_razao)=mysql_fetch_array($sql);

//se o contador escolher uma empresa para fazer declaracoes,
//ele fica logado como se fosse a propria empresa.
if($_POST['btSelecionar']){
	$cod_cliente = $_POST['cmbCliente'];
	$sql = mysql_query("
		SELECT
			nome,
			razaosocial,
			cnpj,
			cpf,
			senha
		FROM
			cadastro
		WHERE
			codigo = '{$cod_cliente}'
	");
	
	list($cliente_nome, $cliente_razao, $cliente_cnpj, $cliente_cpf, $cliente_senha) = mysql_fetch_array($sql);
	$cliente_login = $cliente_cnpj . $cliente_cpf;
	
	$_SESSION['empresa'] = $cliente_senha;
	$_SESSION['login'] = $cliente_login;
	$_SESSION['nome'] = $cliente_nome;
	$_SESSION['razaosocial'] = $cliente_razao;
	$_SESSION['codcadastro'] = $cod_cliente;
	header("Location: ".$_SERVER['REQUEST_URI']);
	exit;
}

?>
<table width="580" border="0" cellpadding="0" cellspacing="1">
    <tr>
		<td width="5%" bgcolor="#ffffff" height="10"></td>
        <td rowspan="3" class="fieldsetCab" width="40%" align="center" bgcolor="#ffffff">Declara&ccedil;&atilde;o de Clientes</td>
        <td width="55%" bgcolor="#ffffff"></td>
    </tr>
	<tr>
	  <td bgcolor="#cccccc" height="1"></td>
      <td bgcolor="#cccccc"></td>
	</tr>
	<tr>
	  <td bgcolor="#ffffff" height="10"></td>
      <td bgcolor="#ffffff"></td>
	</tr>

	<tr>
		<td colspan="3" bgcolor="#cccccc" height="1"></td>
	</tr>
	<tr>
		<td colspan="3" align="center" bgcolor="#cccccc" height="60">
			<form method="post">
				<p align="center"><label>
				Escolha um cliente		
				<select name="cmbCliente" id="cmbCliente" class="combo" style="width:300px;">
					<?php
					echo "<option value='$codcontador' ";
					if($codcontador == $_SESSION['codcadastro']){
						echo "selected=selected";
					}
					echo " >(Própria Empresa) - {$contador_razao}</option>";
					
					//lista os clientes do contador logado
					$sql = mysql_query("SELECT codigo, razaosocial FROM cadastro WHERE codcontador = '$codcontador'");
					while(list($cliente_codigo, $cliente_razao) = mysql_fetch_array($sql)){
						echo "<option value='{$cliente_codigo}'";
						if($cliente_codigo == $_SESSION['codcadastro']){
							echo "selected=selected";
						}						
						echo ">{$cliente_razao}</option>";
					}
					?>
				</select>
				</label>
				<input type="submit" class="botao" value="Selecionar" name="btSelecionar" />
				</p>	Cliente selecionado atual: <b>
				<?php 
				echo $_SESSION['razaosocial'];
				?></b><?php
				
				//se for a propria empresa mostra ao lado do nome a mensagem (Propria empresa)
				if($_SESSION['contador'] == $_SESSION['codcadastro']){
					$cliente_atual_msg .= " (Própria empresa)";
				}				
				echo $cliente_atual_msg;
				?>
			</form>
		</td>
	</tr>
</table>			
