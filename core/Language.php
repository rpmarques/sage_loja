<?php
class Language {
    
    private $language;
    private $ini;

    public function __construct(){

        //CRIO GLOBAL PRA PODER PEGAR O ARRAY QUE FOI CRIADO EM OUTRO ARQUIVO
        global $config; 
        $this->language = $config['default_lang'];

        if(!empty($_SESSION['lang']) && file_exists('lang/'.$_SESSION['lang'].'.ini')){
            $this->language = $_SESSION['lang'];
        }

        //PEGA O ARQUIVO .ini E CONVERTE PARA UM ARRAY
        $this->ini = parse_ini_file('lang/'.$this->language.'.ini');
    } //FIM __construct

    public function get($rPalavra,$rRetorno = false) {
        //FAÇO ISSO PRA GARANTIR QUE NÃO DE ERRO PRA QNDO FOR 
        // TRAZER A TRADUÇÃO
        $texto = $rPalavra;
        // VERIFICA SE TEM A PALAVRA LA NO DICIONARIO, SE TEM TRAZ
        
        if (isset($this->ini[$rPalavra])){
            $texto = $this->ini[$rPalavra];
        }

        // SE $rRetorno FOR TRUE RETORNA O TEXTO, CASO CONTRARIO IMPRIME
        if ($rRetorno){
            return $texto;
        }else{
            echo $texto;
        }

    } //FIM get
}

?>