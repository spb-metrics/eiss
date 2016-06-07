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
<table width="580" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="5%" height="10" bgcolor="#FFFFFF"></td>
        <td width="25%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de Obras</td>
        <td width="70%" bgcolor="#FFFFFF"></td>
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
        <td height="60" colspan="3" bgcolor="#CCCCCC" align="left">
            <form method="post">
                <table align="center">
                    <tr>
                        <td><input name="btObras" type="submit" class="botao" value="Cadastrar"></td>
                        <td><input name="btObras" type="submit" class="botao" value="Consultar"></td>
                    </tr>
                </table>
            </form>
            <?php
                if($_POST["btObras"])
                    {
                        if($_POST["btObras"]=="Cadastrar")
                            {
                                include("include/decc/obras/obras_cadastro.php");
                            }
                        elseif($_POST["btObras"]=="Consultar")
                            {
                                include("include/decc/obras/obras_consulta.php");
                            }
                    }
            ?>
        </td>
    </tr>
    <tr>
        <td height="1" bgcolor="#CCCCCC" colspan="3"></td>
        <td bgcolor="#CCCCCC"></td>
    </tr>
</table>