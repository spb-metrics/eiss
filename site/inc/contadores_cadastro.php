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

 <!-- Formulrio de insero de contadores  -----------------------------------------------------------------------------> 
   
<table width="500" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td bgcolor="#FF6600" height="1"></td>
  </tr>
  <tr>
    <td align="left" background="../img/index/index_oquee_fundo.jpg"><strong>REQUISI&Ccedil;&Atilde;O DE ACESSO AO SISTEMA DA NF-E</strong>
<br />
<br />
<strong>Prezado Contador/Escrit&oacute;rio de Contabilidade </strong>
<br />
<br />
A nossa Prefeitura Municipal vem empreendendo esforos para aprimorar continuamente a qualidade dos servios oferecidos aos contribuintes e demais entidades envolvidas. Neste sentido, a internet apresenta-se como um importante instrumento capaz de atend-los com agilidade e segurana.
<br />
<br />
E por falar em segurana, voc&ecirc; dever cadastrar uma senha individual que permitir o acesso  rea restrita, de seu exclusivo interesse, no endereo eletrnico da Prefeitura. 
<br />
<br />
A senha cadastrada  intransfervel e configura a assinatura eletrnica da pessoa fsica ou jurdica que a cadastrou.
<br /><br />
<strong>ALERTAMOS QUE CABER EXCLUSIVAMENTE AO CONTADOR/ESCRIT&Oacute;RIO DE CONTABILIDADE TODA RESPONSABILIDADE DECORRENTE DO USO INDEVIDO DA SENHA, QUE DEVER SER GUARDADA EM TOTAL SEGURANA.</strong>
<br />
<br /> </td>
  <tr>
    <td align="left" background="../img/index/index_oquee_fundo.jpg">
	 
      
      <form action="" method="post" name="frmCadastroEmpresa" id="frmCadastroEmpresa">
	    
      <table width="480" border="0" align="center" id="tblEmpresa">	   
	   <tr>
        <td width="135" align="left">
	     Nome<font color="#FF0000">*</font>		</td>
        <td align="left">
	     <input type="text" size="60" maxlength="100" name="txtInsNomeEmpresa" class="texto" >		</td>
       </tr>
       <tr>
        <td width="135" align="left">
		 Razo Social<font color="#FF0000">*</font>		</td>
        <td align="left">
	     <input type="text" size="60" maxlength="100" name="txtInsRazaoSocial" class="texto">		</td>
       </tr>	   	
      
	   <!-- alterna input cpf/cnpj-->   
       <tr>
        <td align="left">
		 CNPJ/CPF<font color="#FF0000">*</font>		</td> 
        <td align="left">			
		 <input  id="txtCnpjCpf" type="text" size="20"  name="txtInsCpfCnpjEmpresa" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />		</td>
       </tr>
	   <!-- alterna input cpf/cnpj FIM-->   
       <tr>
        <td align="left">
		 Endere&ccedil;o<font color="#FF0000">*</font>		</td>
        <td align="left">
		 <input type="text" size="60" maxlength="100" name="txtInsEnderecoEmpresa" class="texto" />		</td>
       </tr>
       <tr>
	     <td align="left">
		  Municpio<font color="#FF0000">*</font>		 </td>
	     <td align="left">
          <input type="text" size="30" maxlength="100" name="txtInsMunicipioEmpresa" class="texto" />		 </td>
	     </tr>
	   <tr>
	     <td align="left">
		  UF<font color="#FF0000">*</font>		 </td>
	     <td align="left">
          <input type="text" size="2" maxlength="2" name="txtInsUfEmpresa" class="texto" />		 </td>
	     </tr>		 
	   <tr>
        <td align="left">
		 Insc. Municipal		</td>
        <td align="left">
		 <input type="text" size="20" maxlength="20" name="txtInsInscMunicipalEmpresa" class="texto" />		</td>
       </tr>
       <tr>
        <td align="left">
		 Email<font color="#FF0000">*</font>		</td>
        <td align="left">
		  <input type="text" size="30" maxlength="100" name="txtInsEmailEmpresa" class="email" />		</td>
       </tr>
       <tr>
         <td align="left">Senha<font color="#FF0000">*</font></td>
         <td align="left"><input type="password" size="12" maxlength="10" name="txtSenha" class="texto" /> 
           <em>No mximo 10 caracteres</em></td>
       </tr>
       <tr>
         <td align="left">Confirma Senha<font color="#FF0000">*</font></td>
         <td align="left"><input type="password" size="12" maxlength="10" name="txtSenhaConf" class="texto" /></td>
       </tr> 
	   <tr>
	     <td colspan="3" align="left">
		  <br /> <input type="checkbox" value="S"  name="txtSimplesNacional"/>			  	
		  <font size="-2">
	        Esta empresa est&aacute; enquadrada no Simples Nacional, conforme Lei Complementar n°123/2006		  </font> <br /><br />		 </td>
       </tr>
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
	   <tr>
         <td colspan="2" align="left">
		   <!-- botão que chama a função JS e mostra + um sócio-------------------->
		  <input type="button" value="Adicionar Responsável/Sócio" name="btAddSocio" class="botao" onclick="incluirSocio()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>
	   <tr>
	     <td colspan="2" align="center">	  
		  
<!--CAMPO SÓCIOS --------------------------------------------------------------------------->	   
<table width="480" border="0" cellspacing="1" cellpadding="2">
       
	 <?php include("inc/prestadores_cadastro_socios.php")?>
</table>

<!-- CAMPO SÒCIOS FIM -------------------------->   	     </td>
	   </tr>
	   <tr>
	     <td colspan="2" align="left">&nbsp;</td>
	     </tr>
	   <tr>
         <td colspan="2" align="left">
		  <!-- botão que chama a função JS e mostra + um serviço-------------------->
		  <input type="button" value="Adicionar Serviços" name="btAddServicos" class="botao" onclick="incluirServico()" /> 
		  <font color="#FF0000">*</font></td>
       </tr>	   
	   <tr>
	     <td colspan="2" align="center">	 
	      
<!--CAMPO SERVICOS --------------------------------------------------------------------------->	   
<table width="480" border="0" cellspacing="1" cellpadding="2">
       
	 <?php include("inc/prestadores_cadastro_servicos.php")?>
</table>

<!-- CAMPO SERVICOS FIM ---------------------------------------------------------------------->        </td>
	   </tr>	         
       <tr>
         <td align="left" height="15"></td>
         <td align="right"></td>
         </tr> 	  
       <tr>
         <td height="60" align="left"><input type="submit" value="Cadastrar" name="btCadastrar" class="botao" /></td>
         <td align="right"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br /> </td>
         </tr>   
      </table>   
      </form>
	  </td>
  <tr>
    <td colspan="2" bgcolor="#FF6600" height="1"></td>
    </tr>
</table>
  
<!-- Formulrio de insero de servios Fim-->       
