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
<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<fieldset><legend>Pesquisa</legend>
		  <label>Nome: <input name="txtNome" type="text" id="txtNome" tabindex="1" /></label>
          <input type="submit" class="botao" name="btBuscar" value="Buscar" />
	</fieldset>
	<fieldset><legend>Resultado</legend>
	<?php
	$nome=$_POST['txtNome'];
	
	$sql=mysql_query("SELECT
					  	autos_infracao.codigo,
						cadastro.nome,
						autos_infracao.origem,
						autos_infracao.assunto,
						DATE_FORMAT(autos_infracao.data_hora,'%d/%m/%Y')
					  FROM
					  	autos_infracao
					  INNER JOIN cadastro ON
					  	cadastro.codigo=autos_infracao.codcadastro
					  WHERE
					  	(cadastro.nome LIKE '%$nome%' OR cadastro.razaosocial LIKE '%$nome%')
					  
					  ");
	if(!mysql_num_rows($sql)){
		echo "<p align=\"center\"><b>Nenhum resultado encontrado</b></p>";
	}else{
		?>
		<table align="center" width="100%">
			<tr bgcolor="#999999">
				<td align="center">Nome</td>
				<td align="center">Origem</td>
				<td align="center">Assunto</td>
				<td align="center">Data/Hora</td>
			</tr>
			<?php
			while(list($codigo,$nome,$origem,$assunto,$data)=mysql_fetch_array($sql)){
			?>
			<tr bgcolor="#FFFFFF">
				<td align="center"><?php echo $nome; ?></td>
				<td align="center"><?php echo $origem; ?></td>
				<td align="center"><?php echo $assunto; ?></td>
				<td align="center"><?php echo $data; ?></td>
			</tr>
			<?php
			}//fim while list
			?>
		</table>
		<?php
	}//fim if se existe resultado
	?>
	</fieldset>
</form>

