<?php
function GetStr($str, $start, $end)
{
	$a = explode($end, explode($start, $str)[1] )[0];

	return $a;
}

$num = array();
$num[9]=$num[10]=$num[11]=0;
for ($w=0; $w > -2; $w--){
    for($i=$w; $i < 9; $i++){
        $x=($i-10)*-1;
        $w==0?$num[$i]=rand(0,9):'';
        ($w==0?$num[$i]:'');
        ($w==-1 && $i==$w && $num[11]==0)?
            $num[11]+=$num[10]*2    :
            $num[10-$w]+=$num[$i-$w]*$x;
    }
    $num[10-$w]=(($num[10-$w]%11)<2?0:(11-($num[10-$w]%11)));
    $CPF = $num[10-$w];
}

$CPF = $num[0].$num[1].$num[2].$num[3].$num[4].$num[5].$num[6].$num[7].$num[8].$num[10].$num[11];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://www.juventudeweb.mte.gov.br/pnpepesquisas.asp');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, false);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  "acao=consultar%20cpf&cpf=$_GET[cpf]&nocache=0.7636039437638835");

curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml, application/x-www-form-urlencoded;charset=ISO-8859-1, text/xml; charset=ISO-8859-1','Cookie: ASPSESSIONIDSCCRRTSA=NGOIJMMDEIMAPDACNIEDFBID; FGTServer=2A56DE837DA99704910F47A454B42D1A8CCF150E0874FDE491A399A5EF5657BC0CF03A1EEB1C685B4C118A83F971F6198A78','Host: www.juventudeweb.mte.gov.br']);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

if(stristr($result, 'NOPESSOAFISICA') != false):
	$CPF = GetStr($result, 'CPF="', '"');
	$NOPESSOAFISICA = GetStr($result, 'NOPESSOAFISICA="', '"');
     $NO = GetStr($result, 'NOLOGRADOURO="', '"');
     $NT = GetStr($result, 'NRLOGRADOURO="', '"');
     $COM = GetStr($result, 'DSCOMPLEMENTO="', '"');
     $BAIRRO = GetStr($result, 'NOBAIRRO="', '"');
     $CEP = GetStr($result, 'NRCEP="', '"');
	$MUN = GetStr($result, 'NOMUNICIPIO="', '"');
	$UF = GetStr($result, 'SGUF="', '"');
	$MA = GetStr($result, 'NOMAE="', '"');
	$DTNASCIMENTO = explode('/', $DTNASCIMENTO);
	$DTNASCIMENTO = $DTNASCIMENTO[2] . '-' . $DTNASCIMENTO[1] . '-' . $DTNASCIMENTO[0];
	$DTNASCIMENTO = GetStr($result, 'DTNASCIMENTO="', '"');
 echo "Nome: ", $NOPESSOAFISICA . '<bR>';
 echo "Data De Nascimento: ", $DTNASCIMENTO . '<bR>';
 echo "Cpf: ", $CPF . '<bR>';
 echo "Rua: ", $NO . '<bR>';
 echo "Número: ", $NT . '<bR>';
 echo "Bairro: ", $BAIRRO . '<bR>';
 echo "Cep: ", $CEP . '<bR>';
 echo "Município: ", $MUN . '<bR>';
 echo "Complemento: ", $COM . '<bR>';
 echo "UF: ", $UF . '<bR>';
 echo "Nome da mãe: ", $MA . '<bR>';
else:
	echo 'nada encontrado';
endif;


?>