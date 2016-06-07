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
  $sql=mysql_query("SELECT codigo, nome,cnpj,cpf FROM cadastro WHERE cnpj='".$_SESSION['SESSAO_cnpj_emissor']."' OR cpf='".$_SESSION['SESSAO_cnpj_emissor']."'");
  list($codigo,$nome,$cnpj,$cpf)=mysql_fetch_array($sql);  
    
  
?>
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="130" align="center" bgcolor="#FFFFFF" rowspan="3">Prestador Cadastrado</td>
	    <td width="440" bgcolor="#FFFFFF"></td>
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

	<table width="98%" border="0" align="center" cellpadding="2" cellspacing="5">
	  <tr>
		<td width="19%" align="left">&nbsp;</td>
		<td width="81%" align="right" ><a href="inc/logout.php" style="color:#FF0000;">Sair</a></td>
	    </tr>
			<tr>
				<td align="left">Nome</td>
			    <td align="left" bgcolor="#FFFFFF"><?php echo"$nome"; ?>&nbsp;</td>
			</tr>
			<tr>
			  <td align="left">CNPJ / CPF</td>
	          <td align="left" bgcolor="#FFFFFF"><?php echo"$cnpjcpf"; ?></td>
		</tr>
			<tr>
			  <td align="left">Código de verificação</td>
			  <td align="left" valign="middle" bgcolor="#FFFFFF">
			  	<form name="frmCodVerificacao" target="_blank" method="post" action="inc/certidoes/verifautenticidade_sql.php">
				  	<input type="text" class="texto" name="txtCodVerificacao" id="txtCodVerificacao">
				  	<input type="submit" class="botao" value="Verificar" >
			  	</form>
             </td>
	    </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			  <td align="left" valign="middle">&nbsp;</td>
	    </tr>
	  </table>
      
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
