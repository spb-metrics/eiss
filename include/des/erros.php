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
		
	function verificaDados($cnpj,$comp){
		
		if($comp){
			
			$trano=substr($comp,4,1);
			$trmes=substr($comp,7,1);
			
			if(($trano !="-")||($trmes!="-")){
				throw new Exception("Formato inválido da competência. AAAA-MM-DD");	
			}		
		}else{
			throw new Exception("A competência da declaração nao foi encontrada no arquivo.");			
		}
		
		
		$sql_emp=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='$cnpj' OR cpf='$cnpj'");
		if(mysql_num_rows($sql_emp)==0){
			throw new Exception("Cnpj do Emissor Inválido $cnpj, favor verificar arquivo!");
		}else{
			$result=mysql_fetch_object($sql_emp);
			return $result->codigo;	
		}
	}
		
	function verificaServico($cod,$cnpj){		
			
			$sql_serv= mysql_query("SELECT codigo,codservico FROM servicos WHERE codservico = '$cod'");
			if(mysql_num_rows($sql_serv)==0){
				throw new Exception("Codigo do serviço inválido $cod, favor verificar arquivo!");
			}else{			
			  $result=mysql_fetch_object($sql_serv);		  
			  $sql_serv_emp=mysql_query("
			  SELECT * FROM cadastro_servicos 
			  INNER JOIN cadastro
			  ON cadastro_servicos.codemissor=cadastro.codigo
			  WHERE cadastro_servicos.codservico={$result->codigo}
			  AND cadastro.cnpj='$cnpj' OR cadastro.cpf='$cnpj'");
			    
			  if(mysql_num_rows($sql_serv_emp)==0){
			  	throw new Exception("A empresa não presta o serviço do codigo $cod, favor verificar arquivo!");
			  }	
			}		
	}	
	
	function somaTotal($cod){		
		$soma=mysql_query("SELECT SUM(basedecalculo)as vltotal FROM des_servicos WHERE coddes='$cod'");
		$result=mysql_fetch_object($soma);
		return $result->vltotal;		
	}
	
	function somaIss($cod){		
		$soma=mysql_query("
					SELECT SUM((servicos.aliquota /100)*(des_servicos.basedecalculo)) as iss FROM des_servicos
					INNER JOIN servicos ON  des_servicos.codservico=servicos.codigo
					WHERE des_servicos.coddes='$cod'");
		$result=mysql_fetch_object($soma);
		return $result->iss;
	}
	function pegaServico($cod)
	{
		$sql=mysql_query("SELECT codigo FROM servicos WHERE codservico='$cod'");
		$result=mysql_fetch_object($sql);
		return $result->codigo;  		
	}
	
?>	
	
	
	