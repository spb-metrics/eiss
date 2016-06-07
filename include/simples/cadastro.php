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
	$sql=mysql_query("SELECT cidade, estado FROM configuracoes");
	list($CIDADE,$UF)=mysql_fetch_array($sql);
?>
 <!-- Formulário de inserção de empresa --> 
   
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="70%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro Simples Nacional</td>
	        <td width="25%" bgcolor="#FFFFFF"></td>
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
<table>
<tr>
	<td>	
		<br />
		<br />
		<strong>Prezado Contribuinte</strong>
		<br /><br />
		A nossa Prefeitura Municipal vem empreendendo esforços para aprimorar continuamente a qualidade dos serviços oferecidos aos contribuintes. Neste sentido, a internet apresenta-se como um importante instrumento capaz de atendê-los com agilidade e segurança.
		<br /><br />
		E por falar em segurança, o contribuinte deverá cadastrar uma senha individual que permitirá o acesso à área restrita, de seu exclusivo interesse, no endereço eletrônico da Prefeitura. 
		<br /><br />
		A senha cadastrada é intransferível e configura a assinatura eletrônica da pessoa física ou jurídica que a cadastrou.
		<br /><br />
		<strong>ALERTAMOS QUE CABERÁ EXCLUSIVAMENTE AO CONTRIBUINTE TODA RESPONSABILIDADE DECORRENTE DO USO INDEVIDO DA SENHA, QUE DEVERÁ SER GUARDADA EM TOTAL SEGURANÇA.</strong>
		<br /><br /> 
	</td>
  </tr>
  <tr>
    <td align="left" background="../../img/index/index_oquee_fundo.jpg">
	 
      
      <form action="../include/simples/inserir.php" method="post" name="frmCadastroEmpresa" id="frmCadastroEmpresa">
      <table width="480" border="0" align="center" id="tblEmpresa">	   
		<tr>
			<td width="135" align="left">Nome<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtInsNomeEmpresa" id="txtInsNomeEmpresa" class="texto" ></td>
		</tr>
		<tr>
			<td width="135" align="left">Razão Social<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtInsRazaoSocial" id="txtInsRazaoSocial" class="texto"></td>
		</tr>	   	
      
	   <!-- alterna input cpf/cnpj-->   
		<tr>
		<td align="left">CNPJ/CPF<font color="#FF0000">*</font></td> 
		<td align="left">
			<input  type="text" size="18" name="txtCNPJ" id="txtCNPJ" class="texto" onblur="ValidaCNPJ(this,'spamsimples')"/>
			<span id="spamsimples"></span></td>
		</tr>
	   <!-- alterna input cpf/cnpj FIM-->   
		<tr>
			<td align="left">Endere&ccedil;o<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtInsEnderecoEmpresa" id="txtInsEnderecoEmpresa" class="texto" /></td>
		</tr>
		<tr>
			<td align="left">N&uacute;mero<font color="#FF0000">*</font></td>
			<td align="left">
				<input type="text" size="10" maxlength="20" name="txtInsNumeroEmpresa" id="txtInsNumeroEmpresa" class="texto" />
				Complemento
				<input type="text" size="10" maxlength="20" name="txtInsComplementoEmpresa" id="txtInsComplementoEmpresa" class="texto" />
			</td>
		</tr>
		<tr>
			<td align="left">Bairro<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="14" name="txtBairro" id="txtBairro" /></td>
		</tr>
		<tr>
			<td align="left">CEP<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="14" name="txtCEP" id="txtCEP" /></td>
		</tr>
		<tr>
			<td align="left">Telefone Comercial<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="14" name="txtFoneComercial" id="txtFoneComercial" /></td>
		</tr>
		<tr>
			<td align="left">Telefone Celular</td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="14" name="txtFoneCelular" /></td>
		</tr>
		<tr>
			<td align="left">UF<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="2" maxlength="2" name="txtInsUfEmpresa" id="txtInsUfEmpresa" value="<?php echo $UF;?>" class="texto" readonly="readonly" /></td>
		</tr>		 
		<tr>
			<td align="left">Município<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="30" maxlength="100" name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa" value="<?php echo $CIDADE;?>" class="texto" readonly="readonly" /></td>
		</tr>
		<tr>
			<td align="left">Insc. Municipal</td>
			<td align="left"><input type="text" size="20" maxlength="20" name="txtInsInscMunicipalEmpresa" id="txtInsInscMunicipalEmpresa" class="texto" /></td>
		</tr>
		<tr>
			<td align="left">PIS/PASEP</td>
			<td align="left"><input type="text" size="20" maxlength="20" name="txtPispasep" id="txtPispasep" class="texto" /></td>
		</tr>
		<tr>
			<td align="left">Email<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="30" maxlength="100" name="txtInsEmailEmpresa" id="txtInsEmailEmpresa" class="email" /></td>
		</tr>
		<tr>
			<td align="left">Senha<font color="#FF0000">*</font></td>
			<td align="left"><input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" class="texto"  onkeyup="verificaForca(this)" /></td>
		</tr>
		<tr>
			<td align="left">Confirma Senha<font color="#FF0000">*</font></td>
			<td align="left"><input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" /></td>
		</tr>	   
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
	   <tr>
         <td colspan="2" align="left">
		  <input type="button" value="Adicionar Responsável/Sócio" name="btAddSocio" class="botao" onclick="incluirSocio()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>
	   <tr>
	     <td colspan="2" align="center">	  		  
<table width="480" border="0" cellspacing="1" cellpadding="2">
       
	 <?php include("../include/simples/cadastro_socios.php")?>
</table>

     </td>
	   </tr>
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
	   <tr>
         <td colspan="2" align="left">		  
		  <input type="button" value="Adicionar Serviços" name="btAddServicos" class="botao" onclick="incluirServico()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>	   
	   <tr>
	     <td colspan="2" align="center">	 
<table width="480" border="0" cellspacing="1" cellpadding="2">
	 <?php include("../include/simples/cadastro_servicos.php")?>
</table>

        </td>
	   </tr>	         
       <tr>
         <td align="left" height="15"></td>
         <td align="right"></td>
         </tr> 	  
       <tr>
         <td align="left"><input type="submit" value="Cadastrar" name="btCadastrar" class="botao" 
         	onclick="return (ConfereCNPJ('hdCNPJ')) && (ValidaFormulario('txtInsNomeEmpresa|txtInsRazaoSocial|txtCNPJ|txtInsEnderecoEmpresa|txtInsNumeroEmpresa|txtBairro|txtCEP|txtFoneComercial|txtInsUfEmpresa|txtInsMunicipioEmpresa|txtInsEmailEmpresa|txtNomeSocio1|txtCpfSocio1')) && (ValidaSenha('txtSenha','txtSenhaConf')) && (confirm('Confira seus dados'));" />
         </td>
         <td align="right"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br /> </td>
         </tr>   
      </table>   
      </form>
	  </td>
  </tr>
</table>
		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table> 
<!-- Formulário de inserção de serviços Fim---> 


