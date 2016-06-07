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
	include("../../funcoes/util.php");
	include("erros.php");
	libxml_use_internal_errors(true);	
	
	$codverificacao= gera_codverificacao();	 
	$arq = $_FILES["arquivoxml"]['name'];
	$arq_tmp = $_FILES['arquivoxml']['tmp_name'];  				
	$nome_arq= date(dmYhis).rand(0000,9999);	
	$arq = $nome_arq.'.xml';	
	move_uploaded_file($arq_tmp,"/dados/issdigital/xmls/des/".$arq);
		   	   	
	$xml = simplexml_load_file("/dados/issdigital/xmls/des/".$arq);
	if(!$xml){
		Mensagem("O sistema nao conseguiu abrir o arquivo especificado, favor verificar!"); 
		$exc=true;
	} 	
	if($exc){Redireciona("../../principal.php");}
	else{	
		try{		
		  // verifica o nó DADOS do xml.
		  $codemissor=verificaDados($xml->DADOS->CNPJ,$xml->DADOS->COMPETENCIA);	  	
		}catch(Exception $e){		
	    		Mensagem($e->getMessage());
				$exc=true;   		    		
	   	}   	
	    if($exc){Redireciona("../../principal.php");}
	    else{    
		   	//verifica se os servicos estao ok e compatível com o sistema
			foreach($xml->NOTA as $obj)
		    {      	
		    	try{     				
		    		verificaServico($obj->CODSERVICO,$xml->DADOS->CNPJ);    		    		
		    	}catch(Exception $e){
		    		$exc=true;
		    		Mensagem($e->getMessage());			    		
		    	}    	    	
		    }
		    if($exc){Redireciona("../../principal.php");}
		    else{    
			    // NESTE PONTO O XML ESTA POSITIVO E OPERANTE.			    
				    $codver=gera_codverificacao();    
				    mysql_query("INSERT INTO des 
				    			 SET codcadastro='$codemissor',competencia='{$xml->DADOS->COMPETENCIA}',data_gerado=NOW(),
				    			 total='',iss='',tomador='s',codverificacao='$codver',estado='N'");
				    
				    $sqldes=mysql_query("SELECT MAX(codigo) as cod_des FROM des");    
				    $result = mysql_fetch_object($sqldes);    
				    $codDes = $result->cod_des;
				    
				    foreach($xml->NOTA as $obj)
				    {
				    	$codServ= pegaServico($obj->CODSERVICO);
				    	mysql_query("INSERT INTO des_servicos SET coddes='$codDes',codservico='$codServ',
				    				 basedecalculo='{$obj->BASECALCULO}',tomador_cnpjcpf='{$obj->CNPJCPFTOMADOR}',
				    				 nota_nro='{$obj->NUMERONOTA}'");    	
				    }
				    
				    $total=somaTotal($codDes);
				    $iss=somaIss($codDes);        
				    mysql_query("UPDATE des SET total='$total',iss='$iss' WHERE codigo='$codDes'");
				    Mensagem("Declaração concluida com sucesso !");
					Redireciona("../../principal.php");
		    }
	    }
	}		
   	    
    
?>