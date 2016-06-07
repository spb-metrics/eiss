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
				WHERE emissores.nome LIKE '$nome%' AND emissores.cnpjcpf LIKE '$cnpj%' $string  ORDER BY emissores.nome ASC ");
					
?>
	<fieldset>			
		<form method="post">
			<table width="520" align="center">    
				<tr> 
					<td align="left">Nome</td>
					<td align="center">Cpf/Cnpj</td>
					<td align="center">Estado</td>
					<td align="left"></td>
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
			
			?> 
			</table>
		</form>
	</fieldset>
			
			<?php } // FIM DO IF BOTAO PESQUISAR?>