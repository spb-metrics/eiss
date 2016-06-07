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
	include("../site/inc/conect.php");
	include("../funcoes/util.php");
	$codigo= base64_decode($_GET["COD"]);



	// busca os dados do municipio
	$sql=mysql_query("SELECT cidade, secretaria, brasao FROM configuracoes");
	list($CIDADE,$SECRETARIA,$BRASAO)=mysql_fetch_array($sql);

	// busca os dados da inst. financeira
	$sql_inst=mysql_query("
		SELECT 
			IF(cnpj IS NULL,cpf,cnpj), 
            razaosocial,
            logradouro,
            numero,
            complemento,
            bairro,
            municipio,
            uf,
            cep
        FROM 
			cadastro
        WHERE 
			codigo='$codigo'
		");
	list($cnpj,$razaosocial,$logradouro,$numero,$complemento,$bairro,$municipio,$uf,$cep)=mysql_fetch_array($sql_inst);
    $endereco=$logradouro.", ".$numero.", ";
    if($complemento){
        $endereco.=$complemento;
    }
    $endereco.=$bairro.", ";
    $endereco.="CEP ".$cep;
?>
<title>Comprovante de Cadastro</title>
<div id="imprimir">
	<input type="button" onClick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" value="Imprimir" />
</div>
<table width="800" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td height="100" colspan="4">
	<table border="0" cellspacing="0" cellpadding="5" style="border: 0px;">
      <tr>
        <td width="150" style="border:0px;" align="left"><?php if($CONF_BRASAO){?><img src="../img/brasoes/<?php echo $CONF_BRASAO; ?>"><?php }?></td>
        <td width="520" style="border:0px;" align="left" valign="middle">
		<font class="prefeitura">Prefeitura Municipal de <?php echo $CIDADE; ?></font><br>
		<font class="secretaria"><?php echo $SECRETARIA; ?><br>
		Comprovante de Cadastro de Empresa </font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" width="50%" bgcolor="#CCCCCC" colspan="2"><strong>N&Uacute;MERO DO DOCUMENTO</strong></td>
    <td align="center" bgcolor="#CCCCCC" colspan="2"><strong>DATA DE EMISS&Atilde;O </strong></td>
  </tr>
  <tr>
    <td align="center" colspan="2" width="50%"><font class="prefeitura"><?php echo $codigo ?></font></td>
    <td align="center" colspan="2"><font class="prefeitura"><?php echo DataPtExt(); ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>IDENTIFICA&Ccedil;&Atilde;O DO SUJEITO PASSIVO </strong></td>
  </tr>
  <tr>
    <td height="50" colspan="3" valign="top">Raz�o Social:<br>
    <font class="prefeitura"><?php echo $razaosocial; ?></font></td>
    <td width="25%" valign="top">CNPJ<br>
    <font class="prefeitura"><?php echo $cnpj; ?></font></td>
  </tr>
  <tr>
    <td height="75" colspan="4" valign="top">Endere&ccedil;o<br>
    <font class="prefeitura"><?php echo "$endereco, $municipio, $uf"; ?></font></td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>CERTIFICA&Ccedil;&Atilde;O</strong></td>
  </tr>
  <tr>
    <td height="200" colspan="4" align="center" valign="middle"><div class="style1">
      <blockquote>A Prefeitura Municipal de <font class="prefeitura"><?php echo $CIDADE; ?></font> certifica que a Empresa de Constru��o Civil citada acima foi devidamente cadastrada no sistema de ISSDigital do munic�pio.</blockquote>
    </div>   </td>
  </tr>
  <tr>
    <td height="30" colspan="4" align="center" bgcolor="#CCCCCC"><strong>OBSERVA&Ccedil;&Otilde;ES</strong></td>
  </tr>
  <tr>
    <td colspan="4"><p>- A senha de acesso da Empresa ao sistema de ISSDigital do munic�pio � de uso exclusivo e intransfer�vel da Empresa, bem como a responsabilidade sobre o uso indevido da mesma.
    </p></td>
  </tr>
  <tr>
    <td height="50" colspan="4"><font class="prefeitura"><?php ?></font>.  </td>
  </tr>
</table>