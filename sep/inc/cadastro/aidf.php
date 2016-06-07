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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;AIDF</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
    <form method="post" id="frmAidf" onsubmit="return false">
        <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />	
        <fieldset style="width:663px;"><legend>Consultar Solicitações</legend>
            <table width="100%" border="0" cellpadding="2" cellspacing="2">
                <tr>
                    <td>Nome do Prestador</td>
                    <td><input name="txtEmissor" type="text" class="texto" size="60" /></td>
                </tr>
                <tr>
                    <td>CNPJ / CPF</td>
                    <td>
                        <input name="txtCNPJ" type="text" class="texto" size="20" value="" /> 
                        <em>Somente n&uacute;meros</em> 
					</td>
				</tr>
				<tr>
                    <td>Estado</td>
                    <td>
                    	<select name="cmbEstado">
                    		<option value="s">Liberadas</option>
                    		<option value="n">Pendentes</option>
                    		<option value="" selected="selected">Ambas</option>
                    	</select>
					</td>
				</tr>
				<tr>
                    <td>Período</td>
                    <td>
                    	<input name="txtData1" id="txtData1" type="text" class="texto" size="10" /> a 
                    	<input name="txtData2" id="txtData2" type="text" class="texto" size="10" />
					</td>
				</tr>
				<tr>
                    <td>&nbsp;</td>
                    <td>
                    	<input type="submit" name="btBusca" value="Buscar" class="botao" 
                    		onclick="acessoAjax('inc/cadastro/aidf_busca.ajax.php','frmAidf','divaidf')" />
                    </td>
                </tr>
            </table>		
        </fieldset>
        <div id="divaidf"></div>
     </form>
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>

<script type="text/javascript" src="scripts/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery_calendario.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery_calendario.css" />
<script type="text/javascript">
$('#txtData1').focus(function(){  
	$(this).calendario({  
		target:'#txtData1',
		top: 0,
		left: 185  
	});
});
$('#txtData2').focus(function(){  
	$(this).calendario({  
		target:'#txtData2',
		top: 0,
		left: 100  
	});  
});


</script>
