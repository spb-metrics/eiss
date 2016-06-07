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
	if($_POST['btFinalizar']=="Finalizar Obra"){
        $obra=$_POST['txtCodObra'];
        $datafim=date("Y-m-d");
        mysql_query("UPDATE obras SET datafim='$datafim', estado='C' WHERE codigo='$obra'");
        Mensagem("Obra finalizada com sucesso");
    }

    // recebe o codigo da obra que sera exibida
	$codobra=$_POST["txtCodObra"];
	
	//busca os dados e exibe na tela
	$sql_obra=mysql_query("SELECT codigo,
                           obra,
                           alvara,
                           iptu,
                           endereco,
                           proprietario,
                           proprietario_cnpjcpf,
                           DATE_FORMAT(dataini, '%d/%m/%Y') AS dataini,
                           DATE_FORMAT(datafim, '%d/%m/%Y') AS datafim,
                           estado
                           FROM obras
                           WHERE codigo='$codobra'");

	$dados=mysql_fetch_array($sql_obra);
?>
<table align="center">
	<tr align="left">
		<td>Obra:</td>
		<td><?php echo $dados['obra']; ?></td>
	</tr>
	<tr align="left">
		<td>Alvará Nº:</td>
		<td><?php echo $dados['alvara']; ?></td>
	</tr>
	<tr align="left">
		<td>IPTU:</td>
		<td><?php echo $dados['iptu']; ?></td>
	</tr>
	<tr align="left">
		<td>Endereço:</td>
		<td><?php echo $dados['endereco']; ?></td>
	</tr>
	<tr align="left">
		<td>Proprietário:</td>
		<td><?php echo $dados['proprietario']; ?></td>
	</tr>
	<tr align="left">
		<td>CNPJ/CPF Proprietário:</td>
		<td><?php echo $dados['proprietario_cnpjcpf']; ?></td>
	</tr>
	<tr align="left">
		<td>Data de Inicio:</td>
		<td><?php echo $dados['dataini']; ?></td>
	</tr>
    <tr align="left">
        <td>Data de Conclusão</td>
        <td>
            <?php
                if($dados['estado']=="C"){
                    echo $dados['datafim'];
                }
                else{
                    echo "Em andamento";
                }
            ?>
        </td>
    </tr>
    <?php
        if($dados['estado']=="A"){
            ?>
                <tr align="left">
                    <td colspan="2">
                        <form method="post" onsubmit="return confirm('Deseja finalizar esta obra?')">
                            <input type="hidden" name="btObras" value="Consultar" />                          
                            <input type="hidden" name="btDetalhes" value="Detalhes" />
                            <input type="hidden" name="txtCodObra" value="<?php echo $dados['codigo']; ?>" />
                            <input type="submit" class="botao" name="btFinalizar" value="Finalizar Obra" />
                        </form>
                    </td>
                </tr>
            <?php
        }
    ?>
</table>
