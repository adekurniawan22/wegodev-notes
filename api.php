<?php
     //INI ADALAH API SEDERHNA, HANYA UNTUK UJI COB MATERI VUE JS
     header('Access-Control-Allow-Methods: GET, POST');
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Allow-Origin: *");
     include_once 'config/Database.php';

     class api {
          private $db = "";

          function __construct() {
               $database = new Database();
               $this->db = $database->koneksi();
          }

          function createNote($title, $description){
               $getNotes = $this->db->prepare("insert into note (title, description)
                                               VALUES (:title, :description)");
               $getNotes->execute(['title' => $title, 'description' => $description]);

               $id = $this->db->lastInsertId();

               return json_encode(['status' => true, 'id' => $id, 'pesan' => 'data berhasil disimpan']);
          }


          function deleteNote($id){
               $deleteNotes = $this->db->prepare("DELETE FROM note WHERE id = :id");
               $deleteNotes->execute(['id' => $id]);
          }

          function updateNote($id, $title, $description){
               $getNotes = $this->db->prepare("UPDATE note SET title = :title,
                                                               description = :description
                                                               WHERE id = :id");
               $getNotes->execute(['id' => $id,
                                   'title' => $title,
                                   'description' => $description]);
          }

          function allNotes(){
               $getNotes = $this->db->prepare("SELECT * FROM note ORDER BY id DESC");
               $getNotes->execute();
               $notes = $getNotes->fetchAll(PDO::FETCH_ASSOC);

               return json_encode($notes);
          }

          function getNote($id = false){
               $getNotes = $this->db->prepare("SELECT * FROM note WHERE id = :id");
               $getNotes->execute(['id' => $id]);
               $notes = $getNotes->fetchAll(PDO::FETCH_ASSOC);

               return json_encode($notes);
          }
     }

     $api = new Api();
     $f = $_GET["f"] ?? false;

     if($f == "CREATE"){
          echo $api->createNote($_POST['title'], $_POST['description']);
     }
     else if($f == "UPDATE"){
          $api->updateNote($_POST['id'], $_POST['title'], $_POST['description']);
     }
     else if($f == "DELETE"){
          $api->deleteNote($_POST['id']);
     }
     else{
          if(isset($_GET['id'])){
               echo $api->getNote($_GET['id']);
          }else{
               echo $api->allNotes();
          }
     }

?>
