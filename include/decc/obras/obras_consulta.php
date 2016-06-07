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
<form method="post">
	<input type="hidden" name="btObras" value="Consultar" />
	<table align="center">
		<tr align="left">
			<td>Obra:</td>
			<td><input type="text" class="texto" name="txtObra" /></td>
		</tr>
		<tr align="left">
			<td>Alvará:</td>
			<td><input type="text" class="texto" name="txtAlvara" /></td>
		</tr>
		<tr align="left">
			<td colspan="2"><input type="submit" class="botao" name="btBuscar" value="Buscar" /></td>
		</tr>
	</table>
</form>
<?php
	if($_POST["btBuscar"]=="Buscar")
		{
			// recebe os dados
			$obra=strip_tags(addslashes($_POST["txtObra"]));
			$alvara=strip_tags(addslashes($_POST["txtAlvara"]));
            $sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='".$_SESSION['login']."'");
            list($codcadastro)=mysql_fetch_array($sql);
			
			// busca as obras da empreiteira logada
			$sql_busca=mysql_query("SELECT codigo,
                                    obra
                                    FROM obras                                   
                                    WHERE obra LIKE '%$obra%'
                                    AND alvara LIKE '%$alvara%'
                                    AND codcadastro='$codcadastro'");

            // lista todas as obras da empreiteira logada, com a opcao de visualizar os detalhes de cada obra
			?>
                            <form method="post">
                                <input type="hidden" name="txtCodObra" id="txtCodObra" />
                                <input type="hidden" name="btObras" value="Consultar" />
                                <table align="center">
                         <?php
                            if(mysql_num_rows($sql_busca)>0){
                                while($dados=mysql_fetch_array($sql_busca))
                                    {
                                        ?>
                                            <tr align="left">
                                                <td><?php echo $dados['obra']; ?></td>
                                                <td>
                                                    <input type="submit" class="botao" name="btDetalhes" value="Detalhes" onclick="document.getElementById('txtCodObra').value='<?php echo $dados['codigo']; ?>'" />
                                                </td>
                                            </tr>
                                        <?php
                                    }
                            }
                            else{
                                ?>
                                            <tr align="left">
                                                <td colspan="2">Nenhuma obra encontrada!</td>
                                            </tr>
                                <?php
                            }
                                    ?>
                                            </table>
                                        </form>
                    <?php

		}
	if($_POST["btDetalhes"]=="Detalhes")
		{
			include("include/decc/obras/obras_detalhes.php");
		}	
?>