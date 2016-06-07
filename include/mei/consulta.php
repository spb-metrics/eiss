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
	if(!$_POST['txtCNPJ']){
	
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
		<td width="400" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro de MEI</td>
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
        <form method="post">
            <input name="txtMenu" type="hidden" value="<?php echo $_POST['txtMenu'];?>" />
                <table width="100%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="23%" align="left">CNPJ/CPF</td>
                        <td width="77%" align="left">
                            <input name="txtCNPJ" id="txtCNPJ" onkeyup="MaskCNPJCPF(this);" type="text" size="20" maxlength="18" class="texto" />
                        </td>
                    </tr>
                    <tr>
                        <td height="30" valign="middle" align="right">
                            <input name="btAvancar" value="Avançar" type="submit" class="botao" onclick="ValidaFormulario('txtCNPJ','Preencha o CNPJ!')" />
                        </td>
                        <td>
                            <input type="button" name="btVoltar" value="Voltar" class="botao" 
                            onClick="window.location='mei.php'">
                        </td>
                    </tr>
                </table>
        </form>
        </td>	
    </tr>
    <tr>
        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
    </tr>
</table> 
    <?php	
	}else{
		$buscatipo=coddeclaracao('MEI');
		$cnpj = $_POST["txtCNPJ"];
		$sql_instituicaologada = mysql_query("
			SELECT 
				codigo, 
				nome, 
				razaosocial, 
				senha, 
				cnpj, 
				cpf, 
				inscrmunicipal, 
				logradouro,
				bairro,
				cep, 
				numero, 
				complemento, 
				municipio, 
				uf, 
				email, 
				fonecomercial, 
				fonecelular, 
				estado 
			FROM 
				cadastro 
			WHERE 
				(cnpj = '$cnpj' OR cpf='$cnpj') AND
				codtipodeclaracao = $buscatipo
		");
		list($codigo,$nome,$razaosocial,$senha,$cnpj,$cpf,$inscrmunicipal,$logradouro,$bairro,$cep,$numero,$complemento,$municipio,$uf,$email,$fone1,$fone2,$estado) = mysql_fetch_array($sql_instituicaologada);
		$endereco = "$logradouro, $numero";
		if($complemento)
			$endereco .= ", $complemento";
		$cnpj .= $cpf;
		switch($estado){
				case "NL": $estado = "<font color=\"#FF0000\">Aguarde a Liberação da prefeitura</font>";                                  break;
				case "A" : $estado = "<font color=\"#00CC66\">Cadastro Liberado</font>";                                                  break;
				case "I" : $estado = "<font color=\"#FF0000\">Empresa inativa, entre em contato com a prefeitura.</font>";	 			  break;
		}//fim switch estado
		$sql_busca_banco = mysql_query("SELECT banco FROM bancos WHERE codigo = '$codbanco'");
		list($banco) = mysql_fetch_array($sql_busca_banco);
		if(mysql_num_rows($sql_instituicaologada)){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="5" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta de MEI</td>
		<td width="65%" bgcolor="#FFFFFF"></td>
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

			<table width="98%" height="100%" border="0" bgcolor="#CCCCCC" align="center" cellpadding="1" cellspacing="2">
	    	  	<tr>
                	<td colspan="4" height="5"></td>
                </tr>
                <tr>
	                <td width="18%" align="left" >Nome Completo:</td>
   	              	<td colspan="3" bgcolor="#FFFFFF" align="left" valign="middle"><?php echo $nome; ?></td>
			  	</tr>
				<tr>
					<td align="left" >Razão Social:</td>
					<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $razaosocial; ?></td>
				</tr>
				<tr>
					<td align="left" >CNPJ:</td>
					<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $cnpj; ?></td>
				</tr>
                <tr>
					<td align="left" >Insc Municipal:</td>
					<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo verificaCampo($inscrmunic); ?></td>
				</tr>
				<tr>
					<td align="left" >Email:</td>
					<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $email; ?></td>
				</tr>
				<tr>
                    <td align="left" >Situacão:</td>
                    <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $estado; ?></td>
				</tr>
				<tr>
					<td align="left" >Endereço:</td>
					<td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo "$endereco, n° $numero"; ?></td>
				</tr>
              <tr>
                    <td align="left" >Bairro:</td>
				  	<td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $bairro; ?></td>
					<td align="left" width="20%">CEP:</td>
					<td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo $cep; ?></td>
				</tr>
				<tr>
					<td align="left" >Municipio:</td>
					<td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $municipio; ?></td>
                    <td width="16%" align="left" >Estado (UF):</td>
					<td align="left" bgcolor="#FFFFFF" width="15%" valign="middle">&nbsp;<?php echo $uf; ?></td>
				</tr>
				<tr>
					<td align="left" >Telefone:</td>
					<td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $fone1; ?></td>
                	<td align="left" >Telefone Adicional:</td>
					<td align="left" bgcolor="#FFFFFF" valign="middle">&nbsp;<?php echo verificaCampo($fone2); ?></td>
			  </tr>
				<tr>
					<td  height="25" colspan="4"><input type="button" name="btVoltar" value="Voltar" class="botao" 
                    	onClick="window.location='mei.php'"></td>
				</tr>
			</table>
          	</td>	
        </tr>
        <tr>
            <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
        </tr>
    </table>         
<?php
		}else{
			Mensagem("Este CNPJ/CPF não está cadastrado no sistema ou não é optante pelo MEI");
			Redireciona("mei.php");
		}
	}//fim else
?>