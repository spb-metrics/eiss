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
<br />
<form method="post" action="include/decc/obras/obras_inserir.php" onsubmit="return (ConfereCNPJ('hdCNPJ')) && (ValidaSenha('txtSenha','txtSenhaConf')) && (ValidaFormulario('txtObra|txtAlvara|txtEndereco|txtProprietario|txtCnpjCpf|txtData','Preencha todos os campos.'))">
	<table>
		<tr align="left">
			<td>Obra:</td>
			<td><input type="text" class="texto" name="txtObra" id="txtObra" size="48" /></td>
		</tr>
		<tr align="left">
			<td>Alvará Nº:</td>
			<td><input type="text" class="texto" name="txtAlvara" id="txtAlvara" size="20" /></td>
		</tr>
		<tr align="left">
			<td>IPTU:</td>
			<td><input type="text" class="texto" name="txtIptu" id="txtAlvara" size="20" /></td>
		</tr>
		<tr align="left">
			<td>Endereço:</td>
			<td><input type="text" class="texto" name="txtEndereco" id="txtEndereco" size="48" /></td>
		</tr>
		<tr align="left">
			<td>Proprietário:</td>
			<td><input type="text" class="texto" name="txtProprietario" id="txtProprietario" size="40" /></td>
		</tr>
		<tr align="left">
			<td>CNPJ/CPF Proprietário:</td>
			<td><input type="text" class="texto" name="txtCnpjCpf" id="txtCnpjCpf" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" size="20" maxlength="18" /></td>
		</tr>
        <tr align="left">
            <td>Lista de Materiais</td>
            <td>
                <textarea rows="5" cols="37" class="texto" name="txtListaMateriais"></textarea>
            </td>
        </tr>
        <tr align="left">
            <td>Valor dos Materiais</td>
            <td><input type="text" class="texto" name="txtValorMateriais" onkeydown="return NumbersOnly( event );" onkeyup="MoedaToDec( this )" size="10" /></td>
        </tr>
		<tr align="left">
			<td colspan="2" height="30" valign="bottom"><input type="submit" class="botao" name="btConfirmar" value="Confirmar" /></td>
		</tr>
	</table>
</form>