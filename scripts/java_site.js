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

function verificaTomador(campo, cont){
	var cnpj = campo.value;
	if(cnpj!=''){
		ajax({
			url: 'include/verifica_tomadores.ajax.php?valor='+cnpj+'&cad=n',
			espera: function(){
				document.getElementById('tdServ'+cont).innerHTML = 'Verificando...';
			},
			sucesso: function(){
				document.getElementById('tdServ'+cont).innerHTML = respostaAjax;
			}
		});
	}else{
		document.getElementById('tdServ'+cont).innerHTML = '&nbsp;';
	}
}

<!-- muda propriedade de uma div
function changeProp(objId,x,theProp,theValue) { //v9.0
  var obj = null; with (document){ if (getElementById)
  obj = getElementById(objId); }
  if (obj){
    if (theValue == true || theValue == false)
      eval("obj.style."+theProp+"="+theValue);
    else eval("obj.style."+theProp+"='"+theValue+"'");
  }
}
//-->

/*
*Funcao que cancela a declaracao
*OBS: o parametro tipo eh opcional para o deconline, eli indicara a qual tipo de prestador
*a declaracao esta se referindo
*/
function CancelarDeclaracaoAjax(tabela,cont,site,tipo){//site true ou false se precisar voltar uma pasta
	var codigo = document.getElementById('txtCodigoGuia'+cont).value;
	var motivo = "";
	if(false){//confirm box com div
		confirmBox.show('mensagem');
		return false;
	}else{
		while (motivo === "")// prompt de pergunta e solicitacao de motivo
			motivo = prompt("Insira o motivo do cancelamento: ", "");
		
		var url = 'include/cancelar_declaracao.ajax.php?codigo='+codigo+'&motivo='+motivo+'&tabela='+tabela+'&tipo='+tipo;
		if(site)
			url = '../'+url;
		if (motivo !== null) {// se confirmar executa ajax
			ajax({
				url: url,
				espera: function(){
					document.getElementById('tdCancelar'+cont).innerHTML = '<img src="img/botoes/loading.gif">';
				},
				sucesso: function(){
					var resposta = respostaAjax;
					if (resposta){
						document.getElementById('trDes'+cont).style.backgroundColor="#FFAC84";
						document.getElementById('tdCancelar'+cont).innerHTML = 'Cancelado';
						alert('Cancelamento concluído!');
					}
				}
			});
			return true;
		} else {
			return false;
		}
	}
}
var confirmBox = {
	show: function(msg,ok){
		var div = document.createElement('div');
		div.style.width = '100%';
		div.style.height = '100%';
		div.style.backgroundColor = '#FFFFFF';
		id("boxMsg").innerHTML = msg;
		document.body.appendChild(div);
		//id("btnConfirmarBox").onclick = ok;
		id('confirmacao').style.display = '';
	},
	close: function(){
		id('confirmacao').style.display = 'none';
	}
};

function GuiaPagamento_TotalISS() {
	if (document.getElementById('ckTodos').checked == true) {
		var aux = document.getElementById('txtTotalIssHidden').value;
		var dados = aux.split("|");
		var soma = 0;

		while (dados[1] >= 0) {
			document.getElementById('ckISS' + dados[1]).checked = true;

			aux = document.getElementById('ckISS' + dados[1]).value;
			valor = aux.split("|");
			document.getElementById('txtCodNota' + dados[1]).value = valor[1];
			soma = parseFloat(soma) + parseFloat(valor[0]);
			dados[1]--;
		}
		document.getElementById('txtTotalIss').value = DecToMoeda(soma);
		CalculaMultaDes();
	} else {
		var aux = document.getElementById('txtTotalIssHidden').value;
		var dados = aux.split("|");
		while (dados[1] >= 0) {
			document.getElementById('ckISS' + dados[1]).checked = false;
			document.getElementById('txtCodNota' + dados[1]).value = '';
			dados[1]--;
		}
		document.getElementById('txtTotalIss').value = DecToMoeda(0);
		CalculaMultaDes();
	}
}

function GuiaPagamento_SomaISS(iss) {
	var valor = iss.value.split("|");
	var numero = iss.id.split("ckISS");
	if (iss.checked == true) {
		var total = MoedaToDec(document.getElementById('txtTotalIss').value);
		total += parseFloat(valor[0]);
		total = total.toFixed(2);
		document.getElementById('txtTotalIss').value = DecToMoeda(total);
		document.getElementById('txtCodNota' + numero[1]).value = valor[1];
		CalculaMultaDes();
	} else {
		var total = MoedaToDec(document.getElementById('txtTotalIss').value);
		var valor = iss.value.split("|");
		total -= parseFloat(valor[0]);
		total = total.toFixed(2);
		document.getElementById('txtTotalIss').value = DecToMoeda(total);
		document.getElementById('txtCodNota' + numero[1]).value = '';
		CalculaMultaDes();
	}

}

var cont = 0, contservicos = 1, conttbl = 0, totalemissores_des = 0;

