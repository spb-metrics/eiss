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
 if($btInserirNota !="")
 {
  
  $aux = explode("|",$cmbCodServico);
  $CODIGO_SERVICO = $aux[1];
  
  $dataehora = implode("-", array_reverse(explode("/", substr($txtNotaDataHoraEmissao, 0, 10)))).substr($txtNotaDataHoraEmissao, 10);	
  $dataehora.=':00';
  $data = implode('-', array_reverse(explode('/',$txtRpsData))); 
  	 
  $sql=mysql_query("INSERT INTO notas SET `numero`='$txtNotaNumero', `codverificacao`='$txtNotaCodigoVerificacao', `codemissor`='$CODIGO_DA_EMPRESA', `rps_numero`='$txtRpsNum', `rps_data`='$data', `tomador_nome`='$txtTomadorNome', `tomador_cnpjcpf`='$txtTomadorCNPJ', `tomador_inscrmunicipal`='$txtTomadorIM', `tomador_endereco`='$txtTomadorEndereco', `tomador_cep`='$txtTomadorCEP', `tomador_municipio`='$txtTomadorMunicipio', `tomador_uf`='$txtTomadorUF', `tomador_email`='$txtTomadorEmail', `discriminacao`='$txtNotaDiscriminacao', `valortotal`='$txtValTotal', `valordeducoes`='$txtValorDeducoes', `basecalculo`='$txtBaseCalculo', `valoriss`='$txtISS', `credito`='$txtCredito', `estado`='N'
  ,`codservico`='$CODIGO_SERVICO',`datahoraemissao`='$dataehora'"); 
  add_logs('Inseriu nota fiscal');
 print("<script language=JavaScript>alert('Nota cadastrada com sucesso!!')</script>");
 }



// SELECIONA A ULTIMA NOTA INSERIDA PELA EMPRESA
$sql=mysql_query("SELECT ultimanota FROM emissores WHERE codigo ='$CODIGO_DA_EMPRESA'");
list($ultimanota)=mysql_fetch_array($sql);
$ultimanota+=1;

//GERA O CÓDIGO DE VERIFICAÇÃO
$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';
$max = strlen($CaracteresAceitos)-1;
$password = null;
 for($i=0; $i < 8; $i++) {
 $password .= $CaracteresAceitos{mt_rand(0, $max)}; 
 $carac = strlen($password); 
 if($carac ==4)
 { 
 $password .= "-";
 } 
}

$sql_servicos=mysql_query("
	  SELECT emissores_servicos.codigo,servicos.codigo,servicos.codservico,servicos.descricao,servicos.aliquota 
	  FROM servicos
	  INNER JOIN emissores_servicos ON servicos.codigo = emissores_servicos.codservico
	  WHERE emissores_servicos.codemissor = '$CODIGO_DA_EMPRESA'");

?>

<fieldset style="width:500px"><legend>Inserir Nota</legend>
<br>
<form name="frmInserir" method="post" action="notas.php?btInserir=T">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3"><strong>Informações da Nota</strong></td>
  </tr>
  <tr>
    <td>Número</td>
    <td>Data e Hora de Emissão</td>
    <td>Código de Verificação</td>
  </tr>
  <tr>
    <td><input name="txtNotaNumero" style="text-align:center;" type="text" size="10" class="texto" readonly="yes" value="<?php print $ultimanota;?> "></td>
    <td><input name="txtNotaDataHoraEmissao" style="text-align:center;" type="text" size="20" class="texto" readonly="yes" value="<?php print date('d/m/Y H:i'); ?>"></td>
    <td><input name="txtNotaCodigoVerificacao" style="text-align:center;" type="text" size="20" class="texto" readonly="yes" value="<?php print $password;?>"></td>
  </tr>  
   <tr>
    <td align="left">Número do RPS</td>
	<td align="left"><input name="txtRpsNum" style="text-align:center;" type="text" size="20" class="texto"></td>
  </tr>
  <tr>
    <td align="left">Data do RPS</td>
	<td align="left"><input name="txtRpsData" style="text-align:center;" type="text" size="10" maxlength="10" class="texto" onkeypress="formatar(this,'00/00/0000')"></td>
  </tr>
</table><br />

<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
    <td colspan="2"><strong>Tomador de Serviços</strong></td>
  </tr>
  <tr>
    <td width="25%" align="left">Nome/Razão Social</td>
    <td width="75%" align="left"><input name="txtTomadorNome" type="text" size="55" class="texto"></td>
  </tr>
  <tr>
    <td align="left">CPF/CNPJ</td>
    <td align="left"><input name="txtTomadorCNPJ" type="text" size="20" class="texto" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"  maxlength="18"></td>
  </tr>
  <tr>
    <td align="left">Inscrição Municipal</td>
    <td align="left"><input name="txtTomadorIM" type="text" size="30" class="texto"></td>
  </tr>
  <tr>
    <td align="left">Endereço</td>
    <td align="left"><input name="txtTomadorEndereco" type="text" size="55" class="texto"></td>
  </tr>
  <tr>
    <td align="left">CEP</td>
    <td align="left"><input name="txtTomadorCEP" type="text" size="15" class="texto"></td>
  </tr>
  <tr>
    <td align="left">Município</td>
    <td align="left"><input name="txtTomadorMunicipio" type="text" size="30" class="texto">&nbsp;&nbsp;UF <input name="txtTomadorUF" type="text" size="2" class="texto"></td>
  </tr>
  <tr>
    <td align="left">E-mail</td>
    <td align="left"><input name="txtTomadorEmail" type="text" size="30" class="texto"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><strong>Discriminação dos Serviços</strong></td>
  </tr>
  <tr>
    <td><textarea name="txtNotaDiscriminacao" cols="53" rows="5" class="texto" style="width:90%"></textarea></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2"><strong>C&aacute;lculos da Nota </strong></td>
  </tr>
  <tr o>
    <td align="left" width="35%">Código do Serviço</td>
    <td align="left" width="65%">
	  <!-- busca a relacao dos servicos por empresa -->
	  <select name="cmbCodServico" size="1" style="width:295px;" id="cmbCodServico" onchange="MostraAliquota()" >
	   <option value=""> Selecione o Serviço </option>	        
	  <?php while(list($codigo_empresas_servicos,$codigo,$codservico,$descricao,$aliquota)=mysql_fetch_array($sql_servicos))
	  {	   
       print("<option value=\"$aliquota|$codigo\"> $descricao </option>");
	  }	
   	  ?>
	</select>
	</td>
  </tr>
  <tr>
    <td align="left">Alíquota</td>
    <td align="left">
	
	<input  id="txtAliquota" name="txtAliquota" type="text" size="5" class="texto" readonly="yes"> %</td>
  </tr>
  <tr>
    <td align="left">Valor Total das Deduções</td>
    <td align="left">R$ <input name="txtValorDeducoes" type="text" size="10" class="texto" id="txtValorDeducoes"> <em>exemplo: 1912.55</em></td>
  </tr>
  <tr>
    <td align="left">Base de Cálculo</td>
    <td align="left">R$<?php print("
	<input name=\"txtBaseCalculo\" type=\"text\" size=\"10\" class=\"texto\" id=\"txtBaseCalculo\"
	onblur=\"ValorIss('$CREDITO1','$REGRA1','$CREDITO2','$REGRA2','$CREDITO3')\">");?> <em>exemplo: 1912.55</em></td>
  </tr>
  <tr>
    <td align="left">Valor Total da Nota</td>
    <td align="left">R$ <input name="txtValTotal" id="txtValTotal" type="text" size="10" class="texto" readonly="yes"></td>
  </tr>
  <tr>
    <td align="left">Valor do ISS</td>
    <td align="left">R$ <input name="txtISS" type="text" size="10" class="texto" readonly="yes" id="txtISS"></td>
  </tr>
  	 
	 
  <tr>
    <td align="left">Crédito p/ Abatimento</td>
    <td align="left">R$ <input name="txtCredito" type="text" size="10" class="texto" readonly="yes"></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input name="btInserirNota" type="submit" value="Inserir" class="botao"></td>
  </tr>  
</table>
</form>
</fieldset>