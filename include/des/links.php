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
<!-- box de conteúdos -->
<form name="frmDesBox" method="post" action="des.php" id="frmDesBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
    <input type="hidden" name="txtTipo" id="txtTipo" value="des" />
	<input type="hidden" name="txtCNPJ" id="txtCNPJ" />
    <table width="589" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td width="190" align="center" valign="top"><!-- quadro da esquerda acima --></td>
        <td width="190" align="center" valign="top"><!-- Quadro do meio acima --></td>
        <td width="190" align="center" valign="top"><!-- quadro direita acima --></td>
      </tr>
      <tr>
        <td align="center" valign="top"><!-- quadro da esquerda abaixo -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="3" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td height="10" bgcolor="#999999"></td>
              </tr>
              <tr>
                <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Prestadores: Acesse o sistema</font> <br />
                  <br />
Acesso ao sistema  para declara&ccedil;&otilde;es<strong> on-line</strong>.</td>
              </tr>
              <tr>
                <td height="1"></td>
              </tr>
              <tr>
                <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('frmDesBox').action='../login.php';frmDesBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
              </tr>
          </table></td>
        <!-- quadro do meio abaixo -->
        <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="3" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td height="10" bgcolor="#999999"></td>
              </tr>
              <tr>
                <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Contador: Acesse o sistema</font> <br />
                  <br />
Acesso ao sistema  para declara&ccedil;&otilde;es de contadores<strong> on-line</strong>.</td>
              </tr>
              <tr>
                <td height="1"></td>
              </tr>
              <tr>
                <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('frmDesBox').action='../login.php';frmDesBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
              </tr>
          </table></td>
        <!-- quadro direita abaixo -->
        <td align="center" valign="top">
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3" bgcolor="#CCCCCC"></td>
          </tr>
          <tr>
            <td height="10" bgcolor="#999999"></td>
          </tr>
          <tr>
            <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Tomadores: DES das NF com ISS Retido</font><br />
                <br />
              Declare suas Notas Fiscais de servi&ccedil;os <strong>tomados</strong> com ISS retido.</td>
          </tr>
          <tr>
            <td height="1"></td>
          </tr>
          <tr>
            <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='issretido';frmDesBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="ISS Retido" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
          </tr>
        </table>
        
        </td>
      </tr>
      <tr>
        <td align="center" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3" bgcolor="#CCCCCC"></td>
          </tr>
          <tr>
            <td height="10" bgcolor="#999999"></td>
          </tr>
          <tr>
            <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Tomadores: Cancelar DES</font> <br />
                <br />
              Cancele uma DES justificando o motivo junto a Prefeitura Municipal.</td>
          </tr>
          <tr>
            <td height="1"></td>
          </tr>
          <tr>
            <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='tomadores_cancelardes';frmDesBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="Cancelar DES" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
          </tr>
        </table>        <!-- quadro da esquerda abaixo --></td>
        <!-- quadro do meio abaixo -->
        <td align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td height="3" bgcolor="#CCCCCC"></td>
			  </tr>
			  <tr>
				<td height="10" bgcolor="#999999"></td>
			  </tr>
			  <tr>
				<td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Tomadores: Segunda via da Guia de Pagamento</font> <br />
					<br />
				  Tomador em caso de extravio da primeira via imprima sua segunda via.</td>
			  </tr>
			  <tr>
				<td height="1"></td>
			  </tr>
			  <tr>
				<td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='segundavia_tomador';frmDesBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="Segunda Via" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
			  </tr>
			</table>			
		</td>
        <td align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td height="3" bgcolor="#CCCCCC"></td>
				  </tr>
				  <tr>
					<td height="10" bgcolor="#999999"></td>
				  </tr>
				  <tr>
					<td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Tomadores: DES Tomados gera cr&eacute;ditos</font> <br />
						<br />
					  Declare suas Notas Fiscais de servi&ccedil;os tomados, para aquisi&ccedil;&atilde;o de cr&eacute;ditos no IPTU.</td>
				  </tr>
				  <tr>
					<td height="1"></td>
				  </tr>
				  <tr>
					<td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='tomadores';frmDesBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" alt="DES Cr&eacute;ditos" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
				  </tr>
				</table>
			</td>
        <!-- quadro direita abaixo -->
      </tr>
      <tr></tr>
    </table>
  </td>
  </tr>    
  </table>
        
</form>    