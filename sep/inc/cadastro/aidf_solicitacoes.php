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
<form name="frmPendentes" id="frmPendentes" method="post">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="cod" id="cod"/>
	<input type="hidden" name="aberto" id="aberto">
	
<fieldset style="width:663px;">
	<legend>Solicitações Pendentes</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
		<tr bgcolor="#999999">
			<td width="40%" align="center" bgcolor="#999999">Prestador</td>
			<td width="20%" align="center">CNPJ/CPF</td>
			<td width="15%" align="center">AIDF</td>
			<td width="15%" align="center"></td>	
		</tr>
	<?php
		$x=0;
		while(list($codaidf,$codemissor,$emissores_nome,$emissores_cnpjcpf,$aidf_data)=mysql_fetch_array($sql))
			{
	?>
        <tr>
            <td align="left" bgcolor="FFFFFF">&nbsp;<?php echo $emissores_nome; ?></td>
            <td align="center" bgcolor="FFFFFF"><?php echo $emissores_cnpjcpf; ?></td>
            <td align="center" bgcolor="FFFFFF"><?php echo DataPt($aidf_data); ?></td>
            <td align="center">
              <input type="button" name="btVisualizar" value="Visualizar" class="botao" onClick="VisualizarNovaLinha('<?php echo $codaidf;?>','<?php echo"tdLiberar".$x;?>',this,'inc/prestadores/aidf_liberar.ajax.php')" />
            </td>
        </tr>
		<tr>
		 	<td id="<?php echo"tdLiberar".$x; ?>" colspan="3" align="center" >
			</td>
		</tr>
     <?php				
				$x++;
			} // fim while
	?>	
	</table>
</fieldset>
</form>