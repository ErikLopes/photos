<?php

define('CACHED_DIRECTORY',  __DIR__.'\images2'); # Diretorio onde serão armazenados as imagens
define('QT_IMAGE', 3); # Armazena a quantidade de imagens que sera retornada através de um array..default 10


include("Cache.php");


    $data['acao']            = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING);
    $data['id_categoria']    = filter_input(INPUT_GET, 'id_categoria', FILTER_VALIDATE_INT);
    $data['id_ultima_foto']  = filter_input(INPUT_GET, 'id_ultima_foto', FILTER_VALIDATE_INT);

    switch($data['acao']){
        case 'next':
            $photos = new Photos($data);
            echo $photos->managePhotos();
            break;
    }
     
   
class Photos{
    
    private $data; // - Array com os dados passado pelo usuário
    private $options; // - A principaio não será usada será a opcao de tamanho de imagem por exemplo
    private $return;// - Retorna array para o usuario;
    private $last_id_image;
    
    /**
     *
     * @type Cache
     */
    public $Cache;  // - Objeto da classe Cache
    
    
    function __construct(array $data) {
       
        $this->data = $this->validatesArray($data);
        
         $this->Cache = new Cache();
    }
    
    /**
     *  // - Essa função deverá dar tratamento, no array, de forma a não permitir nenhum tipo de ataque SQL
     * @param array $array
     * @return array
     */
    private function validatesArray(array $array){
        
        /**** CRIAR *****/
        $array['last_id_image'] = 0;
        $this->last_id_image = 0;
        
        return $array;
    }
    
    public function managePhotos(){
        
         $last_id_image = $this->data['last_id_image'];
         $id_category = $this->data['id_category'];
        
        
        // $last_id_imagem++; // - Busca a proxima chave da imagem
        for($i = 0; $i <= QT_IMAGE; $i++){
        
            if($this->Cache->searchCacheFile($last_id_image)){ // - Se existe o arquivo
                $dataImage[$i] = $this->Cache->getContentFile($last_id_image); // - Pega imagem do repositorio
            }else{
                break;
            }

            $last_id_image++;
        }
        
        # A principio deixei 2 para testes mas futuramento deverá ser igual a 10
        if(sizeof($dataImage) > 2){
           echo json_encode($dataImage);  // - retorno para o javaScript
           exit(1); // - Sai de tudo
        }
        
        # Se já ainda não foi retornado para o usuario, significa que devera ser buscado mais imagens do bd
        $this->getImageBD($last_id_image, $id_category);
        
    }
    
    /*
     * Função resposavel por buscar os links de  imagens no banco de dados
     */
    protected function getImageBD($last_id_image, $id_category){
        
        $files = array(); // - Aqui será substituido por uma consulta ao banco de dados..
        $files[0]  = "http://wallpaper.ultradownloads.com.br/173672_Papel-de-Parede-Imagem-da-Mae-Terra_1400x1050.jpg";
        $files[1]  = "http://www.clickriomafra.com.br/umbanda/wp-content/uploads/2011/07/natureza1.jpg";
        $files[2]  = "http://wallpaper.ultradownloads.com.br/95276_Papel-de-Parede-Natureza--95276_1680x1050.jpg";
        $files[3] = "http://2.bp.blogspot.com/-61xH3wklpQc/UV-iWymKFFI/AAAAAAAAOBs/h6A30i8hIoM/s1600/carro-novo-fiat-Palio-Fire-Economy-2014+(2).jpg";
        
        
        foreach($files as  $key => $file){
            $dataImage[$key] = 'data: image/jpeg;base64,'. base64_encode(file_get_contents($file));
            
            $this->Cache->setFile($key); # O nome do arquivo será o id do table Images no BD
            $this->Cache->createCacheFile($dataImage[$key]); // - Cria e salva o conteudo do arquivo 
        }   
        
        echo json_encode($dataImage);  # Retorno para o javaScript
        return;
    }
    
}