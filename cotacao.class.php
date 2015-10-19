<?php

class Cotacao{

	private $moedas;
	private $dataAtualizacao;

	public function __construct( $moedas ){
		$this->moedas = $moedas;
		$this->lerXML();
	}
	

	public function atualizar(){
		
		$moedas = implode('=x+' , $this->moedas);
		$query = "http://download.finance.yahoo.com/d/quotes.csv?s=$moedas=x&f=sl1d1t1&e=.csv";
		$linhas = explode( "\n" ,file_get_contents($query) );
		
		$moedasCarregadas = [];
		foreach($linhas as $linha){
			if( empty($linha) ) continue;
			$tmp = explode(",", $linha);

			$moeda = new Moeda(); 
			$moeda->setCodigo( str_replace('=x' ,'', str_replace('"' ,'', $tmp[0]) )      );
			$moeda->setValor(  $tmp[1]                                                    );
			$moeda->setData(   date('Y-m-d',strtotime(  str_replace('"' ,'', $tmp[2]) ) ) );
			$moeda->setHora(   date('H:i:s',strtotime(  str_replace('"','',$tmp[3] ) ) )  );
			
			$moedasCarregadas[ $moeda->getCodigo() ] = $moeda;
		}
		$this->moedasCarregadas = $moedasCarregadas;
	}


	private function gravarXML(){
		$XML = new SimpleXMLElement("<cotacoes></cotacoes>");
		
		foreach ($this->moedasCarregadas as $moeda) {
	
			$cotacao = $XML->addChild('cotacao');
			$cotacao->addChild('codigo', $moeda->getCodigo() );
			$cotacao->addChild('valor', $moeda->getValor() );
			$cotacao->addChild('data', $moeda->getData() );
			$cotacao->addChild('hora', $moeda->getHora() );

		}

		$XML->addChild('atualizacao' , date('Y-m-d H:i:s') );
		$fp = fopen("cotacoes.xml", "w");
		$escreve = fwrite($fp, $XML->asXML() );
		fclose($fp);
		
	}

	private function lerXML(){
		$xml=simplexml_load_file("cotacoes.xml");
		
		$this->dataAtualizacao = $xml->atualizacao;
		$moedasCarregadas = [];

		foreach ($xml as $cot) {

			$moeda = new Moeda(); 
			$moeda->setCodigo( $cot->codigo[0] );
			$moeda->setValor(  $cot->valor[0]  );
			$moeda->setData(   $cot->data[0]   );
			$moeda->setHora(   $cot->hora[0]   );

			$moedasCarregadas[ $moeda->getCodigo()."" ] = $moeda;
		}

		$this->moedasCarregadas = $moedasCarregadas;
		
	}


	public function cron($periodicidadeHora){
		$proximaAtualizacao = date('Y-m-d H:i:s', strtotime("+ ".$periodicidadeHora." hours" ,strtotime( $this->dataAtualizacao) ) );
	
		if( $proximaAtualizacao < date('Y-m-d H:i:s') ){
			$this->atualizar();
			$this->gravarXML();
		}
	}


	public function get( $codigo ){
		return $this->moedasCarregadas[$codigo];
	}

	public function getDataAtualizacao(){
		return $this->dataAtualizacao;
	}

}