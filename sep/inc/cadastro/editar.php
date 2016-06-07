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
<form  method="post" name="frmCadastro" id="frmCadastro">
		  <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		  <input type="hidden" name="CODEMISSOR" id="CODEMISSOR" value="<?php echo  $_POST['CODEMISSOR'];?>" />
 </form>
 
<?php 
//pega as variaveis que vieram do formulario
$nomeempresa= $_POST['txtInsNomeEmpresa'];
$razaosocial= $_POST['txtInsRazaoSocial'];
$cnpjcpfempresa= $_POST['txtInsCpfCnpjEmpresa'];
$enderecoempresa= $_POST['txtInsEnderecoEmpresa'];
$inscrmunicipal= $_POST['txtInsInscMunicipalEmpresa'];
$municipio= $_POST['txtInsMunicipioEmpresa'];
$uf= $_POST['txtInsUfEmpresa'];
$nfe=$_POST['txtNfe'];
if(!$nfe){$nfe='n';}
$emailempresa= $_POST['txtInsEmailEmpresa'];
$codigoempresa = $_POST['CODEMISSOR'];
$estado = $_POST['rgEstado'];
$simplesnacional = $_POST['txtSimplesNacional'];
if ($simplesnacional == "")
{
  $simplesnacional = "N";
}
//variaveis contadoras para servico

$contservicos = 0;
$numservicos = 5;

//variaveis contadoras para socios
$contsocios = 0;
$numsocios = 10;
//vetores para editar servicos
$vetor_editar_servicos = array($cmbEditaServico1,$cmbEditaServico2,$cmbEditaServico3,$cmbEditaServico4,$cmbEditaServico5);

$vetor_cod_servico= array($servico1,$servico2,$servico3,$servico4,$servico5);

$vetor_exluir_servicos = array($checkExcluiServico1,$checkExcluiServico2,$checkExcluiServico3,$checkExcluiServico4,$checkExcluiServico5);



//vetores para adicionar servicos
 $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias");
 
 $contpos=0;
 while(list($codcategoria)=mysql_fetch_array($sql_categoria))
 {   
   $conts=1;
   for($conts=1;$conts<=5;$conts++)
   {    
		$vetor_insere_servico[$contpos]=$_POST['cmbCodigo'.$codcategoria.$conts];
		$contpos++;	
   }		
 }	
 





//vetores para editar sócio
$vetor_sociosnomes = array($txtnomesocio1,$txtnomesocio2,$txtnomesocio3,$txtnomesocio4,$txtnomesocio5,$txtnomesocio6,$txtnomesocio7,$txtnomesocio8,$txtnomesocio9,$txtnomesocio10);

$vetor_socioscpf = array($txtcpfsocio1,$txtcpfsocio2,$txtcpfsocio3,$txtcpfsocio4,$txtcpfsocio5,$txtcpfsocio6,$txtcpfsocio7,$txtcpfsocio8,$txtcpfsocio9,$txtcpfsocio10);

$vetor_codigo_socios= array($txtCodigoSocio1,$txtCodigoSocio2,$txtCodigoSocio3,$txtCodigoSocio4,$txtCodigoSocio5,$txtCodigoSocio6,$txtCodigoSocio7,$txtCodigoSocio8,$txtCodigoSocio9,$txtCodigoSocio10);

$vetor_excluir_socios = array($checkExcluiSocio1,$checkExcluiSocio2,$checkExcluiSocio3,$checkExcluiSocio4,$checkExcluiSocio5,
$checkExcluiSocio6,$checkExcluiSocio7,$checkExcluiSocio8,$checkExcluiSocio9,$checkExcluiSocio10);




//vetores para inserir sócio

$vetor_nome_socios = array($txtNomeSocio1,$txtNomeSocio2,$txtNomeSocio3,$txtNomeSocio4,$txtNomeSocio5,$txtNomeSocio6,
$txtNomeSocio7,$txtNomeSocio8,$txtNomeSocio9,$txtNomeSocio10);

$vetor_cpf_socios = array($txtCpfSocio1,$txtCpfSocio2,$txtCpfSocio3,$txtCpfSocio4,$txtCpfSocio5,$txtCpfSocio6,$txtCpfSocio7,
$txtCpfSocio8,$txtCpfSocio9,$txtCpfSocio10);

