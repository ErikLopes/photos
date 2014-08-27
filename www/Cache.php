<?php

/*
 * Função responsavel por realizar o cache das imagens
 * 
 */

class Cache {

    private $extension = '.txt';
    private $file = '';

    function __construct() {

        // - Caso não exista o diretório
        if (!is_dir(CACHED_DIRECTORY))
            $this->createDirectory();

        $this->file = '';
    }

    public function getFile() {
        return $this->file;
    }

    public function setFile($name) {
        $this->file = CACHED_DIRECTORY . "/" . $name . $this->extension;
    }

    /**
     * - Função responsável por criar o diretório onde ficaram os arquivos cacheados
     */
    private function createDirectory() {
        try {
            mkdir(CACHED_DIRECTORY, 0777);
        } catch (Exception $ex) {
            error_log('[Cache][createDirectory]-> ' . $ex->getMessage());
        }
    }

    /**
     * - Função que criara o arquivo no servidor..
     * @param type $value
     */
    public function createCacheFile($value) {
        try {

            if (!$this->searchCacheFile()) { // - Se não existe o arquivo
                file_put_contents($this->file, $value);
            }
        } catch (Exception $ex) {
            error_log('[Cache][createCacheFile]-> ' . $ex->getMessage());
        }
    }

    /*
     * Função reponsavel por vericar se o arquivo existe
     * 
     */

    public function searchCacheFile($name = null) {

        if ($name != null && !$this->file )
            $this->setFile($name);

        if (file_exists($this->file))
            return true;
        return false;
    }

    /*
     * Função responsavel por retornar o conteudo do arquivo
     * 
     */

    public function getContentFile() {
        /*
         * Chamar a função searchCacheFile antes dessa
         */
        try {
            return file_get_contents($this->file); // - Lê todo o arquivo
        } catch (Exception $ex) {
            error_log('[Cache][getContentFile]-> ' . $ex->getMessage());
        }
    }

}
