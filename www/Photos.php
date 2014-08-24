<?php


require("Cache.php");



    $data['acao']            = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING);
    $data['id_categoria']    = filter_input(INPUT_GET, 'id_categoria', FILTER_VALIDATE_INT);
    $data['id_ultima_foto']  = filter_input(INPUT_GET, 'id_ultima_foto', FILTER_VALIDATE_INT);

    switch($data['acao']){
        case 'next':
            $photos = new Photos($data);
            echo $photos->gerenciaFotos();
            break;
    }
     
   
class Photos{
    
    
    private $dados; // - Array com os dados passado pelo usuário
    private static $directory = 'images1';  // - Diretorio de onde as imagens cacheadas ficaram
    private $options; // - A principaio não será usada será a opcao de tamanho de imagem por exemplo
    
        /**
     *
     * @var ImageCache 
     */
    private $imageCache;  // - Objeto da classe ImageCache
    
    
    function __construct(array $data) {
        $this->dados = $this->validatesArray($data);
        
        $options = array('directory_name' => 'images');
        
        // - Flag para identificar se será necessário criar o diretorio de imagens
        $flag = false;
        if(!file_exists('images1'))
            $flag = false;
        
    }
    
    /**
     *  // - Essa função deverá dar tratamento, no array, de forma a não permitir nenhum tipo de ataque SQL
     * @param array $array
     * @return array
     */
    private function validatesArray(array $array){
        
        /**** CRIAR *****/
        
        
        return $array;
    }
    
    
    public function gerenciaFotos(){
        
        
        
        
        
        
        $files = array(); // - Aqui será substituido por uma consulta ao banco de dados..
        $files[0]  = "http://wallpaper.ultradownloads.com.br/173672_Papel-de-Parede-Imagem-da-Mae-Terra_1400x1050.jpg";
        $files[1]  = "http://www.clickriomafra.com.br/umbanda/wp-content/uploads/2011/07/natureza1.jpg";
        $files[2]  = "http://wallpaper.ultradownloads.com.br/95276_Papel-de-Parede-Natureza--95276_1680x1050.jpg";
        $files[3] = "http://2.bp.blogspot.com/-61xH3wklpQc/UV-iWymKFFI/AAAAAAAAOBs/h6A30i8hIoM/s1600/carro-novo-fiat-Palio-Fire-Economy-2014+(2).jpg";
        
        
        foreach($files as  $file){
          
            $dataImage[] = 'data: image/jpeg;base64,'. base64_encode(file_get_contents($file));
            
            // - Cria o cache da imagem
                    //  error_log($dataImage[$key]);
        }
        
        echo json_encode($dataImage);  // - Retorno para o javaScript
    }
    
    protected function directoryExists(){
        
    }
    
}