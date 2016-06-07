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
if(!$_POST['txtCNPJ']||!$_POST["txtSenha"]){ //se NAO digitou cnpj e a senha mostra tela de digitar cnpj, se digitou cnpj mostra a consulta
include("login.php");

}elseif( $_SESSION['autenticacao'] != $_POST['codseguranca']){
	Mensagem("Favor verificar código de segurança!");
	?>
	<form method="post" id="frmCodSeg">
		<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
	</form>
	<script>document.getElementById('frmCodSeg').submit();</script>
	<?php
}else{
	
	$cnpj = $_POST['txtCNPJ'];
	$senha= md5(trataString($_POST['txtSenha']));
	
	$sqltipo=mysql_query("SELECT codigo FROM tipo WHERE tipo='grafica'");
	list($codtipo)=mysql_fetch_array($sqltipo);
	
	$sql=mysql_query("
					  SELECT 
						codigo, 
						nome, 
						razaosocial, 
						inscrmunicipal, 
						logradouro,
						numero,
						complemento,
						bairro,
						cep,
						municipio, 
						uf, 
						email, 
						estado, 
						senha
					  FROM 
					  	cadastro
					  WHERE 
					  	(cnpj='$cnpj' OR cpf='$cnpj') AND 
						codtipo='$codtipo'
					  ");
	list($codigo, $nome, $razaosocial, $inscrmunicipal,$logradouro,$numero,$complemento,$bairro,$cep, $municipio, $uf, $email, $estado, $senhagrafica) = mysql_fetch_array($sql);	
	if(!mysql_num_rows($sql)){
		Mensagem("Gráfica não cadastrada no sistema, favor verificar o CNPJ/CPF ou entrar em contato com a gráfica");
		?>
		<form method="post" id="frmCodSeg">
			<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
		</form>
		<script>document.getElementById('frmCodSeg').submit();</script>
		<?php
	}elseif($senha!=$senhagrafica){
		Mensagem("Senha incorreta, favor verificar os dados digitados");
		?>
		<form method="post" id="frmCodSeg">
			<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
		</form>
		<script>document.getElementById('frmCodSeg').submit();</script>
		<?php
	}else{
		switch($estado){
			case "NL": $estado="Gráfica não liberada, entre em contato com a prefeitura para mais informações."; break;
			case "A": $estado="Gráfica liberada pela prefeitura para imprimir documentos fiscais."; break;
			case "I": $estado="Gráfica desativada, entre em contato com a prefeitura para mais informações."; break;
		}
	?>
		<table width="99%" border="0" cellpadding="0" cellspacing="1">
	  <tr>
				<td width="10" height="10" bgcolor="#FFFFFF"></td>
				<td width="210" align="center" bgcolor="#FFFFFF" rowspan="3">AIDF: Consulta Autoriza&ccedil;&atilde;o</td>
				<td width="405" bgcolor="#FFFFFF"></td>
			</tr>
			<tr>
			  <td height="1" bgcolor="#CCCCCC"></td>
			  <td bgcolor="#CCCCCC"></td>
			</tr>
			<tr>
			  <td height="10" bgcolor="#FFFFFF"></td>
			  <td bgcolor="#FFFFFF"></td>
			</tr>
			<tr>
				<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
			</tr>
			<tr>
				<td height="60" colspan="3" bgcolor="#CCCCCC">
		
					<table width="100%" height="100%" border="0" align="center" cellpadding="2" cellspacing="2">
						<tr>
						  <td align="left">Nome</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $nome; ?></td>
						</tr>
						<tr>
						  <td align="left">Razão Social</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $razaosocial; ?></td>
						</tr>
						<tr>
							<td width="19%" align="left">CNPJ/CPF</td>
							<td width="81%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $cnpj; ?></td>
						</tr>
						<tr>
						  <td align="left">Insc. Municipal</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $inscrmunicipal;?></td>
						</tr>
						<tr>
						  <td align="left">Endereço</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$logradouro $numero $complemento, $municipio, $uf."; ?></td>
						</tr>
						<tr>
						  <td align="left">E-mail</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $email; ?></td>
						</tr>
						<tr>
						  <td align="left">Situacão</td>
						  <td align="left" valign="middle" bgcolor="#FFFFFF"><b><?php echo $estado; ?></b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td height="1" colspan="3" bgcolor="#CCCCCC"><input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='aidf.php'"></td>
						</tr>
				  </table>
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>     
<?php
	}//fim else se existe a grafica
}//fim else se digitou a senha e se digitou corretamente o codigo de verificacao
?>