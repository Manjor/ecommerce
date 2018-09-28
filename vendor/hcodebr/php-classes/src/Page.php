<?php

//Diz ao arquivo para usar o namespace do Hcode
namespace Hcode;

//Usa o namespace do Rain\Tpl
use Rain\Tpl;


class Page{

    //Atributos da Classe
    // create the Tpl object
    private $tpl;
    private $options = [];
    private $defaults = [
        "header"=>true,
        "footer"=>true,
        "data"=>[]
    ];

    //Cria o método construtor
    public function __construct($opts = array(), $tpl_dir = "/views/"){

        //Pede para o array chamado no parametro sobrescrever o da classe
        $this->options = array_merge($this->defaults,$opts);

        //Pede para o construtor procurar os templates a partir da pasta expecificada
	    $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]. $tpl_dir,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
        );
        
        Tpl::configure( $config );

        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);
    
        //Diz qual o primeiro arquivo a ser renderizado
        //Renderizando o arquivo header da pasta /views
        if($this->options["header"] === true)$this->tpl->draw('header');
    }

    private function setData($data = array())
	{
		foreach ($data as $key => $value) {
			$this->tpl->assign($key, $value);
		}
	}
    

    public function setTpl($name, $data = array(), $returnHTML = false)
	{
		$this->setData($data);
		return $this->tpl->draw($name, $returnHTML);
	}

    //Cria o método que é executado na finalização do objeto
    public function __destruct()
    {
        //Renderiza no final da pagina o Arquivo Footer em /views
        if($this->options["footer"] === true)$this->tpl->draw("footer");
        
    }



}


?>