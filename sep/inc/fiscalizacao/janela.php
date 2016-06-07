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
<head>
<style>
/*serve para criar janelas no html*/
.Janela {
	border: solid 1px #000000;
	background: #6699cc;
	-moz-box-shadow: 5px 5px 30px #000000;
	-webkit-box-shadow: 2px 2px 15px #000000;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	position:absolute;
}
.Janela .JanelaDentro {
	padding: 4px;
	border: solid 1px #eeeeee;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
.Janela h1 {
	margin: 0;
	font: bold 15px Calibri, Arial;
	color: #ffffff;
}
.Janela .ConteudoFora {
	border: solid 1px #eeeeee;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
}
.Janela .Conteudo {
	padding: 5px;
	border: solid 1px #003366;
	background: #ffffff;
	font: 11px Verdana;
	color: #333333;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
}
.Janela .Botoes {
	margin-top: 10px;
	text-align: center;
}
#btClose{
	cursor:default;
}
</style>
<title>Sistema</title></head>
<script language="javascript">
function btClose_click(){
	var janela=document.getElementById('janela');
	janela.style.display='none';
}

</script>
<body bgcolor="#CCCCCC" id="body">
    <div class="Janela" id="janela" style="width:auto; ">
        <div class="JanelaDentro" id="JanelaDentro">
			<table width="100%">
				<tr>
					<td align="left" id="td1"><h1>Sistema</h1></td>
					<td align="right" width="1"><input type="image" src="close.PNG" name="btClose" id="btClose" onClick="return btClose_click()" />
					</td>
				</tr>
			</table>
            <div class="ConteudoFora">
                <div class="Conteudo" style="background-color:#CCCCCC">
					<?php
						include("inc/fiscalizacao/infracao/autos_infracao.php");
					?>
                	<div class="Botoes"></div>
                </div>
            </div>
        </div>
	</div>
</body>
