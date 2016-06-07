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
    session_name("emissores_iss");
    session_start();
    include("../../../funcoes/util.php");
    include("../../conect.php");

    // recebe os dados
    $obra=strip_tags(addslashes($_POST["txtObra"]));
    $alvara=strip_tags(addslashes($_POST["txtAlvara"]));
    $iptu=strip_tags(addslashes($_POST['txtIptu']));
    $endereco=strip_tags(addslashes($_POST["txtEndereco"]));
    $proprietario=strip_tags(addslashes($_POST["txtProprietario"]));
    $cnpjcpf=$_POST["txtCnpjCpf"];
    $listamateriais=strip_tags(addslashes($_POST['txtListaMateriais']));
    $valormateriais=$_POST['txtValorMateriais'];
    $data=date("Y-m-d");
    $sql=mysql_query("SELECT codigo FROM cadastro WHERE cnpj='".$_SESSION['login']."'");
    list($codcadastro)=mysql_fetch_array($sql);

    // verifica se nao ha outra obra com o mesmo alvara ou com o mesmo iptu
    $sql_verifica_alvara=mysql_query("SELECT codigo FROM obras WHERE alvara='$alvara'");
    $sql_verifica_iptu=mysql_query("SELECT codigo FROM obras WHERE iptu='$iptu'");
    if(mysql_num_rows($sql_verifica_alvara)>0)
        {
            Mensagem("Já existe uma obra cadastrada com este alvará.");
        }
    elseif(mysql_num_rows($sql_verifica_iptu)>0)
        {
            Mensagem("Já existe uma obra cadastrada com este IPTU");
        }
    else
        {
            mysql_query("INSERT INTO obras SET
                         codcadastro='$codcadastro',
                         obra='$obra',
                         alvara='$alvara',
                         iptu='$iptu',
                         endereco='$endereco',
                         proprietario='$proprietario',
                         proprietario_cnpjcpf='$cnpjcpf',
                         dataini='$data',
                         listamateriais='$listamateriais',
                         valormateriais='$valormateriais'");
            Mensagem("Obra cadastrada com sucesso");
        }
    Redireciona("../../../principal.php");
?>