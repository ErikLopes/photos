// - varivel objeto do banco de dados
var db;

/// - Query de inserção para a table images
var images_string_insert = '';
var images_string_select = '';
var images_string_return = new Array();


function errorCB(err) {
    console.log(err);
}

function successCB() {
    // alert("success!");
}

function insert(tx) {
    tx.executeSql(images_string_insert);
}

function select(tx) {
    tx.executeSql(images_string_select, [], selectSucess, errorCB);
}

function selectSucess(tx, results) {

    var array = new Array();
    var length = results.rows.length;

    // - Aqui é montado um array para ser retornado para quem realizar a consulta
    // - O array é montado de acordo com as chaves(ID), do db local
    for (i = 0; i < length; i++) {
        array[i] = new Array(); // - cria um array de array
        array[i]['id'] = results.rows.item(i).id;
        array[i]['data'] = results.rows.item(i).data;
    }
    images_string_return = array;
    images_string_select = '';
}

function dataBase() {
    //return window.openDataBase("teste", "1.0.0", "Teste", 100000000);
    // console.log('oiiii');
}

/* 
 * Função que abre o banco de dados, para as devidas operações
 */
function manageDataBase() {
    db = window.openDatabase("photos", "1.0", "Bando de dados Photos", 1000000);

    // - Identifica se será necessário criar novas tabelas
    db.transaction(createTables, errorCB, successCB);
    db.t
    //insertImage(11,11); // - testes
    //var b = selectImage(); // - testes
}

/*
 * Função responsável por criar as tabelas locais, caso elas não existam 
 */
function createTables(tx) {
    tx.executeSql('CREATE TABLE IF NOT EXISTS config (id unique, password)');

    tx.executeSql('DROP TABLE images');
    tx.executeSql('CREATE TABLE IF NOT EXISTS images (id , data, active)');
}

/*
 * Função para inserir a string da imagem no bd local
 */
function insertImage(key, value) {
    console.log(key);
    images_string_insert = "INSERT INTO images (id, data) VALUES(" + key + ",'" + value + "')";
    db.transaction(insert, errorCB, successCB);
}

function selectImage() {
    images_string_select = 'SELECT * FROM images';
    db.transaction(select, errorCB);
    /*
     * Gambiarra nervosa..Ajustar futuramente  - REVER
     *  - Corrigir utilizando callback
     *  - Rever tbem quem chama essa função
     */
    setTimeout(function() {
        return images_string_return;
    }, 600);
}


