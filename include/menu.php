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
	session_name("emissores_iss");
	session_start();
	$tipo=$_SESSION["TIPO"];
	$logout="logout";
	$logout =base64_encode($logout);    
	$sql=mysql_query("SELECT menu, link FROM menus_cadastro WHERE tipo='$tipo' AND visivel='S' ORDER BY ordem");
	$x=0;
	while(list($opcao,$caminho)=mysql_fetch_array($sql))
	{
		//testa se nao tem codigo de contador nao pode aparecer o menu contador
		if( (($caminho == "clientes") && (!$_SESSION['contador'])) ||
		 //testa se tem codigo de contador nao aparece o menu de contador pq ele ja é um
		 (($caminho == "definircontador") && ($_SESSION['contador'])) ){
			continue;//continue serve para pular essa volta do while e ir para a proxima volta e nao executendo as proximas linhas
		}
		$menu[$x]="$opcao";
		$links[$x]="$caminho";
		$x++;
		
	}
	$cont = count($menu);
	$aux = 0;
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
$cnpjcpf = $_SESSION['login'];
$sql_des = mysql_query("SELECT codtipodeclaracao FROM cadastro WHERE ".tipoPessoa($cnpjcpf)."='{$cnpjcpf}'");
list($tipodeclaracao)=mysql_fetch_array($sql_des);
// lista itens de menu
while($aux < $cont) {
	// imprime html
	
	$tipom = $links[$aux];
	
	if($tipom=='comtomador'){
		$tipomenu = '1';
	}
	if($tipom=='semtomador'){
		$tipomenu = '2';
	}
	if($tipomenu==$tipodeclaracao || !$tipomenu){
		
		$links[$aux]=base64_encode($links[$aux]);
		
		?>
		  <tr>
			<td height="20" class="menu"><?php print(" <a class=\"menu\" href=principal.php?pag=$links[$aux] target=_parent>&nbsp;$menu[$aux]</a>");?></td>
		  </tr>
		  <tr>
			<td height="1" bgcolor="#CCCCCC"></td>
		  </tr>
		<?php
	}
	unset($tipomenu);
	$aux++;
// fecha while
}
?>
<tr>
    <td height="20" class="menu">
    	<a class="menu" href="principal.php?pag=<?php echo $logout;?>" target=_parent>&nbsp;Sair</a>
    </td>
  </tr>
  <tr>
    <td height="1" bgcolor="#CCCCCC"></td>
  </tr>
</table><br>
