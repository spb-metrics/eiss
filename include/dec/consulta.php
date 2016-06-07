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
	if(!$_POST['txtCNPJ']){?>
<form method="post">
	<input name="txtMenu" type="hidden" value="<?php echo $_POST['txtMenu'];?>" />
        <table width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" height="5" bgcolor="#FFFFFF"></td>
                <td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro de Cartórios</td>
                <td width="30%" bgcolor="#FFFFFF"></td>
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
                        <td width="19%" align="left">CNPJ/CPF</td>
                        <td width="81%" align="left">
                            <input name="txtCNPJ" id="txtCNPJ" type="text" onKeyUp="CNPJCPFMsk( this );" size="20" maxlength="18" class="texto" /><em>&nbsp;Somente n&uacute;meros</em>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td height="30" valign="middle" colspan="2" align="left">
                            <input name="btAvancar" value="Avan&ccedil;ar" type="submit" class="botao" onClick="ValidaFormulario('txtCNPJ','Preencha o CNPJ!')" />&nbsp;<input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='dec.php'">
                        </td>
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
	}else{
	
	$cnpj = $_POST["txtCNPJ"];
	$sql=mysql_query("SELECT cidade, estado FROM configuracoes");
	list($CIDADE,$ESTADO)=mysql_fetch_array($sql);
	
	$sql_consulta = mysql_query("
		SELECT 
			cadastro.codigo, 
			cadastro.nome, 
			cadastro.razaosocial, 
			cadastro.cnpj, 
			cadastro.municipio, 
			cadastro.uf, 
			cadastro.logradouro, 
			cadastro.numero, 
			cadastro.bairro, 
			cadastro.email, 
			cadastro.fonecomercial, 
			cadastro.fonecelular, 
			cadastro.estado, 
			cartorios.admpublica, 
			cartorios.nivel, 
			cadastro.cep, 
			cadastro.inscrmunicipal 
		FROM 
			cadastro 
		LEFT JOIN 
			cadastro_resp ON cadastro_resp.codemissor = cadastro.codigo 
		LEFT JOIN 
			cartorios ON cartorios.codcadastro = cadastro.codigo 
		WHERE 
			cnpj = '$cnpj'
		");

	if(mysql_num_rows($sql_consulta)>0){
	list($codigo, $nome, $razaosocial, $cnpj, $municipio, $uf, $logradouro,$numero,$bairro,$email,$fone,$foneadicional,$estado,$admpublica,$nivel,$cep,$inscrmunic)=mysql_fetch_array($sql_consulta);
	
	$resp=codcargo('responsavel');
	$diretor=codcargo('diretor');
	$sql_resp= mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor='$codigo' AND codcargo='$resp' LIMIT 1");
	$sql_diretor= mysql_query("SELECT nome, cpf FROM cadastro_resp WHERE codemissor='$codigo' AND codcargo='$diretor' LIMIT 1");
	list($resp_nome, $resp_cpf)=mysql_fetch_array($sql_resp);
	list($diretor_nome, $diretor_cpf)=mysql_fetch_array($sql_diretor);
	
	switch($admpublica){
	case "D": $admpublica="Direta" ; break;
	case "I": $admpublica="Indireta" ; break;
	}
	switch($nivel){
	case "M": $nivel="Municipal" ; break;
	case "E": $nivel="Estadual" ; break;
	case "F": $nivel="Federal" ; break;	
	}
	switch($estado){
		case "NL": $estado = '<b>Aguarde a Liberação da prefeitura</b>'; break;
		case "A": $estado = '<font color="#006600"><b>Cadastro Liberado</b></font>'; break;
		case "I": $estado = '<font color="#FF0000"><b>Cartório Inativo, entre em contato com a prefeitura.</b></font>'; break;
	}//fim switch estado
?>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="5" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Consulta ao Cadastro de Cartórios</td>
		<td width="30%" bgcolor="#FFFFFF"></td>
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
			<form method="post" id="frmCadastroInst" action="inc/dec/inserir.php">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
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
                            <td align="left" >Endereço:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo "$logradouro, n° $numero"; ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Situacão:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $estado; ?></font></td>
                        </tr>  
                        <tr>
                            <td align="left" >Email:</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3" valign="middle"><?php echo $email; ?></td>
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
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo $fone; ?></td>
                            <td align="left" >Telefone Adicional:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle">&nbsp;<?php echo verificaCampo($foneadicional); ?></td>
                      	</tr>
                        <tr>
                            <td width="100%" colspan="4" height="3"><hr /></td>
                        </tr>
                        <tr>
                            <td align="left" >Diretor:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($diretor_nome); ?></td>
                            <td align="left" width="20%">CPF Diretor:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($diretor_cpf); ?></td>
                        </tr>
                        <tr>
                            <td align="left" >Responsável:</td>
                            <td align="left" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($resp_nome); ?></td>
                            <td align="left" width="20%">CPF Responsável:</td>
                            <td align="left" width="20%" bgcolor="#FFFFFF" valign="middle"><?php echo verificaCampo($resp_cpf); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><input type="button" name="btVoltar" value="Voltar" class="botao" 
                                onClick="window.location='dec.php'"></td>
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
	}
	else
	{
		Mensagem("CNPJ não cadastrado ou inexistente");
		Redireciona('dec.php');
	} 
} ?>