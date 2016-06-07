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
include("../conect.php");

$cnpj_grafica = $_GET["txtCNPJGrafica"];

//busca os dados do cnpj digitado, verificando se existe ou se nao esta INATIVO.

$sql_grafica=mysql_query("
						  SELECT codigo, nome, razaosocial, inscrmunicipal, 
						   	logradouro,
							numero,
							complemento,
							bairro,
							cep,
							municipio, uf, email, estado
						  FROM cadastro WHERE cnpj='$cnpj_grafica' OR cpf='$cnpj_grafica' AND estado <> 'I' 
						  ");

//lista os dados da grafica.
list($codigo_grafica, $nome_grafica, $razaosocial_grafica, $inscrmunicipal_grafica, $logradouro_grafica,$numero_grafica,$complemento_grafica,$bairro_grafica,$cep_grafica, $municipio_grafica, $uf_grafica, $email_grafica, $estado) = mysql_fetch_array($sql_grafica);

if(mysql_num_rows($sql_grafica)<=0){
	?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
  <tr>
			<td align="center" colspan="2"><strong>Gr&aacute;fica N&atilde;o cadastrada no sistema</strong><br>
				Favor verificar o CNPJ/CPF da gr&aacute;fica ou entrar em contato com a gr&aacute;fica.</td>
		</tr>
	</table>
<?php
}elseif($estado=="NL"){
	?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
		<tr>
			<td align="center" colspan="2"><strong>Gr&aacute;fica N&atilde;o liberada pela prefeitura</strong><br>
				Favor verificar o CNPJ/CPF da gr&aacute;fica ou entrar em contato com a gr&aacute;fica.</td>
		</tr>
	</table>
	<?php
}else{//fim if se a grafica esta cadastrada


?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
    <tr>
        <td>
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC">
          <tr>
            <td width="150" align="left">Nome:</td>
                <td align="left" bgcolor="#FFFFFF"><?php echo $nome_grafica; ?></td>
          </tr>
          <tr>
            <td align="left">Raz&atilde;o Social:</td>
                <td align="left" bgcolor="#FFFFFF"><?php echo $razaosocial_grafica; ?></td>
          </tr>
          <tr>
            <td align="left">Endere&ccedil;o:</td>
                <td align="left" bgcolor="#FFFFFF"><?php echo "$logradouro_grafica $numero_grafica $complemento_grafica, $municipio_grafica, $uf_grafica"; ?></td>
          </tr>
          <tr>
            <td align="left">Inscri&ccedil;&atilde;o Municipal:</td>
                <td align="left" bgcolor="#FFFFFF"><?php echo $inscrmunicipal_grafica; ?></td>
          </tr>
            <tr>
                <td colspan="2"><br></td>
            </tr>
        </table>
        </td>
    </tr>
  <tr>
    <td>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
        <tr>
            <td height="20" colspan="6" align="center" bgcolor="#999999"><font color="#FFFFFF"><em>Documento a ser Impresso	</em></font></td>
        </tr>
        <tr valign="center">
          <td align="center">Esp&eacute;cie</td>
                <td align="center">S&eacute;rie</td>
                <td align="center">Sub-<br />S&eacute;rie</td>
                <td align="center">Numera&ccedil;&atilde;o</td>
                <td align="center">Quantidade</td>
                <td align="center">Tipo</td>
            </tr>
        <?php for($cont=1;$cont<=5;$cont++){ ?>
        <tr>
			  <td align="center"><input type="text" name="txtEspecie<?php echo $cont; ?>" id="txtEspecie<?php echo $cont; ?>" size="30" class="texto" maxlength="50"></td>
                <td align="center"><input type="text" name="txtSerie<?php echo $cont; ?>" id="txtSerie<?php echo $cont; ?>" size="6" class="texto" maxlength="2" onkeydown="return NumbersOnly(event)" ></td>
                <td align="center"><input type="text" name="txtSubserie<?php echo $cont; ?>" id="txtSubserie<?php echo $cont; ?>" size="6" class="texto" maxlength="10" onkeydown="return NumbersOnly(event)"></td>
                <td align="center"><input type="text" name="txtNroinicial<?php echo $cont; ?>" id="txtNroinicial<?php echo $cont; ?>" size="6" class="texto" maxlength="10" onkeydown="return NumbersOnly(event)">&agrave;<input type="text" name="txtNrofinal<?php echo $cont; ?>" id="txtNrofinal<?php echo $cont; ?>" size="6" class="texto" maxlength="10" onkeydown="return NumbersOnly(event)"></td>
                <td align="center"><input type="text" name="txtQuantidade<?php echo $cont; ?>" id="txtQuantidade<?php echo $cont; ?>" size="8" class="texto" maxlength="10" onkeydown="return NumbersOnly(event)"></td>
                <td align="center"><input type="text" name="txtTipo<?php echo $cont; ?>" id="txtTipo<?php echo $cont; ?>" size="10" class="texto" maxlength="10"></td>
            </tr>
        <?php }//fim for ?>
            <tr>
                <td colspan="6"><br></td>
            </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td>
      <table align="center" bgcolor="#CCCCCC" width="100%">
        <tr>
          <td valign="top">Oberva&ccedil;&otilde;es:</td>
                <td colspan="5"><textarea name="txtObservacoes" id="txtObservacoes" cols="50" rows="3" class="texto"></textarea></td>
            </tr>
      </table>
        </td>
    </tr>
  <tr>
    <td align="left">
        <input type="submit" name="btConfirmar" value="Confirmar" class="botao" />
        <input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='aidf.php'">
        <input type="hidden" name="txtCodgrafica" value="<?php echo $codigo_grafica; ?>">

    </td>
    </tr>
</table>
<?php 
}//fim else se encontrou a grafica
?>