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

//trata as letras acentuadas para nao causar erros, 
//serve se tiver comparacao de strings com acentuacao,
//assim reduz muita a chance de dar erros,
//e isso esta aki no util porque tem que estar em todas as paginas
setlocale(LC_CTYPE, 'pt_BR');

//para chamar o nome do campo da tabela cadastro que pode ser cnpj ou cpf
//$rel serve para dezer se tem inner join na query
function sqlCpfCnpj($rel){
	if($rel=='s'){	
		return "if(cadastro.cnpj <>'', cadastro.cnpj , cadastro.cpf) as cnpjcpf";
	}else{
		return "if(cnpj <>'',cnpj,cpf) as cnpjcpf";
	}	
}

// escapa as aspas e apostrofes e retira todas as tags html
function trataString($texto){
    return trim(addslashes(strip_tags($texto)));
}

// verifica se e cpf ou se e cnpj
function tipoPessoa($cnpjcpf){
    if(strlen($cnpjcpf)==14){
        $campo="cpf";
    }elseif(strlen($cnpjcpf)==18){
        $campo="cnpj";
    }
    return $campo;
}

// Alert
function Mensagem($texto){
	echo "\n<script type=\"text/javascript\">
			alert('$texto');
		  </script>\n";
}
//Parent.Location  
function Redireciona($url){
	echo "\n<script type=\"text/javascript\">
			parent.location='$url';
		  </script>\n";
}

//Parent.close
function FecharJanela(){
	echo "\n<script type=\"text/javascript\">
			parent.close();
		  </script>\n";
}

function NovaJanela($url){
	echo "\n<script type=\"text/javascript\">
			window.open('$url');
		  </script>\n";
}
  
function campoHidden($nome,$valor){
	echo "<input type=\"hidden\" name=\"$nome\" id=\"$nome\" value=\"$valor\">\n";
}

//Entra no formato DD/MM/AAAA e sai AAAA-MM-DD
function DataMysql($data){
	return implode('-',array_reverse(explode('/',$data)));
}
  

//Entra no formato AAAA-MM-DD  e sai DD/MM/AAAA  
function DataPt($data){
	return implode('/',array_reverse(explode('-',$data)));
}

function DataVencimento() {
	$dias_prazo = 5;
	return date("Y-m-d", time() + ($dias_prazo * 86400));
}

// funcao pra converter de moeda pra decimal
function MoedaToDec($valor){
	$valor = str_replace(".","",$valor);
	$valor = str_replace(",","",$valor);
	$valor = $valor/100;
	return $valor;
}

function DecToMoeda($valor){
	return number_format($valor, 2, ',', '.');
}

function imprimirGuia($codguia,$pasta=NULL,$mesmajanela=NULL){
	if($pasta === true){
		$pasta = '../';
	}
	$codguia=base64_encode($codguia);
	$sql_tipo_boleto=mysql_query("SELECT tipo FROM boleto");
	$result=mysql_fetch_object($sql_tipo_boleto);
	if($mesmajanela==true){
		if($result->tipo =="R"){
		
			echo "<script>window.location = ('{$pasta}boleto/recebimento/index.php?COD=$codguia')</script>";	
		}else{
			echo "<script>window.location = ('{$pasta}boleto/pagamento/$boleto?COD=$codguia')</script>";
		}
		exit;
	}else{
		if($result->tipo =="R"){
			echo "<script>window.open('{$pasta}boleto/recebimento/index.php?COD=$codguia')</script>";	
		}else{
			echo "<script>window.open('{$pasta}boleto/pagamento/$boleto?COD=$codguia')</script>";
		}
	}
}

//gera nossonumero de acordo com o banco da prefeitura
function gerar_nossonumero($codigo){
	$sql_boleto = mysql_query("SELECT codbanco, IF(convenio <> '', convenio, codfebraban) FROM boleto");
	list($codbanco,$convenio)=mysql_fetch_array($sql_boleto);
	$vencimento = DataVencimento();
	$vencimento = DataMysql($vencimento);
	$vencimento = str_replace("-","","$vencimento");
	
	
		$numero = $codigo;
		while(strlen($numero)< 13)
			$numero = 0 . $numero;
		$nossonumero = $vencimento.$convenio.$numero;
	
	return $nossonumero;
}

