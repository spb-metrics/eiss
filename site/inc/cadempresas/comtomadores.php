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
<fieldset>
	<form method="post" name="frmPesquisar">
	<input type="hidden" id="txtMenu" name="txtMenu" value="<?php echo $_POST['txtMenu']; ?>" />
		<table width="520" align="center">
			<tr> 
				<td align="left">Nome</td> 
				<td align="left"><input type="text" name="txtBuscaNome" class="texto" ></td> 
			</tr>
			<tr> 
				<td align="left">Cnpj/Cpf</td>
				<td align="left"><input name="txtBuscaCnpj" type="text" maxlength="18" size="20" id="txtBuscaCnpj" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" class="texto"/></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="radio" name="rdbTipo" value="empresa" checked/>Empresas
					<input type="radio" name="rdbTipo" value="contador" />Contadores
				</td>
			</tr>
			<tr>       
				<td align="left"><input type="submit" value="Procurar" class="botao" name="btPesquisarEmpresa"></td>
			</tr>
		</table>
	</form>
</fildset>
<?php
	$nome = $_POST['txtBuscaNome'];
	$cnpj = $_POST['txtBuscaCnpj'];
	
	//$sqlmunicipio =  	
	
		if($_POST['btPesquisarEmpresa'] == "Procurar")
			{  
				if($rdbTipo=="empresa")
					{
						$string="AND usuarios.tipo='empresa'";
					}
				elseif($rdbTipo=="contador")
					{
						$string="AND usuarios.tipo='contador'";
					}
				else
					{
						$string="";
					} //FIM DO ELSE
				$sql_buscaempresa=mysql_query("SELECT emissores.codigo, emissores.nome, emissores.cnpjcpf, emissores.estado FROM emissores 
				INNER JOIN usuarios ON emissores.cnpjcpf=usuarios.login WHERE emissores.nome LIKE '$nome%' AND emissores.cnpjcpf LIKE '$cnpj%' $string  ORDER BY emissores.nome ASC ");

	if(mysql_num_rows($sql_buscaempresa) > 0)
	{
?>
		<form method="post">
			<table width="520" align="center">
				<tr bgcolor="#999999">
					<td align="left">Nome</td>
					<td align="center">Cpf/Cnpj</td>
					<td align="center">Estado</td>
				</tr>

<?php
			// Troca caractere do estado da empresa para a palavra completa
			while(list($codigo, $nome, $cpfcnpj, $estado)=mysql_fetch_array($sql_buscaempresa))
			{
				if($estado == "A") 
					$estado = "Ativo";
				else
					$estado = "Inativo";

			print
			("
			<tr>
				<td align=left bgcolor=#FFFFFF>$nome</td>
				<td align=center bgcolor=#FFFFFF>$cpfcnpj</td>
				<td align=center bgcolor=#FFFFFF>$estado</td>
				<td align=right></a></td>
			</tr>
			");
			} //FIM DO WHILE
			} // FOM DO SQL ROWNS
			?> 
			</table>
		</form>
			<?php } // FIM DO IF BOTAO PESQUISAR?>