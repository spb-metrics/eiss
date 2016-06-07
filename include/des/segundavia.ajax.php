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
	<script src="../../scripts/padrao.js"></script>
<?php	
	
	session_name("emissores_iss");
	session_start();	
	
	$emissor_CNPJ = $_SESSION['login'];	 	
	include("../conect.php");
	include("../../funcoes/util.php");
	//lista todas as guias te tabelas diferentes unindo-as com UNION do sql: des, des_temp e des_issretido
	
		$stringSql = ("			
		SELECT
			guia_pagamento.codigo, 
			guia_pagamento.dataemissao,
			guia_pagamento.valor, 
			guia_pagamento.datavencimento,
			guia_pagamento.pago,
			guia_pagamento.nossonumero
		FROM
			guia_pagamento
		INNER JOIN 
			guias_declaracoes ON guias_declaracoes.codguia = guia_pagamento.codigo  
		INNER JOIN 
			des ON des.codigo = guias_declaracoes.codrelacionamento
		INNER JOIN
			cadastro ON cadastro.codigo = des.codcadastro
		WHERE
			guia_pagamento.pago = 'N'  AND
			(cadastro.cpf = '$emissor_CNPJ' OR cadastro.cnpj = '$emissor_CNPJ')	AND
			guias_declaracoes.relacionamento = 'des' AND 
			guia_pagamento.estado != 'C'
		GROUP BY 
			guia_pagamento.codigo
		ORDER BY 
			datavencimento DESC,
			guia_pagamento.codigo DESC	
		"); 
	
				
	
		
	$sql_guias=Paginacao($stringSql,'frmGuia','Container',12);
	
  
$cont = 0;  
  	
	//cria a lista de campos para preenchimento da declaracao	
	if(mysql_num_rows($sql_guias)){
		?>
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
	                <tr>
	                  <td align="center" bgcolor="#CCCCCC">Nosso Número</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Emissão</td>
	                  <td align="center" bgcolor="#CCCCCC">Valor (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Venc</td>
	                  <td align="center" bgcolor="#CCCCCC">Pendente</td>
	                  <td align="center" bgcolor="#CCCCCC">Imprimir</td>
	                 </tr>
		<?php
		while(list($codigo, $dataemissao, $valor, $datavencimento, $pago,$nossonumero_guia) = mysql_fetch_array($sql_guias)){
		?>                
		                <tr>
		                  <td align="center">
		                  	<input name="txtCodigoGuia<?php echo $cont;?>" type="text" class="texto" id="txtCodigoGuia<?php echo $cont;?>" value="<?php echo $nossonumero_guia; ?>" size="12" style="text-align:center;" readonly />	                  
		                  </td>
		                  <td align="center">
	                      	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>" value="<?php echo DataPt($dataemissao); ?>" size="10" readonly />		              
	                      </td>
		                  <td align="center">
	                      	<input name="txtValor<?php echo $cont;?>" type="text" class="texto" id="txtValor<?php echo $cont;?>" value="<?php echo DecToMoeda($valor); ?>" size="15" readonly style="text-align:right" />                      
	                      </td>
		                  <td align="center">
		                  	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>2" value="<?php echo DataPt($datavencimento); ?>" size="10" readonly />
		                  </td>
		                  <td align="center">
		                  	<input name="txtSituacao<?php echo $cont;?>" type="text" class="texto" id="txtSituacao<?php echo $cont;?>2" value="<?php if($pago == 'N') { echo "Sim";} else { echo "N&atilde;o"; }; ?>" size="3" style="text-align:center" readonly />
		                  </td>
		                  <td align="center">
		                  	<input name="imgImprimir<?php echo $cont;?>" id="imgImprimir<?php echo $cont;?>" type="image" src="img/botoes/botao_imprimir.jpg" onClick="return SubmitSegundaViaGuia('<?php echo $cont;?>');">
		                  </td>
		                </tr>
		<?php
			// incrementa contador
			$cont++;
		}//fim while listagem dos campos pra declaracao
		?>
		</table>
		<?php
	}else{
		echo("<center><b>Nenhuma guia gerada</b></center>");
		
	}
	?>                  	        