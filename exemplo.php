<?php 

include('moeda.class.php');
include('cotacao.class.php');

$cotacao = new Cotacao( ['USDBRL','ARSBRL','UYUBRL','EURBRL','GBPBRL','CADBRL','AUDBRL','JPYBRL'] );
echo $cotacao->cron(2);

?>

<html>
	<head>
		<title>Teste de Cotações</title>
	</head>

	<body>
		<table>
			<tr>
				<th>Moeda<th>
				<th>Valor</th>
				<th>Data Atualizacao</th>
			</tr>
			<tr>
				<td>USD<td>
				<td><?php echo $cotacao->get('USDBRL')->getValor(); ?></td>
				<td><?php echo $cotacao->get('USDBRL')->getData()." ".$cotacao->get('USDBRL')->getHora(); ?>
			</tr>
			<tr>
				<td>UYU<td>
				<td><?php echo $cotacao->get('UYUBRL')->getValor(); ?></td>
				<td><?php echo $cotacao->get('UYUBRL')->getData()." ".$cotacao->get('UYUBRL')->getHora(); ?>
			</tr>
			<tr>
				<td>ARS<td>
				<td><?php echo $cotacao->get('ARSBRL')->getValor(); ?></td>
				<td><?php echo $cotacao->get('ARSBRL')->getData()." ".$cotacao->get('ARSBRL')->getHora(); ?>
			</tr>
		</table>
	<body>
</html>