function buscaCidades(campo, resultado, site) {//site true ou false, se precisar voltar uma pasta
	var url = site ? 'include/listamunicipio.ajax.php?UF=' + campo.value
			: '../include/listamunicipio.ajax.php?UF=' + campo.value;
	if (campo.value != '') {
		
		ajax({
			url:url,
			espera: function() {document.getElementById(resultado).innerHTML = '<select style="width:150px;"><option/></select>';},
			sucesso: function() {document.getElementById(resultado).innerHTML = respostaAjax;}
		});
	} else {
		document.getElementById(resultado).innerHTML = '<select style="width:150px;"><option/></select>';
	}
}

function verificaCnpjCpfIm() {
	if (document.getElementById('txtInscMunicipal')
			&& (document.getElementById('txtCNPJ'))) {
		if (!document.getElementById('txtCNPJ').value
				&& !document.getElementById('txtInscMunicipal').value) {
			alert('Favor preencher um dos campos para avançar!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if (document.getElementById('txtCNPJ').value
				&& document.getElementById('txtInscMunicipal').value) {
			alert('Preencher apenas um dos campos!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if (!document.getElementById('txtInscMunicipal').value
				&& (document.getElementById('txtCNPJ').value.length != 14)
				&& (document.getElementById('txtCNPJ').value.length != 18)) {
			alert('CNPJ/CPF inválido! Favor verificar');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
	} else {
		if ((!document.getElementById('txtCNPJ').value)
				|| (!document.getElementById('txtSenha').value)) {
			alert('Favor preencher os campos para avançar!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if ((document.getElementById('txtCNPJ').value.length != 14)
				&& (document.getElementById('txtCNPJ').value.length != 18)) {
			alert('CNPJ/CPF inválido! Favor verificar');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
	}
}

var des = {
	cancelarDeclaracao : function(cont) {
		return CancelarDeclaracaoAjax('des',cont);
	},
	cancelarGuia : function(cont) {
		return CancelarDeclaracaoAjax('guia_pagamento',cont);
	}
};

var des_issretido = {
	cancelarDeclaracao : function(cont) {
		return CancelarDeclaracaoAjax('des_issretido',cont,true);
	}
};

var desn = {
	cancelarDeclaracao : function(cont) {
		return CancelarDeclaracaoAjax('simples_des',cont);
	}
};

var dop = {
	CalculaImposto : function (campoBase,campoAliq,campoImposto){
		var base = MoedaToDec(campoBase.value);
		var aliq;
		if(campoAliq.value=='')
			aliq = 0;
		else
			aliq = parseFloat(campoAliq.value)/100;
		var total=base*aliq;
		campoImposto.value = DecToMoeda(total);
		
		this.SomaImpostos();
		this.CalculaMulta();
	},
	CalculaMulta : function (){
		var mesComp = window.document.getElementById('cmbMes').value;
		var anoComp = window.document.getElementById('cmbAno').value;
		if (mesComp==''||anoComp=='')
			return false;
			
		var dataServ = window.document.getElementById('hdDataAtual').value.split('/');	
		var diaAtual = dataServ[0];
		var mesAtual = dataServ[1];
		var anoAtual = dataServ[2];
		
		var diaComp = window.document.getElementById('hdDia').value;
		mesComp = parseInt(mesComp) + 1;
		
		var dataAtual = new Date(mesAtual+'/'+diaAtual+'/'+anoAtual);
		var dataComp = new Date(mesComp+'/'+diaComp+'/'+anoComp);
		var diasDec = diasDecorridos(dataComp,dataAtual);
		
		
		var nroMultas = window.document.getElementById('hdNroMultas').value;
		
		if(diasDec>0)
			var multa = 0;
		else
			var multa = -1;
			
		for(var c=0;c < nroMultas; c++){
			var diasMulta = window.document.getElementById('hdMulta_dias'+c).value;
			if(diasDec>diasMulta){
				var multa = c;	
				if(multa<nroMultas-1)
					multa++;
			}//end if
		}//end for
		
		var impostototal = MoedaToDec(window.document.getElementById('txtImpostoTotal').value);
		if(multa>=0){
			var multavalor = 0;
			var multajuros = 0;
			if(window.document.getElementById('hdMulta_valor'+multa)){
				multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
			}
			if(window.document.getElementById('hdMulta_juros'+multa)){
				multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
			}
			var jurosvalor = impostototal*multajuros/100;
			var multatotal = jurosvalor + multavalor;
			var totalpagar = multatotal + impostototal;
			window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
		}
		else{
			window.document.getElementById('txtMultaJuros').value = '0,00';
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
		}
	},
	SomaImpostos : function (){
		var nservs = parseFloat(window.document.getElementById('hdServicos').value);
		var soma   = 0;
		for(cont=1;cont<=nservs;cont++){
			var campo = 'txtImposto'+cont+'';
			soma = soma +MoedaToDec(window.document.getElementById(campo).value);
		}
		window.document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
	},
	InserirServ : function (){
		document.getElementById('hdServicos').value++;
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = '';
		document.getElementById('trServb'+cont).style.display = '';
		document.getElementById('btServRemover').disabled = false;
		if(cont==document.getElementById('hdServMax').value){
			document.getElementById('btServInserir').disabled = true;
		}

	},
	RemoverServ : function (){
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = 'none';
		document.getElementById('trServb'+cont).style.display = 'none';
		document.getElementById('txtCNPJTomador'+cont).value = '';
		document.getElementById('cmbCodServico'+cont).innerHTML = '<option/>';
		document.getElementById('txtBaseCalculo'+cont).value = '';
		document.getElementById('txtImposto'+cont).value = '';
		document.getElementById('txtNroDoc'+cont).value = '';
		document.getElementById('hdServicos').value--;
		document.getElementById('btServInserir').disabled = false;
		if(document.getElementById('hdServicos').value<=1){
			document.getElementById('btServRemover').disabled = true;
		};
		this.SomaImpostos();
		this.CalculaMulta();
	},
	cancelarDeclaracao : function (cont){
		//var codigo = document.getElementById('txtCodigoGuia'+cont).value;
		return CancelarDeclaracaoAjax('dop_des',cont);
	},
	cancelarGuia : function(cont) {
		return CancelarDeclaracaoAjax('guia_pagamento',cont,'','dop_des');
	},
	buscaServicos : function (campo ,cont ){
		var cnpj = campo.value;
		if(cnpj!=''){
			ajax({
				url: 'include/dop/servicos_prestador.ajax.php?cnpj='+campo.value+'&contador='+cont,
				espera: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
				},
				sucesso: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = respostaAjax;
				}
			});
			ajax({
				url: 'include/verificacnpjcpf.ajax.php?valor='+campo.value,
				espera: function(){
					document.getElementById('tdServ'+cont).innerHTML = 'Verificando...';
				},
				sucesso: function(){
					// Abaixo colocamos a resposta na div do campo que fez a requisição
					document.getElementById('tdServ'+cont).innerHTML = respostaAjax;
				}
			});
		}else{
			document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
			document.getElementById('tdServ'+cont).innerHTML = '&nbsp';
		}
	}
};

var decc = {
	CalculaImposto : function (campoBase,campoAliq,campoImposto){
		var base = MoedaToDec(campoBase.value);
		var aliq;
		if(campoAliq.value=='')
			aliq = 0;
		else
			aliq = parseFloat(campoAliq.value)/100;
		var total=base*aliq;
		campoImposto.value = DecToMoeda(total);
		
		this.SomaImpostos();
		this.CalculaMulta();
	},
	CalculaMulta : function (){
		var mesComp = window.document.getElementById('cmbMes').value;
		var anoComp = window.document.getElementById('cmbAno').value;
		if (mesComp==''||anoComp=='')
			return false;
			
		var dataServ = window.document.getElementById('hdDataAtual').value.split('/');	
		var diaAtual = dataServ[0];
		var mesAtual = dataServ[1];
		var anoAtual = dataServ[2];
		
		var diaComp = window.document.getElementById('hdDia').value;
		mesComp = parseInt(mesComp) + 1;
		
		var dataAtual = new Date(mesAtual+'/'+diaAtual+'/'+anoAtual);
		var dataComp = new Date(mesComp+'/'+diaComp+'/'+anoComp);
		var diasDec = diasDecorridos(dataComp,dataAtual);
		
		
		var nroMultas = window.document.getElementById('hdNroMultas').value;
		
		if(diasDec>0)
			var multa = 0;
		else
			var multa = -1;
			
		for(var c=0;c < nroMultas; c++){
			var diasMulta = window.document.getElementById('hdMulta_dias'+c).value;
			if(diasDec>diasMulta){
				var multa = c;	
				if(multa<nroMultas-1)
					multa++;
			}//end if
		}//end for
		
		var impostototal = MoedaToDec(window.document.getElementById('txtImpostoTotal').value);
		if(multa>=0){
			var multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
			var multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
			var jurosvalor = impostototal*multajuros/100;
			var multatotal = jurosvalor + multavalor;
			var totalpagar = multatotal + impostototal;
			window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
		}
		else{
			window.document.getElementById('txtMultaJuros').value = '0,00';
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
		}
	},
	SomaImpostos : function (){
		var nservs = parseFloat(window.document.getElementById('hdServicos').value);
		var soma   = 0;
		for(cont=1;cont<=nservs;cont++){
			var campo = 'txtImposto'+cont+'';
			soma = soma +MoedaToDec(window.document.getElementById(campo).value);
		}
		window.document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
	},
	InserirServ : function (){
		document.getElementById('hdServicos').value++;
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = '';
		document.getElementById('trServb'+cont).style.display = '';
		document.getElementById('btServRemover').disabled = false;
		if(cont==document.getElementById('hdServMax').value){
			document.getElementById('btServInserir').disabled = true;
		}

	},
	RemoverServ : function (){
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = 'none';
		document.getElementById('trServb'+cont).style.display = 'none';
		document.getElementById('txtCNPJTomador'+cont).value = '';
		document.getElementById('cmbCodServico'+cont).innerHTML = '<option/>';
		document.getElementById('txtBaseCalculo'+cont).value = '';
		document.getElementById('txtImposto'+cont).value = '';
		document.getElementById('txtNroDoc'+cont).value = '';
		document.getElementById('hdServicos').value--;
		document.getElementById('btServInserir').disabled = false;
		if(document.getElementById('hdServicos').value<=1){
			document.getElementById('btServRemover').disabled = true;
		};
		this.SomaImpostos();
		this.CalculaMulta();
	},
	cancelarDeclaracao : function (cont){
		//var codigo = document.getElementById('txtCodigoGuia'+cont).value;
		return CancelarDeclaracaoAjax('decc_des',cont);
	},
	cancelarGuia : function(cont) {
		return CancelarDeclaracaoAjax('guia_pagamento',cont,'','decc_des');
	},
	buscaServicos : function (campo ,cont ){
		var cnpj = campo.value;
		if(cnpj!=''){
			ajax({
				url: 'include/dop/servicos_prestador.ajax.php?cnpj='+campo.value+'&contador='+cont,
				espera: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
				},
				sucesso: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = respostaAjax;
				}
			});
			ajax({
				url: 'include/verificacnpjcpf.ajax.php?valor='+campo.value,
				espera: function(){
					document.getElementById('tdServ'+cont).innerHTML = 'Verificando...';
				},
				sucesso: function(){
					// Abaixo colocamos a resposta na div do campo que fez a requisição
					document.getElementById('tdServ'+cont).innerHTML = respostaAjax;
				}
			});
		}else{
			document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
			document.getElementById('tdServ'+cont).innerHTML = '&nbsp';
		}
	}
};

var dif = {
	cancelarDeclaracao : function (cont){
		return CancelarDeclaracaoAjax('dif_des',cont);
	},
	cancelarGuia : function(cont) {
		return CancelarDeclaracaoAjax('guia_pagamento',cont,'','dif_des');
	}
};

var doc = {	
	cancelarDeclaracao : function (cont){
		return CancelarDeclaracaoAjax('doc_des',cont);
	},
	cancelarGuia : function(cont) {
		return CancelarDeclaracaoAjax('guia_pagamento',cont,'','doc_des');
	}
};


function verificaCnpjCpfImAIDF() {
	if (document.getElementById('txtCNPJ')) {
		if (!document.getElementById('txtCNPJ').value
				&& !document.getElementById('txtInscMunicipal').value) {
			alert('Favor preencher um dos campos do Solicitante para avançar!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if (document.getElementById('txtCNPJ').value
				&& document.getElementById('txtInscMunicipal').value) {
			alert('Preencher apenas um dos campos do Solicitante!');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
		if (!document.getElementById('txtInscMunicipal').value
				&& (document.getElementById('txtCNPJ').value.length != 14)
				&& (document.getElementById('txtCNPJ').value.length != 18)) {
			alert('CNPJ/CPF do Solicitante inválido! Favor verificar');
			document.getElementById('txtCNPJ').focus();
			return false;
		}
	}
	if (document.getElementById('txtCNPJGrafica')) {
		if (!document.getElementById('txtCNPJGrafica').value
				&& !document.getElementById('txtInscMunicipalGrafica').value) {
			alert('Favor preencher um dos campos da Grafica para avançar!');
			document.getElementById('txtCNPJGrafica').focus();
			return false;
		}
		if (document.getElementById('txtCNPJGrafica').value
				&& document.getElementById('txtInscMunicipalGrafica').value) {
			alert('Preencher apenas um dos campos da Grafica!');
			document.getElementById('txtCNPJGrafica').focus();
			return false;
		}
		if (!document.getElementById('txtInscMunicipalGrafica').value
				&& (document.getElementById('txtCNPJGrafica').value.length != 14)
				&& (document.getElementById('txtCNPJGrafica').value.length != 18)) {
			alert('CNPJ/CPF da Grafica inválido! Favor verificar');
			document.getElementById('txtCNPJGrafica').focus();
			return false;
		}
	}
}

function SubmitImprimirAidf(id) {
	var guia = document.getElementById('txtCodigo' + id).value;
	if (confirm('Imprimir AIDF (' + guia + ')?')) {
		document.getElementById('hdCodAidf').value = guia;
		document.getElementById('frmAidf').submit();
	} else
		return false;
}

function SubmitSegundaViaGuia(id) {
	var guia = document.getElementById('txtCodigoGuia' + id).value;
	if (confirm('Imprimir guia (' + guia + ')?')) {
		document.getElementById('hdCodGuia').value = guia;
		document.getElementById('frmGuia').submit();
	} else
		return false;
}

function TomadorInserirNF() {
	document.getElementById('hdUltima').value++;
	var cont = document.getElementById('hdUltima').value;
	document.getElementById('trNota' + cont).style.display = '';
	document.getElementById('trNotab' + cont).style.display = '';
	document.getElementById('btNotaRemover').disabled = false;
}

function TomadorRemoverNF() {
	var cont = document.getElementById('hdUltima').value;
	document.getElementById('trNota' + cont).style.display = 'none';
	document.getElementById('trNotab' + cont).style.display = 'none';
	document.getElementById('tdNota' + cont).innerHTML = ' ';
	document.getElementById('txtCodigoGuia' + cont).value = '';
	document.getElementById('txtDataEmissao' + cont).value = '';
	document.getElementById('txtPrestador' + cont).value = '';
	document.getElementById('txtValor' + cont).value = '';
	document.getElementById('hdUltima').value--;
	if (document.getElementById('hdUltima').value <= 1)
		document.getElementById('btNotaRemover').disabled = true;
}

function EmissorInserirServ() {
	document.getElementById('hdServicos').value++;
	var cont = document.getElementById('hdServicos').value;
	document.getElementById('trServ' + cont).style.display = '';
	document.getElementById('trServb' + cont).style.display = '';
	document.getElementById('btServRemover').disabled = false;
	if (cont == document.getElementById('hdServMax').value) {
		document.getElementById('btServInserir').disabled = true;
	}

}

function EmissorRemoverServ() {
	var cont = document.getElementById('hdServicos').value;
	document.getElementById('trServ' + cont).style.display = 'none';
	document.getElementById('trServb' + cont).style.display = 'none';
	document.getElementById('txtTomadorCnpjCpf' + cont).value = '';
	document.getElementById('cmbCodServico' + cont).value = '';
	document.getElementById('txtBaseCalculo' + cont).value = '';
	document.getElementById('txtImposto' + cont).value = '';
	document.getElementById('txtNroDoc' + cont).value = '';
	document.getElementById('hdServicos').value--;
	document.getElementById('btServInserir').disabled = false;
	if (document.getElementById('hdServicos').value <= 1) {
		document.getElementById('btServRemover').disabled = true;
	}
	SomaImpostosDes();
	CalculaMultaDes();
}

function ValidarDesTomador() {
	var total = document.getElementById('hdUltima').value;

	if (!(document.getElementById('txtNome').value)) {
		alert('Informe seu Nome!');
		return false;
	}
	for (c = 1; total >= c; total--) {
		if ((!(document.getElementById('txtPrestador' + total).value))
				|| (!(document.getElementById('txtCodigoGuia' + total).value))
				|| (!(document.getElementById('txtValor' + total).value))
				|| (document.getElementById('txtValor' + total).value == '0,00')
				|| (!document.getElementById('txtDataEmissao' + total).value)) {
			alert('Preencha os todos os campos para realizar a declaração!');
			return false;
		}
		if (document.getElementById('tdNota' + total).innerHTML == '<font color="#ff0000">Emissor não cadastrado</font>') {
			alert('Emissor Digitado não consta em nosso sistema, Favor verifique os dados!');
			document.getElementById('txtPrestador' + total).focus();
			return false;
		}
		if (document.getElementById('tdNota' + total).innerHTML == '') {
			alert('Verifique Emissor!');
			document.getElementById('txtPrestador' + total).focus();
			return false;
		}
		if (document.getElementById('tdNota' + total).innerHTML == 'Pesquisando...') {
			alert('Pesquisando...');
			document.getElementById('txtPrestador' + total).focus();
			return false;
		}
		if ((document.getElementById('txtDataEmissao' + total).value == '')
				|| ((document.getElementById('txtDataEmissao' + total).value.length != 10))) {
			alert('Preencha a data corretamente (dd/mm/aaa)!');
			document.getElementById('txtDataEmissao' + total).focus();
			return false;
		}
		return true;
	}
}

function ValidarDesIssRetido() {
	var total = totalemissores_des;

	if ((!(document.getElementById('cmbAno').value))
			|| (!(document.getElementById('cmbMes').value))) {
		alert('Informe a competência da declaração !');
		return false;
	}

	if (!(document.getElementById('txtRazaoNome').value)) {
		alert('Informe sua RazãoSocial/Nome!');
		return false;
	}
	for (c = 1; total >= c; total--) {

		if ((!(document.getElementById('txtcnpjcpf' + total).value))
				|| (!(document.getElementById('txtNroNota' + total).value))
				|| (!(document.getElementById('txtValIssRetido' + total).value))) {
			alert('Preencha os campos Obrigatórios para realizar a declaração!');
			return false;
		}
		if (document.getElementById('hdvalidar' + total).value == 'n') {
			alert('Emissor Digitado não consta em nosso sistema, Favor verifique os dados !');
			document.getElementById('txtcnpjcpf' + total).focus();
			return false;
		}
		return true;

	}
}

function SomaIssRetido() {
	var soma = 0;
	var total = totalemissores_des;
	for (c = 1; total >= c; total--) {
		soma += MoedaToDec(document.getElementById('txtValIssRetido' + total).value);
	}
	document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
}

function ConsultaCnpj(campo, cont) {
	
	ajax({
		url: 'inc/verificaprestadorcnpj.ajax.php?valor=' + campo.value,
		espera: function(){
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = '<font color="gray">Verificando...</font>';
		},
		sucesso: function() {
			var resposta = respostaAjax;
			if (resposta == 'Emissor não cadastrado') {
				document.getElementById('hdvalidar' + cont).value = 'n';
				resposta = '<font color=#ff0000>' + resposta + '</font>';
			} else {
				document.getElementById('hdvalidar' + cont).value = 's';
			}
			// Abaixo colocamos a resposta na div do campo que fez a requisição
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = resposta;
		}
	});/*
	// Verificar o Browser
	// Firefox, Google Chrome, Safari e outros
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	}
	// Internet Explorer
	else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = 'inc/verificaprestadorcnpj.ajax.php?valor=' + campo.value;

	req.open("Get", url, true);

	// Quando o objeto recebe o retorno, chamamos a seguinte função;
	req.onreadystatechange = function() {

		// Exibe a mensagem "Verificando" enquanto carrega
		if (req.readyState == 1) {
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = '<font color="gray">Verificando...</font>';
		}

		// Verifica se o Ajax realizou todas as operações corretamente
		// (essencial)
		if (req.readyState == 4 && req.status == 200) {
			// Resposta retornada pelo validacao.php
			var resposta = req.responseText;
			if (resposta == 'Emissor não cadastrado') {
				document.getElementById('hdvalidar' + cont).value = 'n';
				resposta = '<font color=#ff0000>' + resposta + '</font>';
			} else {
				document.getElementById('hdvalidar' + cont).value = 's';
			}
			// Abaixo colocamos a resposta na div do campo que fez a requisição
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = resposta;
		}

	};
	req.send(null);*/
}

function DesTomadores(i) {

	var div = document.getElementById('divEmissores');

	if (i == 'inserir') {
		var contador = conttbl;
		var valorCPF = new Array(conttbl);
		var valorNRONOTA = new Array(conttbl);
		var valorISSRETIDO = new Array(conttbl);
		var valorVALNOTA = new Array(conttbl);

		while (contador > 0) {
			if (document.getElementById('txtcnpjcpf' + contador).value) {
				valorCPF[contador] = document
						.getElementById('txtcnpjcpf' + contador).value;
			}

			if (document.getElementById('txtNroNota' + contador).value) {
				valorNRONOTA[contador] = document
						.getElementById('txtNroNota' + contador).value;
			}

			if (document.getElementById('txtValNota' + contador).value) {
				valorVALNOTA[contador] = document
						.getElementById('txtValNota' + contador).value;
			}

			if (document.getElementById('txtValIssRetido' + contador).value) {
				valorISSRETIDO[contador] = document
						.getElementById('txtValIssRetido' + contador).value;
			}
			contador--;

		}

		conttbl++;
		totalemissores_des++;

		var div = document.getElementById('divEmissores');
		div.innerHTML = div.innerHTML
				+ "<table id='tbl"
				+ conttbl+ "' width='100%' border='0'><tr><td width='24%' align=center><font color='#FF0000'>*</font><input onkeydown='return NumbersOnly( event );' onkeyup='CNPJCPFMsk( this );' onblur='ConsultaCnpj(txtcnpjcpf"
				+ conttbl+ ","+ conttbl+ ");' size='18' id='txtcnpjcpf"+ conttbl+ "' name='txtcnpjcpf"
				+ conttbl+ "' class='texto' type='text'></font></td><td width='22%' align=center><font color='#FF0000'>*</font><input name='txtNroNota"
				+ conttbl+ "' id='txtNroNota"
				+ conttbl+ "' size='14' class='texto' type='text'><input type='hidden' id='hdvalidar"
				+ conttbl+ "'></td><td width='29%' align=center><font color='#FF0000'>*</font><input type='text' class='texto' id='txtValNota"
				+ conttbl+ "' name='txtValNota"	+ conttbl+ "' onkeyup='MaskMoeda(this)' size='14'></td><td width='25%' align=center><font color='#FF0000'>*</font><input name='txtValIssRetido"
				+ conttbl+ "' onkeyup='MaskMoeda(this)' onblur='SomaIssRetido();CalculaMultaDes();' id='txtValIssRetido"
				+ conttbl+ "' class='texto' type='text' size='14'></td></tr><tr><td colspan='4'><div id='divtxtcnpjcpf"
				+ conttbl + "' align='center'> </div></td></tr></table>";

		if (contador >= 0) {
			while (contador < conttbl) {
				if (valorCPF[contador]) {
					document.getElementById('txtcnpjcpf' + contador).value = valorCPF[contador];
				}

				if (valorNRONOTA[contador]) {
					document.getElementById('txtNroNota' + contador).value = valorNRONOTA[contador];
				}

				if (valorVALNOTA[contador]) {
					document.getElementById('txtValNota' + contador).value = valorVALNOTA[contador];
				}

				if (valorISSRETIDO[contador]) {
					document.getElementById('txtValIssRetido' + contador).value = valorISSRETIDO[contador];
				}
				contador++;
			}
		}

		if (conttbl > 1) {
			document.getElementById('btRemover').disabled = false;
		}

	}

	else if (i == 'deletar') {
		if ((conttbl != 0) && (conttbl != 1)) {
			var tabela = document.getElementById('tbl' + conttbl);
			div.removeChild(tabela);
			conttbl--;
			totalemissores_des--;
		}
		if (conttbl <= 1) {
			document.getElementById('btRemover').disabled = true;
		}
	}

}

function SubmitDesSemTomador() {
	var string = 'txtImpostoTotal|txtMultaJuros|txtTotalPagar';

	var nservs = window.document.getElementById('hdServicos').value;
	for (cont = 0; cont < nservs; cont++)
		string += '|txtBaseCalculo' + cont + '|txtImposto' + cont + '';
	MoedaToDecimalSubmit(string);
	return true;
}

function CancelarNota(id) {
	if (confirm('Tem certeza que deseja cancelar esta nota ?')) {
		window.location.href = 'inc/notas_cancelar.php?CODIGO=' + id;
	} else {
		window.alert("Operação não realizada!");
		history.go(-2);
	}
}

function CalculaImpostoDes(campoBase, campoAliq, campoImposto, campoIssRetido) {
	var base = MoedaToDec(campoBase.value);
	var aliq;
	if (campoAliq.value == ''){
		aliq = 0;
	}else{
		aliq = parseFloat(campoAliq.value) / 100;
	}
	
	var total = base * aliq;
	
	//testa se tem iss retido na declaracao, se sim recalcula o imposto, se nao continua normal
	if(campoIssRetido !== undefined){
		
		//valor digitado para o iss retido
		var valor_iss_retido = parseFloat(MoedaToDec(campoIssRetido.value));
		
		//nao eh possivel reter mais que o valor do imposto, para nao ficar com o imposto negativo
		if(valor_iss_retido >= total){
			//se for maior que o imposto, o valor retido fica como o total do imposto e o total imposto fica zerado
			campoIssRetido.value = DecToMoeda(total);
			total = 0.00;
		}else{
			//se o iss retido for menor que o total de imposto, subtrai o valor do iss retido do total e conclui a soma
			total = total - valor_iss_retido;
		}
	}
	
	campoImposto.value = DecToMoeda(total);

	SomaImpostosDes();
	CalculaMultaDes();
}

//declaracao de Recibo de Prestador Autonomo
function CalculaImpostoRPA(campoBase, campoAliq, campoImposto, campoIssRetido) {
	var base = MoedaToDec(campoBase.value);
	var aliq;
	if (campoAliq.value == ''){
		aliq = 0;
	}else{
		aliq = parseFloat(campoAliq.value);
	}
	var total = aliq;
	
	//testa se tem iss retido na declaracao, se sim recalcula o imposto, se nao continua normal
	if(campoIssRetido !== undefined){
		
		//valor digitado para o iss retido
		var valor_iss_retido = parseFloat(MoedaToDec(campoIssRetido.value));
		
		//nao eh possivel reter mais que o valor do imposto, para nao ficar com o imposto negativo
		if(valor_iss_retido >= total){
			//se for maior que o imposto, o valor retido fica como o total do imposto e o total imposto fica zerado
			campoIssRetido.value = DecToMoeda(total);
			total = 0.00;
		}else{
			//se o iss retido for menor que o total de imposto, subtrai o valor do iss retido do total e conclui a soma
			total = total - valor_iss_retido;
		}
	}
	
	campoImposto.value = DecToMoeda(total);

	SomaImpostosDes();
	CalculaMultaDes();
}
function CalculaMultaDes() {
	var mesComp = window.document.getElementById('cmbMes').value;
	var anoComp = window.document.getElementById('cmbAno').value;
	if (mesComp == '' || anoComp == '')
		return false;

	var dataServ = window.document.getElementById('hdDataAtual').value
			.split('/');
	var diaAtual = dataServ[0];
	var mesAtual = dataServ[1];
	var anoAtual = dataServ[2];

	var diaComp = window.document.getElementById('hdDia').value;
	mesComp = parseFloat(mesComp) + 1;

	var dataAtual = new Date(mesAtual + '/' + diaAtual + '/' + anoAtual);
	var dataComp = new Date(mesComp + '/' + diaComp + '/' + anoComp);
	var diasDec = diasDecorridos(dataComp, dataAtual);

	var nroMultas = window.document.getElementById('hdNroMultas').value;

	if (diasDec > 0)
		var multa = 0;
	else
		var multa = -1;

	for ( var c = 0; c < nroMultas; c++) {
		var diasMulta = window.document.getElementById('hdMulta_dias' + c).value;
		if (diasDec > diasMulta) {
			var multa = c;
			if (multa < nroMultas - 1)
				multa++;
		}// end if
	}// end for

	if (document.getElementById('txtTotalIss'))
		var impostototal = MoedaToDec(window.document
				.getElementById('txtTotalIss').value);
	else
		var impostototal = MoedaToDec(window.document
				.getElementById('txtImpostoTotal').value);
	if (multa >= 0) {
		var multavalor = 0;
		var multajuros = 0;
		if(window.document.getElementById('hdMulta_valor'+multa)){
			multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
		}
		if(window.document.getElementById('hdMulta_juros'+multa)){
			multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
		}
		var jurosvalor = impostototal * multajuros / 100;
		var multatotal = jurosvalor + multavalor;
		var totalpagar = multatotal + impostototal;
		window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
	} else {
		window.document.getElementById('txtMultaJuros').value = '0,00';
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
	}
}
function SomaImpostosDes() {
	var nservs = parseFloat(window.document.getElementById('hdServicos').value);
	var soma = 0;
	for (cont = 1; cont <= nservs; cont++) {
		var campo = 'txtImposto' + cont + '';
		if (document.getElementById('txtEmo' + cont + '')) {
			var emo = 'txtEmo' + cont + '';
			soma = soma + MoedaToDec(window.document.getElementById(emo).value);
		}
		soma = soma + MoedaToDec(window.document.getElementById(campo).value);
	}
	window.document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
}

function ValorIss(cred1, reg1, cred2, reg2, cred3) {
	var credito_final;
	var credito = 0;
	var credito1 = cred1;
	var credito2 = cred2;
	var credito3 = cred3;
	var regra1 = reg1;
	var regra2 = reg1;

	var basecalc = document.getElementById('txtBaseCalculo').value;
	var valdeduc = document.getElementById('txtValorDeducoes').value;
	var aliquota = document.getElementById('cmbCodServico').value;
	if ((basecalc != "") && (valdeduc != "")) {
		var iss = parseFloat(basecalc) * parseFloat(aliquota) / 100;
		document.getElementById('txtISS').value = iss;

		var total = parseFloat(basecalc) + parseFloat(valdeduc);
		document.getElementById('txtValTotal').value = total;

		if (total < regra1) {
			credito = credito1;
		} else if (total < regra2) {
			credito = credito2;
		} else {
			credito = credito3;
		}

		credito_final = (parseFloat(iss) * parseFloat(credito)) / 100;
		document.getElementById('txtCredito').value = credito_final;
	}

}
var socios=1;
// txtNomeSocio txtCpfSocio
function excluirSocio() {

	document.getElementById('campossocio' + socios).style.display = 'none';
	document.getElementById('linha01socio' + socios).style.display = 'none';
	document.getElementById('linha02socio' + socios).style.display = 'none';
	document.getElementById('txtCpfSocio' + socios).value = "";
	document.getElementById('txtNomeSocio' + socios).value = "";

	socios--;
}
function incluirSocio() {
	if (socios < 10) {
		socios++;
		document.getElementById('campossocio' + socios).style.display = 'block';
		document.getElementById('linha01socio' + socios).style.display = 'block';
		document.getElementById('linha02socio' + socios).style.display = 'block';
	}

}

function excluirServico() {

	document.getElementById('camposservico' + contservicos).style.display = 'none';
	document.getElementById('linha01servico' + contservicos).style.display = 'none';
	// document.getElementById('linha02servico'+contservicos).style.display='none';
	document.getElementById('cmbCodigo' + contservicos).value = "";
	contservicos--;
}

function incluirServico() {
	if (contservicos < 5) {
		contservicos++;
		document.getElementById('camposservico' + contservicos).style.display = 'block';
		document.getElementById('linha01servico' + contservicos).style.display = 'block';
		// document.getElementById('linha02servico'+contservicos).style.display='block';
	}
}

function ServicosCategorias(categoria) {
	var dados;
	dados = categoria.value;
	if (dados != "") {
		dados = dados.split("|");
		while (dados[2] > 0) {
			if (document.getElementById('div' + dados[2] + dados[1])) {
				document.getElementById('div' + dados[2] + dados[1]).style.display = 'none';
			}

			if (document.getElementById('cmbCodigo' + dados[2] + dados[1])) {
				document.getElementById('cmbCodigo' + dados[2] + dados[1]).value = '';
			}
			dados[2]--;
		}
		document.getElementById('div' + dados[0] + dados[1]).style.display = 'block';
	}

}

function excluirServico(cod) {
	dados = cod.name;
	dados = dados.split("|");
	document.getElementById('camposservico' + dados[2]).style.display = 'none';
	document.getElementById('linha01servico' + dados[2]).style.display = 'none';
	// document.getElementById('linha02servico'+contservicos).style.display='none';
	while (dados[1] > 0) {
		//document.getElementById('cmbCodigo' + dados[1] + dados[2]).value = '';
		document.getElementById('cmbCategoria' + dados[2]).value = '';
		//document.getElementById('div' + dados[1] + dados[2]).style.display = 'none';
		dados[1]--;
	}
	contservicos--;
}

function buscaServicosCartorioTipo(campo, resultado, contador) {
	if (campo.value != '') {
		var req;
		// Verificar o Browser
		// Firefox, Google Chrome, Safari e outros
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
		}
		// Internet Explorer
		else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
		}

		var url = 'include/dec/listarservicoscartorio.ajax.php?codigo='
				+ campo.value + '&contador=' + contador;

		req.open("Get", url, true);

		// Quando o objeto recebe o retorno, chamamos a seguinte função;
		req.onreadystatechange = function() {

			// Exibe a mensagem "Verificando" enquanto carrega
			if (req.readyState == 1) {
				document.getElementById(resultado).innerHTML = '<select style="width:280px;"><option/></select>';
			}

			// Verifica se o Ajax realizou todas as operações corretamente (essencial)
			if (req.readyState == 4 && req.status == 200) {
				// Resposta retornada pelo validacao.php
				var resposta = req.responseText;
				//alert(resposta);
				// Abaixo colocamos a resposta na div do campo que fez a requisição
				document.getElementById(resultado).innerHTML = resposta;
			}

		};
		req.send(null);
	} else {
		document.getElementById(resultado).innerHTML = '<select style="width:280px;"><option/></select>';
	}
}

function ValidaCkbDec(campo){
	var total = parseInt(document.getElementById(campo).value);
	if(total>0){
		return true;
	}else{
		alert('É necessário que escolha ao menos uma declaração');
		return false;
	}
}//teste se tem pelo penos uma declaracao selecionada para gerar a guia
