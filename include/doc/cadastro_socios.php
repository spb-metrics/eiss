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
 $nrosocios = 10;
 $cont = 1;
 
 while($cont <= $nrosocios) {
 $cont ==1?$style="style=\"display:block\"":$style="style=\"display:none\"";
 $cont==1?$ast="<font color=\"#FF0000\">*</font>":$ast="";

 ?>
<!-- SÓCIO 1 --> 
  <tr id="linha01socio<?php echo $cont; ?>" <?php echo $style;?>>	    	     	
	<td height="0"></td>
  </tr>
  <tr id="campossocio<?php echo $cont; ?>" <?php echo $style;?>>	    
    <td align="left" bgcolor="#999999">&nbsp; 

        <table width="100%">
            <tr align="left">
                <td>Nome</td>
                <td><input type="text" size="40" maxlength="100" name="txtNomeSocio<?php echo $cont; ?>" id="txtNomeSocio<?php echo $cont; ?>" class="texto" /><?php echo $ast;?></td>
            </tr>
            <tr align="left">
                <td>CPF</td>
                <td><input type="text" size="15" maxlength="14" name="txtCpfSocio<?php echo $cont; ?>" id="txtCpfSocio<?php echo $cont; ?>" class="texto" onkeyup="CNPJCPFMsk( this );"/><?php echo $ast;?></td>
            </tr>
            <tr align="left">
                <td>Cargo</td>
                <td>
                    <select name="cmbCargo<?php echo $cont; ?>" id="cmbCargo<?php echo $cont; ?>">
                         <option></option>
                         <?php
                            $sql_cargos = mysql_query("SELECT codigo, cargo FROM cargos WHERE cargo <> 'Diretor'");
                            while($dados = mysql_fetch_array($sql_cargos)){
                                echo "<option value='".$dados['codigo']."'>".$dados['cargo']."</option>";
                            }
                         ?>
                     </select>
                </td>
            </tr>
        </table>       
     <?php
	 if($cont!=1){
	 ?>
	 <input type="button" name="btexcluiSocio<?php echo $cont; ?>" class="botao" value="X" onclick="excluirSocio();"/>
	 <?php
	 }
	 ?>
    </td>
  </tr>
  <tr id="linha02socio<?php echo $cont; ?>" style="display:none">	    	     	
	<td height="0"></td>
  </tr>  
<?php
	$cont++;
}

?>