//gera chavecontroledoc
function gerar_chavecontrole($cod_des,$cod_guia){
	$chavenum = rand(10,99);
	$cod_des_guia = $cod_des;
	while(strlen($cod_des_guia)< 4)
		$cod_des_guia = 0 . $cod_des_guia;
	$cod_doc = $cod_guia;
	while(strlen($cod_doc)< 4)
		$cod_doc = 0 . $cod_doc;
	$chavecontroledoc = $chavenum.$cod_des_guia.$cod_doc; 
	return $chavecontroledoc;
}

function diasDecorridos($dataInicio,$dataFim){
	//define data inicio
	$dataInicio = explode("/",$dataInicio);
	$ano1 = $dataInicio[2];
	$mes1 = $dataInicio[1];
	$dia1 = $dataInicio[0];
	
	//define data fim
	$dataFim = explode("/",$dataFim);
	$ano2 = $dataFim[2];
	$mes2 = $dataFim[1];
	$dia2 = $dataFim[0];
	
	//calcula timestam das duas datas
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);
	
	//diminue a uma data a outra
	$segundos_diferenca = $timestamp2 - $timestamp1;
	//echo $segundos_diferenca;
	
	//converte segundos em dias
	$dias_diferenca = $segundos_diferenca / (60 * 60 * 24);
	
	//tira os decimais aos dias de diferenca
	$dias_diferenca = floor($dias_diferenca);
	
	return $dias_diferenca; 
}

//GERA O CÓDIGO DE VERIFICAÇÃO
function gera_codverificacao(){
	$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';
	$max = strlen($CaracteresAceitos)-1;
	$codverificacao = null;
	for($i=0; $i < 8; $i++) {
		$codverificacao .= $CaracteresAceitos{mt_rand(0, $max)}; 
		$carac = strlen($codverificacao); 
		if($carac ==4)
			$codverificacao .= "-";
	}
	return $codverificacao;
}

