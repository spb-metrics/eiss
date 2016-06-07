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
 <!-- Formulário de inserção de empresa --> 
<table width="580" border="0" cellpadding="0" cellspacing="1">
    <tr>
        <td width="5%" height="10" bgcolor="#FFFFFF"></td>
        <td width="55%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de Prestadores de Fora do Município</td>
        <td width="40%" bgcolor="#FFFFFF"></td>
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


    <table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td align="left" background="../../img/index/index_oquee_fundo.jpg">
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
    <br /><br /> </td>
      </tr>
      <tr>
        <td align="left" background="../../img/index/index_oquee_fundo.jpg">
          
          <form action="inc/cadempresas/inserir.php" method="post" name="frmCadastroEmpresa" id="frmCadastroEmpresa">
            
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
            <td align="left"><input  id="txtCNPJ" type="text" size="20"  name="txtCNPJ" class="texto"  onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" onblur="ValidaCNPJ('frmCadastroEmpresa','txtCNPJ','spamcadempresafora','emissores.cnpjcpf')" /><span id="spamcadempresafora"></span></td>
            </tr>
           <!-- alterna input cpf/cnpj FIM-->   
            <tr>
                <td align="left">Endere&ccedil;o<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtInsEnderecoEmpresa" id="txtInsEnderecoEmpresa" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">Telefone Comercial<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneComercial" id="txtFoneComercial" /></td>
            </tr>
            <tr>
                <td align="left">Telefone Celular</td>
                <td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneCelular" /></td>
            </tr>
            <tr>
                <td align="left">UF<font color="#FF0000">*</font></td>
                <td align="left">
                    <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
                    <select name="txtInsUfEmpresa" id="txtInsUfEmpresa" onchange="buscaCidades(this,'tdCidades');">
                        <option value=""></option>
                        <?php
                            $sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                            while(list($uf)=mysql_fetch_array($sql))
                                {
                                    echo "<option value=\"$uf\">$uf</option>";
                                }
                        ?>
                    </select>
                </td>
            </tr>		 
            <tr>
                <td align="left">Município<font color="#FF0000">*</font></td>
                <td align="left" id="tdCidades">
                    <select style="width:150px;" id="txtInsMunicipioEmpresa"><option/></select>
                    <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
                    <!--O SELECT ESTA DENTRO DO ARQUIVO LISTAMUNICIPIO.PHP-->
                </td>
            </tr>
            <tr>
                <td align="left">Insc. Municipal</td>
                <td align="left"><input type="text" size="20" maxlength="20" name="txtInsInscMunicipalEmpresa" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">Email<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="30" maxlength="100" name="txtInsEmailEmpresa" id="txtInsEmailEmpresa" class="email" /></td>
            </tr>
            <tr>
                <td align="left">Senha<font color="#FF0000">*</font></td>
                <td align="left"><input type="password" size="12" maxlength="10" name="txtSenha" id="txtSenha" class="texto" /> <em>No máximo 10 caracteres</em></td>
            </tr>
            <tr>
                <td align="left">Confirma Senha<font color="#FF0000">*</font></td>
                <td align="left"><input type="password" size="12" maxlength="10" name="txtSenhaConf" id="txtSenhaConf" class="texto" /></td>
            </tr>	   
            <tr>
                <td colspan="3" align="left">
                    <br /><input type="checkbox" value="S"  name="txtSimplesNacional"/>
                    <font size="-2">
                        Esta empresa est&aacute; enquadrada no Simples Nacional, conforme Lei Complementar n°123/2006		  
                    </font> 
                    <br /><br />		 
                </td>
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
           
         <?php include("inc/cadempresas/cadastro_socios.php")?>
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
           
         <?php include("inc/cadempresas/cadastro_servicos.php")?>
    </table>
    
            </td>
           </tr>	         
           <tr>
             <td align="left" height="15"></td>
             <td align="right"></td>
             </tr> 	  
           <tr>
             <td align="left"><input type="submit" value="Cadastrar" name="btCadastrar" class="botao" 
             onclick="return (ConfereCNPJ('hdCNPJ')) && (ValidaSenha('txtSenha','txtSenhaConf')) && (ValidaFormulario('txtInsNomeEmpresa|txtInsRazaoSocial|txtCNPJ|txtInsEnderecoEmpresa|txtFoneComercial|txtInsUfEmpresa|txtInsMunicipioEmpresa|txtInsEmailEmpresa'))" /></td>
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
