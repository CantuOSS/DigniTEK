<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class ApiController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }
    
    public function index(){
        $tabla_comunidad = TableRegistry::get('Comunidad');
        $comunidad = $tabla_comunidad->get(1);
        $comunidad->imagen = "/DigniTEK/uploads/files/comunidad/" . $comunidad->imagen;
        $responseResult = json_encode($comunidad);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;        
    }

    public function tek($idtek = null){
        $tabla_tek = TableRegistry::get('Tek');
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        if ($idtek == null){
            $tek = $tabla_tek->find('all', array('order' => 'modified DESC'));
            foreach ($tek as $row){
                //$ruta = WWW_ROOT . "DigniTEK\\uploads\\files\\tek\\" . $row->idtek . "\\" . $row->imagen;
                $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $row->idtek . '/' . $row->imagen;
                //$this->log("ruta: " . $ruta, 'debug');
                $row->imagen = array('enlace' => $row->imagen, 'id' => $row->idtek, 'existe' => file_exists($ruta));
                $row->detalle = array('enlace' => 'tek/view/' . $row->idtek);
                $row->categoria = $tabla_categorias_tek->get($row->categoria_tek_idcategoria_tek)->nombre;
            }
            $responseResult = json_encode($tek);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response;              
        } else {
            $tabla_tek = TableRegistry::get('Tek');
            $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
            $tek = $tabla_tek->get($idtek);
            $tek->categoria = $tabla_categorias_tek->get($tek->categoria_tek_idcategoria_tek)->nombre;   
            $responseResult = json_encode($tek);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response;                     
        }
    }

    public function productos($idproducto = null){
        $tabla_producto = TableRegistry::get('Producto');        
        if ($idproducto == null){
            $productos = $tabla_producto->find('all');
            foreach ($productos as $row){
                //$ruta = WWW_ROOT . "DigniTEK\\uploads\\files\\tek\\" . $row->idtek . "\\" . $row->imagen;
                $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'producto/' . $row->idproducto . '/' . $row->imagen;
                //$this->log("ruta: " . $ruta, 'debug');
                $row->imagen = array('enlace' => $row->imagen, 'id' => $row->idproducto, 'existe' => file_exists($ruta));
                $row->detalle = array('enlace' => 'producto/view/' . $row->idproducto);                
            }
            $responseResult = json_encode($productos);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response;              
        } else {
            $producto = $tabla_producto->get($idproducto);            
            $responseResult = json_encode($producto);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response;                     
        }
    }    

    public function social($tipo = null, $idcontenido = null){
        if ($tipo == null && $idcontenido == null){
            $tabla_publicacion = TableRegistry::get('Publicacion');
            $tabla_evento = TableRegistry::get('Evento');
            $tabla_comentario = TableRegistry::get('Comentario');
            $publicaciones = $tabla_publicacion->find('all');
            $eventos = $tabla_evento->find('all');
            $junto = array();
            foreach ($publicaciones as $row){
                $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'publicaciones/' . $row->idpublicacion . '/' . $row->imagen;
                $temp = new \stdClass();
                $temp->titulo = $row->titulo;
                $temp->tipo = 'Publicacion';            
                $temp->fecha = $row->modified;
                $comentarios = $tabla_comentario->find('all')->where(['publicacion_idpublicacion = ' => $row->idpublicacion]);
                $cant_comentarios = 0;
                foreach($comentarios as $coment){
                    $cant_comentarios++;
                }
                $temp->comentarios = $cant_comentarios;
                $temp->imagen = array('enlace' => $row->imagen, 'id' => $row->idpublicacion, 'directorio' => 'publicaciones', 'existe' => file_exists($ruta));
                $temp->detalle = array('enlace' => 'social/view/publicacion/' . $row->idpublicacion);
                array_push($junto, $temp);
            }
            foreach ($eventos as $row){
                $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'eventos/' . $row->idevento . '/' . $row->imagen;
                $temp = new \stdClass();
                $temp->titulo = $row->titulo;
                $temp->tipo = 'Evento';
                $temp->directorio = 'eventos';
                $temp->fecha = $row->inicio;
                $temp->comentarios = 0;
                $temp->imagen = array('enlace' => $row->imagen, 'id' => $row->idevento, 'directorio' => 'eventos', 'existe' => file_exists($ruta));
                $temp->detalle = array('enlace' => 'social/view/evento/' . $row->idevento);
                array_push($junto, $temp);
            }        
            $responseResult = json_encode($junto);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response; 
        } else if ($tipo != null && $idcontenido != null) {
            if ($tipo == "eventos") {
                $tabla_evento = TableRegistry::get('Evento');
                $evento = $tabla_evento->get($idcontenido);
                //$junto = array();
                    $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'eventos/' . $evento->idevento . '/' . $evento->imagen;
                    $temp = new \stdClass();
                    $temp->titulo = $evento->titulo;
                    $temp->tipo = 'Evento';
                    $temp->directorio = 'eventos';
                    $temp->fecha = $evento->inicio;
                    $temp->comentarios = 0;
                    $temp->imagen = array('enlace' => $evento->imagen, 'id' => $evento->idevento, 'directorio' => 'eventos', 'existe' => file_exists($ruta));
                    $temp->detalle = array('enlace' => 'social/view/evento/' . $evento->idevento);
                    //array_push($junto, $temp);           
                $responseResult = json_encode($temp);
                $this->response->type('json');
                $this->response->body($responseResult);
                return $this->response;                 
            } else if ($tipo == "publicaciones") {
                $tabla_publicacion = TableRegistry::get('Publicacion');
                $tabla_comentario = TableRegistry::get('Comentario');
                $publicacion = $tabla_publicacion->get($idcontenido);
                //$junto = array();
                    $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'eventos/' . $publicacion->idevento . '/' . $publicacion->imagen;
                    $temp = new \stdClass();
                    $temp->titulo = $publicacion->titulo;
                    $temp->tipo = 'Evento';
                    $temp->directorio = 'eventos';
                    $temp->fecha = $publicacion->inicio;
                    $temp->comentarios = 0;
                    $temp->imagen = array('enlace' => $publicacion->imagen, 'id' => $publicacion->idevento, 'directorio' => 'eventos', 'existe' => file_exists($ruta));
                    $temp->detalle = array('enlace' => 'social/view/evento/' . $publicacion->idevento);
                //array_push($junto, $temp);   
                $responseResult = json_encode($temp);
                $this->response->type('json');
                $this->response->body($responseResult);
                return $this->response;                                  
            }
        } else if ($tipo != null){
            if ($tipo == "eventos") {
                $tabla_evento = TableRegistry::get('Evento');
                $eventos = $tabla_evento->find('all');
                $junto = array();
                foreach ($eventos as $row){
                    $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'eventos/' . $row->idevento . '/' . $row->imagen;
                    $temp = new \stdClass();
                    $temp->titulo = $row->titulo;
                    $temp->tipo = 'Evento';
                    $temp->directorio = 'eventos';
                    $temp->fecha = $row->inicio;
                    $temp->comentarios = 0;
                    $temp->imagen = array('enlace' => $row->imagen, 'id' => $row->idevento, 'directorio' => 'eventos', 'existe' => file_exists($ruta));
                    $temp->detalle = array('enlace' => 'social/view/evento/' . $row->idevento);
                    array_push($junto, $temp);
                }      
                $responseResult = json_encode($junto);
                $this->response->type('json');
                $this->response->body($responseResult);
                return $this->response;                           
            } else if ($tipo == "publicaciones") {
                $tabla_publicacion = TableRegistry::get('Publicacion');
                $tabla_comentario = TableRegistry::get('Comentario');
                $publicaciones = $tabla_publicacion->find('all');
                $junto = array();
                foreach ($publicaciones as $row){
                    $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'publicaciones/' . $row->idpublicacion . '/' . $row->imagen;
                    $temp = new \stdClass();
                    $temp->titulo = $row->titulo;
                    $temp->tipo = 'Publicacion';            
                    $temp->fecha = $row->modified;
                    $comentarios = $tabla_comentario->find('all')->where(['publicacion_idpublicacion = ' => $row->idpublicacion]);
                    $cant_comentarios = 0;
                    foreach($comentarios as $coment){
                        $cant_comentarios++;
                    }
                    $temp->comentarios = $cant_comentarios;
                    $temp->imagen = array('enlace' => $row->imagen, 'id' => $row->idpublicacion, 'directorio' => 'publicaciones', 'existe' => file_exists($ruta));
                    $temp->detalle = array('enlace' => 'social/view/publicacion/' . $row->idpublicacion);
                    array_push($junto, $temp);
                }          
                $responseResult = json_encode($junto);
                $this->response->type('json');
                $this->response->body($responseResult);
                return $this->response;                       
            }
        }
    }     

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['index', 'tek', 'productos', 'social']);
    }       

}

?>