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
/**
 * Classe simplificada de DOMNode para manipular XML
 * @autor: maikon
 */
class tagxml{
	protected $tagname;
	protected $valor;
	
	public function __construct($tagname,$valor=NULL){
		$this->tagname = $tagname;
		$this->valor = $valor;
	}
	public function appendChild(tagxml $valor){
		$this->valor .= '<'.$valor->tagname.">".$valor->valor."</".$valor->tagname.">";
	}
}

/**
 * classe simplificada de DOMDocument para manipular XML, herda de tagxml
 * @autor: maikon
 */
class documentoXML extends tagxml {
	protected $version;
	protected $encode;
	
	public function __construct($ver='1.0',$encode='ISO-8859-1'){
		$this->version = $ver;
		$this->encode = $encode;
	}
	public function createElement($tagname,$valor=NULL){
		//return "<$tagname>$valor</$tagname>";
		return new tagxml($tagname,$valor);
	}
	public function save($caminho){
		$arquivo = fopen($caminho,'w+');
		fwrite($arquivo,$this->saveXML());
		fclose($arquivo);
	}
	public function saveXML() {
		return '<?xml version="'.$this->version.'" encoding="'.$this->encode."\"?>\n".$this->valor."\n";
	}
}

?>