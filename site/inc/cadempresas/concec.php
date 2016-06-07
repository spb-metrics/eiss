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
$sqlcidade = mysql_query("SELECT cidade FROM configuracoes");
list($cidade) = mysql_fetch_array($sqlcidade);
 	
if(!($_POST['txtCNPJ'])){ //se NAO digitou cnpj mostra tela de digitar cnpj, se digitou cnpj mostra a consulta ao CEF
?>
	<form method="post" name="frmCNPJ">
	<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
<table width="99%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	    <td width="40%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro de Empresas</td>
      <td width="55%" bgcolor="#FFFFFF"></td>
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

			<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
				<tr>
				  <td align="center">&nbsp;</td>
				  <td align="left" valign="middle">Dados do Emissor:</td>
			    </tr>
				<tr>
					<td width="19%" align="left">CNPJ/CPF</td>
					<td width="81%" align="left" valign="middle"><em>
					  <input class="texto" type="text" title="CNPJ" name="txtCNPJ" onKeyDown="return NumbersOnly( event );" onKeyUp="CNPJCPFMsk( this );" />
					Somente n&uacute;meros</em></td>
				</tr>
				<tr>
				  <td align="left">ou</td>
				  <td align="left" valign="middle">&nbsp;</td>
			    </tr>
				<tr>
				  <td align="left">Insc. Municipal</td>
				  <td align="left" valign="middle"><em>
					<input class="texto" type="text" title="IM" name="txtInscMunicipal" onKeyDown="return NumbersOnly( event );" onKeyUp="CNPJCPFMsk( this );" />
				  </em></td>
			    </tr>
				<tr>
				  <td align="center">&nbsp;</td>
				  <td align="left" valign="middle"><input type="submit" value="Avançar" class="botao" /> <input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='cadempresas.php'"></td>
			    </tr>
		 	</table>
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	</form>
<?php 
}else{//else se digitou cnpj
	//recebe os dados
    $cnpjcpf = $_POST["txtCNPJ"];
	$inscr = $_POST['txtInscMunicipal'];

    // verifica se $cnpjcpc e um cpf ou se e um cnpj
    $campo=tipoPessoa($cnpjcpf);

	if($inscr) { $strsql = "OR inscrmunicipal = '$inscr'"; }
	$sql = mysql_query("SELECT nome,
                        estado,
                        razaosocial,
                        inscrmunicipal
                        FROM cadastro
                        WHERE $campo = '$cnpjcpf'
                        $strsql");
	 


	if(mysql_num_rows($sql)==0){
	
			Mensagem("Empresa não cadastrada, verifique se o mesmo está correto");
			Redireciona("cadempresas.php");		
	}else{			
		list($nome,$estado, $razaosocial, $inscrmunicipal) = mysql_fetch_array($sql);
	}
	?>
	<table width="99%" border="0" cellpadding="0" cellspacing="1">
<tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
			<td width="40%" rowspan="3" align="center" bgcolor="#FFFFFF">Consulta ao Cadastro de Empresas</td>
            <td width="55%" bgcolor="#FFFFFF"></td>
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
	
				<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="5">
					<tr>
					  <td align="center">&nbsp;</td>
					  <td align="left" valign="middle">Dados do Emissor:</td>
					</tr>
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
						<td width="81%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $cnpjcpf; ?></td>
					</tr>
					  <td align="left">Insc. Municipal</td>
					  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $inscrmunicipal;?></td>
					</tr>
					<tr>
					  <td align="left">Situacão</td>
					  <td align="left" valign="middle" bgcolor="#FFFFFF">
<?php 
if ($estado =='NL'){echo "Não Liberado";}
elseif ($estado =='I'){echo "Inativo";}
else {echo "Liberado/Ativo";} ?>
                      </td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height="1" colspan="3" bgcolor="#CCCCCC"><input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='cadempresas.php'"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>    
<?php
}//fim else se digitou cnpj

?>	