<?php

define('CACHED_DIRECTORY', __DIR__ . '\images2'); # Diretorio onde serão armazenados as imagens
define('QT_IMAGE', 3); # Armazena a quantidade de imagens que sera retornada através de um array..default 10


include("Cache.php");
include("Consult.php");


$data['action'] = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$data['id_category'] = filter_input(INPUT_GET, 'id_category', FILTER_VALIDATE_INT);
$data['id_last_photo'] = filter_input(INPUT_GET, 'id_last_photo', FILTER_VALIDATE_INT);


switch ($data['action']) {
    case 'next':
        $photos = new Photos($data);
        echo $photos->managePhotos();
        break;
}

class Photos {

    private $data; // - Array com os dados passado pelo usuário
    private $options; // - A principaio não será usada, mas será a opcao de tamanho de imagem por exemplo
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
    private function validatesArray(array $array) {

        /*         * ** CRIAR **** */
        $array['last_id_image'] = 0;
        $this->last_id_image = 0;

        return $array;
    }

    public function managePhotos() {

        $last_id_image = $this->data['last_id_image'];
        $id_category = $this->data['id_category'];

        $last_id_image++; // - Busca a proxima chave da imagem
        $dataImage = array();
        for ($i = 0; $i <= QT_IMAGE; $i++) {

            $this->Cache->setFile($last_id_image);

            if ($this->Cache->searchCacheFile()) { // - Se existe o arquivo
                $dataImage[$i]['data'] = $this->Cache->getContentFile($last_id_image); // - Pega imagem do repositorio
                $dataImage[$i]['key_image'] = $last_id_image;
            } else {
                break;
            }

            $last_id_image++;
        }

        # A principio deixei 2 para testes mas futuramento deverá ser igual a 10
        if (sizeof($dataImage) > 2) {
            echo json_encode($dataImage);  // - retorno para o javaScript
            exit(1); // - Sai de tudo
        }

        # Se já ainda não foi retornado para o usuario, significa que devera ser buscado mais imagens do bd
        echo $this->getImageBD($last_id_image, $id_category); // - Retorno para o JavaScript
        exit(1);
    }

    /*
     * Função resposavel por buscar os links de  imagens no banco de dados
     */

    protected function getImageBD($last_id_image, $id_category) {

        $consult = new Consult();
        //$consult->setLimitMin();  Dar o devido tratamento futuramente NAO APAGAR
        //$consult->setIdCategory(); Dar o devido tratamento futuramente NAO APAGAR
        $regs = $consult->getImages();

        $dataImage = array();
        foreach ($regs as $key => $reg) {
            $id = $reg['id'];

            $dataImage[$key]['key_image'] = $id;
            $dataImage[$key]['data'] = 'data: image/jpeg;base64,' . base64_encode(file_get_contents($reg['link']));

            $this->Cache->setFile($id); # O nome do arquivo será o id do table Images no BD. Ex.. 1.txt    
            $this->Cache->createCacheFile($dataImage[$key]['data']); // - Cria e salva o conteudo do arquivo
        }

        return json_encode($dataImage);  # Retorno para o javaScript
    }

}
