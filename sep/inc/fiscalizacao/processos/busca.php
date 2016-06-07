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
	//RECEBE OS DADOS DO FORMULARIO
	
	$ordem=$_POST["cmbOrdem"];
	$filtro_p=$_POST["cmbFiltro"];
	$ano=$_POST["cmbAno"];
	$situacao=$_POST["cmbSituacao"];
	$classe=$_POST["cmbClasse"];
	$busca=strip_tags(addslashes($_POST["txtBusca"]));
	
	switch($filtro_p){
		case 'numero':$filtro="processosfiscais.nroprocesso";break;
		case 'nome': $filtro="cadastro.razaosocial";break;
		default: $filtro = $filtro_p;break;
	}
	
	// MONTA O SQL DINAMICAMENTE, COMEÇANDO PELA BUSCA BASICA
	$string="SELECT processosfiscais.nroprocesso, 
             processosfiscais.anoprocesso,
             processosfiscais.situacao,
             cadastro.razaosocial
             FROM processosfiscais
             INNER JOIN cadastro
             ON processosfiscais.codemissor=cadastro.codigo";
	
	// TESTA AS CONDICOES DA BUSCA PARA MONTAR A CLAUSULA WHERE	
	if($classe=="1"){$string.=" WHERE $filtro<='$busca' AND processosfiscais.anoprocesso='$ano'";}
	elseif($classe=="2"){$string.=" WHERE $filtro<'$busca' AND processosfiscais.anoprocesso='$ano'";}
	elseif($classe=="3"){$string.=" WHERE $filtro='$busca' AND processosfiscais.anoprocesso='$ano'";}
	elseif($classe=="4"){$string.=" WHERE $filtro>='$busca' AND processosfiscais.anoprocesso='$ano'";}
	elseif($classe=="5"){$string.=" WHERE $filtro>'$busca' AND processosfiscais.anoprocesso='$ano'";}
	elseif($classe=="6"){$string.=" WHERE $filtro LIKE '%$busca%' AND processosfiscais.anoprocesso LIKE '%$ano%'";}
	
	// TESTA OS PROCESSOS DE QUAL SITACAO SERÁ BUSCADO
	if($situacao!="T"){$string.=" AND processosfiscais.situacao='$situacao'";}
	
	// TESTA AS CONDICOES DE ORDENAMENTO PARA ACRESCENTAR A CLAUSULA WHERE
	if($filtro_p == 'numero'){
		if($ordem=="C"){
			$string.=" ORDER BY processosfiscais.anoprocesso,processosfiscais.nroprocesso ASC";
		}elseif($ordem=="D"){
			$string.=" ORDER BY processosfiscais.anoprocesso DESC,processosfiscais.nroprocesso DESC";
		}
	}else{
		if($ordem=="C"){
			$string.=" ORDER BY $filtro ASC";
		}elseif($ordem=="D"){
			$string.=" ORDER BY $filtro DESC";
		}
	}
	 
	 // EXECUTA NO BANCO DE DADOS A VARIAVEL STRING
	$sql = mysql_query($string);
	
	// ADICIONA EM UMA VARIAVEL O NUMERO DE LINHAS AFETADAS
	$totalproc = mysql_num_rows($sql);
	
	// TESTA AS LINHAS AFETADAS
	if(mysql_num_rows($sql)>0){
	?>	
        <fieldset style="margin-left:7px; margin-right:7px;"><legend>Quantidade de Processos: <?php print $totalproc; ?></legend>
            <form method="post">
            <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
            <input type="hidden" name="txtAcao" value="detalhes" />
                <table width="635">
                    <tr bgcolor='#999999'>
                    	<td width="130" align="center">Nº/Ano</td>
                    	<td width="260" align="center">Nome/Razão</td>
                    	<td width="130" align="center">Situação</td>
                    	<td width="130" align="center">Ações</td>
                    </tr>
                </table>
                <div style="width:650px; height:150px; overflow:auto">	
				<table width="634">
				<?php
                //INICIA UM CONTADOR E ACRESCENTA NO WHILE
					$x=0;
						while(list($nroprocesso, $anoprocesso, $situacao, $razaosocial) = mysql_fetch_array($sql)){
							//TRANSFORMA A SIGLA EM SIGNIFICADO
							switch($situacao){
								case 'A': $situacao = "Aberto"; break;
								case 'C': $situacao = "Concluído"; break;
							}
							print("
									<tr bgcolor='#FFFFFF'>
										<td width=\"130\"  align=center>$nroprocesso/$anoprocesso</td>
										<td width=\"260\" align=center>$razaosocial</td>
										<td width=\"130\" align=center>$situacao</td>
										<td width=\"126\" align=center>
										<input type=\"hidden\" name=\"txtNroProcesso$x\"/>
										<input type=\"hidden\" name=\"txtAnoProcesso$x\"/>
										<input type=\"submit\" name=\"btnDetalhes\" value=\"detalhes\" class=\"botao\" onClick=\"txtNroProcesso$x.value='$nroprocesso'; txtAnoProcesso$x.value='$anoprocesso';\"/></td>
									</tr>
							");
							$x++;  
						}
							echo "<input type=\"hidden\" name=\"contador\" value=\"$x\" />";
                ?>

                </table>
		        </div>            
            </form>
        </fieldset>
        <?php				
        	} //FIM DO IF MYSQL_NUM_ROWS
	else{
    ?>
        <fieldset style="margin-left:7px; margin-right:7px;">
        Nenhum resultado encontrado!
        </fieldset>
    <?php
        } //FIM DO WHILE 
    ?>