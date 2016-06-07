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
/* Não gravar em cache */
include 'nocache.php';

require_once("conect.php");
require_once("../funcoes/util.php"); 

if(isset($_GET['codigo'])){
	$cod = addslashes($_GET['codigo']);
	$motivo = addslashes($_GET['motivo']);
	$tabela = addslashes($_GET['tabela']);
	$tipo   = addslashes($_GET['tipo']);
	
	switch($tipo){
		case 'dif_des'      : $relacionamento = 'codinst_financeira'; break;
		case 'doc_des'      : $relacionamento = 'codopr_credito';     break;
		case 'decc_des'     : $relacionamento = 'codempreiteira';     break; 
		case 'dop_des'      : $relacionamento = 'codorgaopublico';   break;
		case 'cartorio_des' : $relacionamento = 'codcartorio';        break;
	}
	
	mysql_query("
		UPDATE 
			$tabela
		SET 
			estado = 'C',
			motivo_cancelamento = '$motivo'
		WHERE 
			codigo = '$cod'
	");
	
	if($tabela =="guia_pagamento"){
		//include("conecta.pg.php");	
			
		$sql = mysql_query("
			SELECT 
				cadastro.codigo,
				gp.motivo_cancelamento 
			FROM 
				cadastro
		 	INNER JOIN 
				$tipo ON $tipo.$relacionamento = cadastro.codigo 
		 	INNER JOIN 
				guias_declaracoes ON guias_declaracoes.codrelacionamento = $tipo.codigo
		  	INNER JOIN 
				guia_pagamento as gp ON guias_declaracoes.codguia = gp.codigo
		  	WHERE 
				guias_declaracoes.codguia = '$cod' AND guias_declaracoes.relacionamento = '$tipo' 
			GROUP BY 
				gp.codigo
		");
		list($codcad,$motivo)=mysql_fetch_array($sql);
		
		/*$sql = pg_query("SELECT numcad FROM smabas02 WHERE coduni = '$codcad' ORDER BY numcad LIMIT 1");
		
		list($numcad) = pg_fetch_array($sql);		
		
		
		$sql = pg_query("SELECT MAX(numero_historico) FROM smahisfi WHERE numero_cadastro = '$numcad'");
		list($numhist) = pg_fetch_array($sql);
		$numhist = $numhist +1;
		$data = date("A-m-d");*/
		
		$sql = mysql_query("SELECT gd.codrelacionamento FROM guias_declaracoes as gd INNER JOIN $tipo ON gd.codrelacionamento = $tipo.codigo WHERE gd.codguia = '$cod' ");
		while(list($CodDes) = mysql_fetch_array($sql)){		
			mysql_query("UPDATE $tipo SET estado = 'N' WHERE codigo = '$CodDes'");
		}
		
		
		
		
		/*pg_query("
			INSERT INTO 
				smahisfi(codigo_cadastro,numero_cadastro,numero_historico,codigo_unico,historico)
			VALUES
				(2,'$numcad','$numhist',$codcad,'$motivo   conhecimento nro $cod  - PORTAL ')
		");
		//CANCELAMENTO CONHECIMENTO NRO X - PORTAL	 
		
		geraLog("smahisfi","Cancelou guia!"); //Grava o log do cancelamento de guia no banco do postgre
		*/
	}
	echo "cancelada";
}
?>