//lista os dados da empresa-------------------------------------------------------------------------------------------------------
$sql_dados_empresa=mysql_query("SELECT nome,razaosocial,cnpjcpf,inscrmunicipal,email,endereco,estado,simplesnacional FROM emissores
 WHERE codigo = '$codigoempresa'");
list($Nempresa,$Rempresa,$CNCPempresa,$Iempresa,$EMempresa,$ENempresa,$OPestado,$SPempresa)=mysql_fetch_array($sql_dados_empresa); 


//Atualiza dados da Empresa---------------------------------------------------------------------------------------------------------
if(($nomeempresa != $Nempresa) ||($razaosocial != $Rempresa)|| ($cnpjcpfempresa != $CNCPempresa) || ($enderecoempresa != $ENempresa) ||($incmunicipal != $Iempresa) || ($emailempresa != $EMempresa) || ($estado != $OPestado) || ($simplesnacional != $SPempresa))
 {   
  
   $sql=mysql_query("
   UPDATE usuarios SET nome = '$nomeempresa',login = '$cnpjcpfempresa'
   WHERE nome = '$Nempresa'");    
   
   $sql=mysql_query("
   UPDATE emissores SET nome = '$nomeempresa', razaosocial = '$razaosocial', cnpjcpf = '$cnpjcpfempresa',
   inscrmunicipal = '$inscrmunicipal', email= '$emailempresa',endereco= '$enderecoempresa', estado = '$estado', simplesnacional = '$simplesnacional',uf='$uf',
   municipio='$municipio',nfe='$nfe'
   
   
   WHERE codigo = '$codigoempresa'");  
   add_logs('Atualizou dados da empresa'); 
   
   print "<script language=JavaScript>alert('Empresa atualizada com sucesso');document.getElementById('frmCadastro').submit();</script>";
   
   
 } 



//edita servicos--------------------------------------------------------------------------------------------------------------------
  $sql_seleciona_servicos=mysql_query("SELECT codservico FROM emissores_servicos WHERE codigo = '$vetor_cod_servico[$contservicos]'");  

  while($contservicos < $contpos) 
        {  		
		      
		      $sql_seleciona_servicos=mysql_query("SELECT codservico FROM emissores_servicos WHERE codigo = '$vetor_cod_servico[$contservicos]'"); 
			  
			  list($codigo_servico)=mysql_fetch_array($sql_seleciona_servicos);
			  
			  if($vetor_editar_servicos[$contservicos] != $codigo_servico)
			   { 				  			
				$sql=mysql_query("UPDATE emissores_servicos SET codservico = '$vetor_editar_servicos[$contservicos]'
				WHERE codigo = '$vetor_cod_servico[$contservicos]'"); 
				$a="teste"; 
				add_logs('Atualizou servico da empresa');
				
               }
		     
			   if($vetor_exluir_servicos[$contservicos] != "")
			   {
			     $sql_deleta_servico=mysql_query("DELETE FROM emissores_servicos WHERE codigo = '$vetor_cod_servico[$contservicos]'");	
				  add_logs('Excluiu servico da empresa');	
	           }
			   
			  if($vetor_insere_servico[$contservicos] != "")
			   { 				  			
				$sql=mysql_query("INSERT INTO emissores_servicos SET codservico= '$vetor_insere_servico[$contservicos]',
				codemissor= '$codigoempresa'");	
				add_logs('Inseriu servico na empresa');			
               }
			   
		 $contservicos++;	 
	    }		
		
		
		
//edita socios------------------------------------------------------------------------------------------------------------------- 
  while($contsocios < $numsocios) 
        {  	  
		
		      $sql_seleciona_servicos=mysql_query("SELECT nome, cpf FROM emissores_socios 
			  WHERE codigo = '$vetor_codigo_socios[$contsocios]'");
			  
			  list($nome_socios, $CPF_socios)=mysql_fetch_array($sql_seleciona_servicos);
			  
			  		 
			  if(($vetor_sociosnomes[$contsocios] != $nome_socios)&&($vetor_sociosnomes[$contsocios] != ""))
			   { 	 			   		  			
				$sql=mysql_query("UPDATE emissores_socios SET nome = '$vetor_sociosnomes[$contsocios]',
				cpf = '$vetor_socioscpf[$contsocios]'
				WHERE codigo = '$vetor_codigo_socios[$contsocios]'");	
				add_logs('Atualizou socio da empresa');			   				 
               }
			   
			    if(($vetor_socioscpf[$contsocios] != $CPF_socios)&&($vetor_socioscpf[$contsocios] != ""))
			   { 	 			   		  			
				$sql=mysql_query("UPDATE emissores_socios SET nome = '$vetor_sociosnomes[$contsocios]',
				cpf = '$vetor_socioscpf[$contsocios]'
				WHERE codigo = '$vetor_codigo_socios[$contsocios]'");	
				add_logs('Atualizou socio da empresa');			   				 
               }
			   
			   if($vetor_excluir_socios[$contsocios] != "")
			   {			    
			    $sql_deleta_socios=mysql_query("DELETE FROM emissores_socios WHERE codigo ='$vetor_excluir_socios[$contsocios]'");
				add_logs('Excluiu socio da empresa');   
			   } 
	 
			  if($vetor_nome_socios[$contsocios] != "")
			   { 				  			
				$sql=mysql_query("INSERT INTO emissores_socios SET nome='$vetor_nome_socios[$contsocios]',
				cpf = '$vetor_cpf_socios[$contsocios]',codemissor= '$codigoempresa'");
				add_logs('Inseriu sócio na empresa');				
               }
			   
		 $contsocios++;	 
	  
	    }				
		
		
		
				 
?>