function calculaMultaDes($diasDec,$valor){
	$sql_multas = mysql_query(" SELECT codigo, dias, multa, juros_mora
							FROM des_multas_atraso 
							WHERE estado='A'
							ORDER BY dias ASC");
	$nroMultas = mysql_num_rows($sql_multas);
	$n = 0;
	while(list($multa_cod, $multa_dias, $multa_valor, $multa_juros) = mysql_fetch_array($sql_multas)){
		$multadias[$n] = $multa_dias;
		$multavalor[$n] = $multa_valor;
		$multajuros[$n] = $multa_juros;
		$n++;
	}
	if($diasDec>0)
		$multa = 0;
	else
		$multa = -1;
		
	for($c=0;$c < $nroMultas; $c++){
		if($diasDec>$multadias[$c]){
			$multa = $c;	
			if($multa<$nroMultas-1)
				$multa++;
		}//end if
	}//end for

	if($multa>=0){
		$jurosvalor = $valor*($multajuros[$multa]/100);
		$multatotal = $jurosvalor + $multavalor[$multa];
		$totalpagar = $multatotal + $valor;
		return $multatotal;
	}
	else{
		return "";
	}
}

function listaRegrasMultaDes(){
	//pega o dia pra tributacao do mes da tabela configucacoes
	$sql_data_trib = mysql_query("SELECT data_tributacao FROM configuracoes");
	
	list($dia_mes)=mysql_fetch_array($sql_data_trib);
	campoHidden("hdDia",$dia_mes);
	//echo "<input type=\"hidden\" name=\"hdDia\" id=\"hdDia\" value=\"$dia_mes\" />";
	
	$dataatual = date("d/m/Y");
	campoHidden("hdDataAtual",$dataatual);
	//echo "<input type=\"hidden\" name=\"hdDataAtual\" id=\"hdDataAtual\" value=\"$dataatual\" />\n";
	//pega a regra de multas do banco
	$sql_multas = mysql_query(" SELECT codigo, dias, multa, juros_mora
								FROM des_multas_atraso 
								WHERE estado='A'
								ORDER BY dias ASC");
	$nroMultas = mysql_num_rows($sql_multas);
	echo "<input type=\"hidden\" name=\"hdnroMultas\" id=\"hdNroMultas\" value=\"$nroMultas\" />\n";
	$n = 0;
	while(list($multa_cod, $multa_dias, $multa_valor, $multa_juros) = mysql_fetch_array($sql_multas)){
		campoHidden("hdMulta_dias$n",$multa_dias);
		campoHidden("hdMulta_valor$n",$multa_valor);
		campoHidden("hdMulta_juros$n",$multa_juros);
		$n++;
	}
}

function DataPtExt(){
	$s = date("D");   //pega dia da semana em ingles
	$dia = date("d"); //pega dia do mes
	$m = date("n");   //pega o mes em numero
	$ano = date("Y"); //pega o ano atual
	$semana = array("Sun" => "Domingo", "Mon" => "Segunda-feira", "Tue" => "Terça-feira", "Wed" => "Quarta-feira", "Thu" => "Quinta-feira", "Fri" => "Sexta-feira", "Sat" => "Sábado"); 
	/* Dias da Semana.  troca o valor da semana em ingles para portugues*/
	$mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
	/* Meses troca o valor de numero pelo seu valor por extenso*/
	return $semana[$s].", ".$dia." de ".$mes[$m]." de ".$ano; //imprime na tela a data concatenada por extenso  
}//by lucas.

/**
 * igual ao print_r mas com identacao em html
 * @author jean
 */
function print_array($array){
	echo '<div align="left"><font color="#000000"><pre>';
	print_r($array);
	echo '</pre></font></div>';
}//fim print array

/**
 * retorna o codigo do cargo solicitado
 * @author jean
 */
function codcargo($cargo){
	$sql_cargo = mysql_query("SELECT codigo FROM cargos WHERE cargo LIKE '$cargo'");
	if(!$sql_cargo){
		return;
	}
	return mysql_result($sql_cargo,0);
}//pega o codigo do cargo solicitado de acordo com o banco

/**
 * retorna o codigo do tipo de prestador solicitado
 * @author jean
 */
function codtipo($tipo){
	$sql_tipo = mysql_query("SELECT codigo FROM tipo WHERE tipo LIKE '$tipo'");
	if(!$sql_tipo){
		return;
	}
	return mysql_result($sql_tipo,0);
}//pega o codigo do tipo solicitado de acordo com o banco

/**
 * retorna o codigo do tipo de declaracao solicitado
 * @author jean
 */
function coddeclaracao($dec){
	$sql_coddec = mysql_query("SELECT codigo FROM declaracoes WHERE declaracao LIKE '$dec'");
	if(!$sql_coddec){
		return;
	}
	return mysql_result($sql_coddec,0);
}//pega o codigo da declaracao solicitada de acordo com o banco




function Paginacao($query,$form,$retorno,$quant=NULL,$test=false){// $test serve para os botoes
	if($_GET["hdPagina"]&&$_GET["hdPrimeiro"]){
		$pagina = $_GET["hdPagina"];
	}else{
		$pagina = 1;
	}
	
	//testa se a variavel de quantidade por pagina estiver vazia ela recebera o valor de 10
	if(!isset($quant)){
		$quant = 10;
	}
	
	//Executa o sql que foi enviado por parametro para que se possa fazer os calculos de paginas e quantidade
	$sql_pesquisa = mysql_query("$query");
	

	//Verifica se há erros de sintaxe
	if(!$sql_pesquisa){ 
		return $sql_pesquisa;
	}
	
	$quantporpagina = $quant;	                        //Define o limite de resultados por pagina
	$total_sql      = mysql_num_rows($sql_pesquisa);    //Recebe o total de resultados gerados pelo sql
	$total_paginas  = ceil($total_sql/$quantporpagina); //Usa o total para calcular quantas paginas de resultado tera a pesquisa sql
	
	//Verifica se não tem a variavel pagina, ou se ela é menor que o total ou se ela é menor que 1
	if((!isset($pagina)) || ($pagina > $total_paginas) || ($pagina < 1)){
		$pagina = 1;
	}
	
	$pagina_sql = ($pagina-1)*$quantporpagina;          //Calcula a variavel que vai ter o incio do limit
	$pagina_sql .= ",$quantporpagina";                  //Concatena a quantidade de paginas escolhida com o inicio do limit do sql
	
	//Sql buscando as informações e o limit estipulado pela função
	$sql_pesquisa = mysql_query("$query LIMIT $pagina_sql");
	if(!$sql_pesquisa){ 
		return $sql_pesquisa;
	}
	
	//Aqui identifica em qual arquivo está localizado para que o ajax possa voltar para o mesmo
	$arquivo = $_SERVER['PHP_SELF'];
	
	//Monta a table com os botoes onde chamou a função
	if(mysql_num_rows($sql_pesquisa)>0){
		$botoes= "
		<table width=\"100%\">
			<tr>
				<td align=\"center\">
					<b>";if($total_sql == 1){ $botoes.= "1 Resultado";}else{ $botoes.= "$total_sql Resultados";} $botoes.= ", p&aacute;gina: $pagina de $total_paginas</b>
					<input type=\"button\" name=\"btAnterior\" value=\"Anterior\" class=\"botao\" 
					onclick=\"document.getElementById('hdPrimeiro').value=1;
					mudarpagina('a','hdPagina','$arquivo','$form','$retorno');\" "; if($pagina == 1){ $botoes.= "disabled = disabled";} $botoes.= " />
					<input type=\"button\" name=\"btProximo\" value=\"Pr&oacute;ximo\" class=\"botao\" 
					onclick=\"document.getElementById('hdPrimeiro').value=1;
					mudarpagina('p','hdPagina','$arquivo','$form','$retorno');\" "; if($pagina == $total_paginas){ $botoes.= "disabled = disabled";} $botoes.= " />
					<input type=\"hidden\" name=\"hdPagina\" id=\"hdPagina\" value=\"$pagina\" />
					<input type=\"hidden\" name=\"hdPrimeiro\" id=\"hdPrimeiro\" />
				</td>
			 </tr>
		</table>";
	}//fim if se existe resultado
	
	if($test==false){//test para botar os botoes direto com echo ou passar para uma array com o return
		echo $botoes;
		return $sql_pesquisa;
	}else{
		$return['sql']=$sql_pesquisa;
		$return['botoes']=$botoes;
		return $return;
	}
		
		
}//fim function Paginacao()

function verificaCampo($campo){
	if($campo == ""){$campo = "N&atilde;o Informado";}
return $campo;
}//verifica o resultado do banco se esta vazio, se estiver, acrescenta informação

//redireciona para o link indicado sem os parametros de get adicionais
//e criando um form com hiddens baseado nos parametros de get
function RedirecionaPost($url,$target=NULL){
	if($target==NULL)$target="_parent";
	$url_full=explode("?",$url,2);
	$action=$url_full[0];
	$post_vars=explode("&",$url_full[1]);
	$redir="<form name='redirPost' id='redirPost' action='$action' method='post' target='$target'>";
	foreach($post_vars as $var){
		list($var_name,$var_value)=explode("=",$var,2);
		$redir.="<input type='hidden' name='$var_name' value='$var_value' />";
	}
	$redir.="</form>";
	$redir.="<script>document.getElementById('redirPost').submit();</script>";
	echo $redir;
}//fim function RedirecionaPost()

//Função que retorna o nome do estado por extenso
function estadoExtenso($sigla) {
 	$estados = array(
		'AC' => 'do Acre',
		'AL' => 'do Alagoas',
		'AP' => 'do Amapá',
		'AM' => 'do Amazonas',
		'BA' => 'da Bahia',
		'CE' => 'do Ceará',
		'DF' => 'do Distrito Federal',
		'ES' => 'do Espírito Santo',
		'GO' => 'de Goiás',
		'MA' => 'do Maranhão',
		'MG' => 'de Minas Gerais',
		'MT' => 'do Mato Grosso',
		'MS' => 'do Mato Grosso do Sul',
		'PA' => 'do Pará',
		'PR' => 'do Paraná',
		'PE' => 'de Penambuco',
		'PI' => 'do Piauí',
		'RJ' => 'do Rio de Janeiro',
		'RN' => 'do Rio Grande do Norte',
		'RS' => 'do Rio Grande do Sul',
		'RO' => 'de Rondônia',
		'RR' => 'de Roraima',
		'SC' => 'de Santa Catarina',
		'SP' => 'de São Paulo',
		'SE' => 'do Sergipe',
		'TO' => 'do Tocantins'
	);
	return $estados[$sigla];
}

//Funcão que retorna somente o mês 
 function mesExtenso($mesxt) {
 	$mes = array(
		'01' => 'Janeiro',
		'02' => 'Fevereiro',
		'03' => 'Março',
		'04' => 'Abril',
		'05' =>	'Maio',
		'06' =>	'Junho',
		'07' =>	'Julho',
		'08' =>	'Agosto',
		'09' =>	'Setembro',
		'10' =>	'Outubro',
		'11' =>	'Novembro',
		'12' =>	'Dezembro'
	);
 	return $mes[$mesxt];
 }

function situacoes ($situ){
	$sit = array(
	'A' => 'Aberto',
	'C' =>'Concluído',
	);
	return $sit[$situ];
}

/**
*Funcao adcionaDias
*Parametros:
*$data = a data de origem, que sera acrescentado o valor de dias
*$dias = a quantidade de dias que serao acrescentados a data informada
*Esta funcao recebe a data e acrescenta o numero de dias 
*que for passado por parametro, usando a funcao mktime para somar os dias
*retornando uma nova data no padrao ano/mes/dia
*/
function adcionaDias($data,$dias) {
	$ano = substr ( $data, 0, 4 );
	$mes = substr ( $data, 4, 2 );
	$dia =  substr ( $data, 6, 2 );
	$novaData = mktime ( 0, 0, 0, $mes, $dia + $dias, $ano );
	return strftime("%Y%m%d", $novaData);
}

/**
*Funcao subtraiDias
*Parametros:
*$data = a data de origem, que sera subtraido o valor de dias
*$dias = a quantidade de dias que serao subtraidos da data informada
*Esta funcao recebe a data e subtrai o numero de dias 
*que for passado por parametro, usando a funcao mktime para subtrair os dias
*retornando uma nova data no padrao ano/mes/dia
*/
function subtraiDias($data,$dias) {
	$ano = substr ( $data, 0, 4 );
	$mes = substr ( $data, 4, 2 );
	$dia =  substr ( $data, 6, 2 );
	$novaData = mktime ( 0, 0, 0, $mes, $dia - $dias, $ano );
	return strftime("%Y%m%d", $novaData);
}

/**
*funcao UltDiaUtil
*@param $mes = mes no formato de numero
*@param $ano = o numero do ano atual ou o que for desejado
*@return Ultimo dia util do mes subsequente e ano informados
*/
function UltDiaUtil($mes,$ano){
  	//$mes = date("m");
  	//$ano = date("Y");
	$mes = $mes + 1;
	while($mes > 12){
		$mes -= 12;
		$ano = $ano + 1;
	}
  	$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  	$ultimo = mktime(0, 0, 0, $mes, $dias, $ano); 
  	$dia = date("j", $ultimo);
  	$dia_semana = date("w", $ultimo);
  
  	// domingo = 0;
  	// sÃ¡bado = 6;
  	// verifica sÃ¡bado e domingo
  
  	if($dia_semana == 0){
    	$dia--;
		$dia--;
  	}
  	if($dia_semana == 6){
    	$dia--;
	}
  	
	$ultimo = mktime(0, 0, 0, $mes, $dia, $ano);

	/*
	switch($dia_semana){  
		case"0": $dia_semana = "Domingo";       break;  
		case"1": $dia_semana = "Segunda-Feira"; break;  
		case"2": $dia_semana = "TerÃ§a-Feira";   break;  
		case"3": $dia_semana = "Quarta-Feira";  break;  
		case"4": $dia_semana = "Quinta-Feira";  break;  
		case"5": $dia_semana = "Sexta-Feira";   break;  
		case"6": $dia_semana = "SÃ¡bado";        break;  
	}
	*/

  return date("Y-m-d", $ultimo);
}

?>