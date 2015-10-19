<?php

class Moeda{

	private $codigo;
	private $valor;
	private $data;
	private $hora;

	public function setCodigo( $value ){
	 	$this->codigo = $value;
	}

	public function getCodigo(){
	 	return $this->codigo;
	}

	public function setValor( $value ){
		$this->valor = $value;
	}
	public function getValor(){
		return $this->valor;
	}
	public function setData( $value ){
		$this->data = $value;
	}
	public function getData(){
		return $this->data;
	}
	public function setHora( $value ){
		$this->hora = $value;
	}
	public function getHora(){
		return $this->hora;
	}

}
?>