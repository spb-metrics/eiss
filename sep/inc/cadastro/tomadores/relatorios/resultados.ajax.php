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
//conecta ao banco
include("../../conect.php");
include("../../../funcoes/util.php");

//recebe as variaveis por get
$tomador = $_GET["txtTomador"];

?>
<table width="100%">
	<tr>
		<td>
			<fieldset><legend>Tomadores</legend>
		<?php
			//busca informacoes no banco sobre os tomadores cadastrados
			$sql_tomadores = ("SELECT codigo, nome, cnpjcpf, endereco, cep, municipio, uf, email FROM tomadores WHERE nome LIKE '$tomador%'");
			$sql=Paginacao($sql_tomadores,'frmRelatoriosTomadores','divresultados');
			$resultados=mysql_num_rows($sql);
			if(mysql_num_rows($sql)>0){
		?>
				<table width="100%">
					<tr bgcolor="#999999">
						<td width="20%" align="center">Nome</td>
						<td width="17%" align="center">CNPJ/CPF</td>
						<td width="18%" align="center">Endereço</td>
						<td width="10%" align="center">Cep</td>
						<td width="15%" align="center">Municipio</td>
                        <td width="3%">Ações</td>
					</tr>
				<?php
					$cont=0;
					while(list($codigo,$nome,$cnpjcpf,$endereco,$cep,$municipio,$uf,$email) = mysql_fetch_array($sql)){
					$nomerazao = ResumeString($nome,22);
					$end = ResumeString($endereco, 22);
					$munic = ResumeString($municipio, 18);
				
					campoHidden(txtCodigo.$cont,$codigo);
				?>
                    <tr id="trTom<?php echo $cont;?>" bgcolor="#FFFFFF">
						<td title="<?php echo $nome; ?>" align="left"><?php echo $nomerazao;?></td>
						<td title="<?php echo $cnpjcpf; ?>" align="center"><?php echo $cnpjcpf;?></td>
						<td title="<?php echo $endereco; ?>" align="center"><?php echo $end;?></td>
						<td title="<?php echo $cep; ?>" align="center"><?php echo $cep;?></td>
						<td title="<?php echo $municipio; ?>" align="center"><?php echo $munic;?></td>
                        <td width="3%" align="center"><input name="btTom" id="btLupa" type="button" class="botao" value="" 
            	onClick="VisualizarNovaLinha('<?php echo $codigo;?>','<?php echo"tdTom".$cont;?>',this,'inc/tomadores/relatorios/relatorios_vizualizar.ajax.php')"></td>
                    </tr>
                    <tr id="trTomOculta<?php echo $cont;?>">
                        <td id="<?php echo"tdTom".$cont; ?>" colspan="7" align="center"></td>
                    </tr>
				<?php
					$cont++;
					}//fim while
				?>
				</table>
			</fieldset>
		<?php
			}else{
			echo "Não há nenhum tomador cadastrado com esse nome";

			}//fim else
		?>
		</td>
	</tr>
</table>