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
<style>
	.letrasMaiusculas{
		text-transform:uppercase;
		border:1px solid #999999;
		color:#333333;
		font-family:Verdana,Arial,Helvetica,sans-serif;
		font-size:8pt;
		font-style:normal;
		height:15px;
	}
</style>
 <!-- Formul�rio de inser��o de empresa --> 
<table width="580" border="0" cellpadding="0" cellspacing="1">
    <tr>
        <td width="5%" height="10" bgcolor="#FFFFFF"></td>
        <td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Solicita��o de viabilidade</td>
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


   
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td align="left" background="../../img/index/index_oquee_fundo.jpg"></td>
	  </tr>
      <tr>
        <td align="left" background="../../img/index/index_oquee_fundo.jpg">
         
          
          <form action="inc/cadempresas/enviar_solicitacao.php" method="post" name="frmCadastroEmpresa" id="frmCadastroEmpresa">
          <table width="480" border="0" align="center" id="tblEmpresa">	   
            <tr>
                <td width="135" align="left">Nome<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtNome" id="txtNome" class="letrasMaiusculas" ></td>
            </tr>
            <tr>
                <td width="135" align="left">Raz�o Social<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtRazao" id="txtRazao" class="letrasMaiusculas"></td>
            </tr>	   	
          
           <!-- alterna input cpf/cnpj-->   
            <tr>
            <td align="left">CNPJ/CPF<font color="#FF0000">*</font></td> 
            <td align="left">
            	<input  id="txtCNPJ" type="text" size="20" maxlength="18"  name="txtCNPJ" class="letrasMaiusculas"  onkeydown="return NumbersOnly( event );" 
                onkeyup="CNPJCPFMsk( this );" onblur="ValidaCNPJ(this,'spamempresas');desabilitaSN(this,'txtSimplesNacional','ftDesc')" />
                <span id="spamempresas"></span>
             </td>
            </tr>
           <!-- alterna input cpf/cnpj FIM-->  
            <tr>
                <td align="left">Logradouro<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="40" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="letrasMaiusculas" /></td>
            </tr>
            <tr>
                <td align="left">N�mero<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="10" maxlength="100" name="txtNumero" id="txtNumero" class="letrasMaiusculas" /></td>
            </tr>
            <tr>
                <td align="left">Complemento</td>
                <td align="left"><input type="text" size="10" maxlength="100" name="txtComplemento" id="txtComplemento" class="letrasMaiusculas" /></td>
            </tr>
            <tr>
                <td align="left">Bairro<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="30" maxlength="100" name="txtBairro" id="txtBairro" class="letrasMaiusculas" /></td>
            </tr>
            <tr>
                <td align="left">CEP<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="10" maxlength="9" name="txtCEP" id="txtCEP" class="letrasMaiusculas" /></td>
            </tr>
            <tr>
                <td align="left">Telefone Comercial<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" class="letrasMaiusculas" size="20" maxlength="15" name="txtFoneComercial" id="txtFoneComercial" /></td>
            </tr>
            <tr>
                <td align="left">Telefone Celular</td>
                <td align="left"><input type="text" class="letrasMaiusculas" size="20" maxlength="15" name="txtFoneCelular" /></td>
            </tr>
			<tr>
				<td align="left">UF<font color="#FF0000">*</font></td>
				<td align="left">
				<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
					<select name="txtInsUfEmpresa" id="txtInsUfEmpresa" onchange="buscaCidades(this,'txtInsMunicipioEmpresa')">
						<option value=""></option>
						<?php
							$sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
							while(list($uf_busca)=mysql_fetch_array($sql)){
								echo "<option value=\"$uf_busca\"";if($uf_busca == $UF){ echo "selected=selected"; }echo ">$uf_busca</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left">Munic�pio<font color="#FF0000">*</font></td>
				<td align="left">
					<div  id="txtInsMunicipioEmpresa">
						<select name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa" class="combo">
							<?php
								$sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$UF'");
								while(list($nome) = mysql_fetch_array($sql_municipio)){
									echo "<option value=\"$nome\"";if(strtolower($nome) == strtolower($CIDADE)){ echo "selected=selected";} echo ">$nome</option>";
								}//fim while 
							?>
						</select>
					</div>
				</td>
			</tr>
            <tr>
                <td align="left">Insc. Municipal</td>
                <td align="left"><input type="text" size="20" maxlength="20" name="txtInscrMunicipal" id="txtInscrMunicipal" class="letrasMaiusculas" /></td>
            </tr>
            <tr>
                <td align="left">Email<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="30" maxlength="100" name="txtEmail" id="txtEmail" class="email" /></td>
            </tr>
            <tr>
                <td colspan="3" align="left">
                    <br /><label><input type="checkbox" value="S" name="txtSimplesNacional" id="txtSimplesNacional"/>
                    <font size="-2" id="ftDesc">
                        Esta empresa est&aacute; enquadrada no Simples Nacional, conforme Lei Complementar n�123/2006		  
                    </font></label> 
                    <br /><br />		 
                </td>
            </tr>
           <tr>
             <td colspan="2" align="left">&nbsp;</td>
             </tr>
           <tr>
             <td colspan="2" align="left">		   
              	<input type="button" value="Adicionar Respons�vel/S�cio" name="btAddSocio" class="botao" onclick="incluirSocio()" /> 
              	<font color="#FF0000">*</font>
              </td>
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
              <input type="button" value="Adicionar Servi�os" name="btAddServicos" class="botao" onclick="incluirServico()" /> 
              <font color="#FF0000">*</font></td>
           </tr>	   
           <tr>
             <td colspan="2" align="center">	 
              
    
    <table width="500" border="0" cellspacing="1" cellpadding="2">
           
         <?php include("inc/cadempresas/cadastro_servicos.php")?>
    </table>
    
            </td>
           </tr>	         
           <tr>
             <td align="left" height="15"></td>
             <td align="right"></td>
             </tr> 	  
           <tr>
             <td align="left"><input type="submit" value="Enviar" name="btEnviar" class="botao" 
			 onclick="return  (ValidaFormulario('txtNome|txtRazao|txtCNPJ|txtLogradouro|txtNumero|txtBairro|txtCEP|txtFoneComercial|txtInsUfEmpresa|txtInsMunicipioEmpresa|txtEmail|txtNomeSocio1|txtCpfSocio1|cmbCategoria1')) && (ConfereCNPJ(this))" /></td>
             <td align="right"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br /> </td>
             </tr>   
          </table>   
          </form>
          </td>
    </table>




      </td>
    </tr>
    <tr>
        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
    </tr>
</table>    
<!-- Formul�rio de inser��o de servi�os Fim--->