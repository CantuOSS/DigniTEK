<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class SocialController extends AppController
{
    public function initialize(){
        parent::initialize();
    }  

    public function index()
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navSocial');
    }

    public function view($tipo, $id)
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navSocial');
        $this->set('tipo', $tipo);
        $this->set('id', $id);
        if ($tipo == "publicacion"){
            $tabla_publicacion = TableRegistry::get('Publicacion');
            $tabla_usuario = TableRegistry::get('Usuario');
            $publicacion = $tabla_publicacion->get($id);
            $this->set('publicacion', $publicacion);

            //obtener comentarios de la publiacion
            $tabla_comentario = TableRegistry::get('Comentario');
            $comentarios = $tabla_comentario->find('all')->where(['publicacion_idpublicacion = ' => $publicacion->idpublicacion]);
            foreach($comentarios as $comentario){
                $usuario = $tabla_usuario->get($comentario->usuario_idusuario);
                $comentario->usuario = $usuario->nombre . " " . $usuario->apellidos;
            }
            $this->set('comentarios', $comentarios);

        } else if ($tipo == "evento"){
            $tabla_evento = TableRegistry::get('Evento');
            $evento = $tabla_evento->get($id);
            $this->set('evento', $evento);            
        }
    }    

    public function edit($tipo, $id)
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navSocial');
        $this->set('tipo', $tipo);
        if ($tipo == "publicacion"){
            $tabla_publicacion = TableRegistry::get('Publicacion');
            $publicacion = $tabla_publicacion->get($id);             
            $this->set('publicacion', $publicacion);
        } else if ($tipo == "evento"){
            $tabla_evento = TableRegistry::get('Evento');
            $evento = $tabla_evento->get($id);          
            $this->set('evento', $evento);            
        }        

        if ($this->request->is(['post', 'put'])) {
            if ($tipo == "publicacion"){
                $tabla_publicacion = TableRegistry::get('Publicacion');
                $publicacion = $tabla_publicacion->get($id);             
                $this->set('publicacion', $publicacion);        
                
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $publicacion->imagen = "portada." . $ext;
                }                
                
                $tabla_publicacion->patchEntity($publicacion, $this->request->getData());
                if ($tabla_publicacion->save($publicacion)) {

                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use
    
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
    
                        //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {
                            //name image to saved in database
                            //$employee['product_image'] = $file['name'];
    
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'publicaciones/' . $publicacion->idpublicacion . '/' . DS; //<!-- app/webroot/img/
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
    
                            //do the actual uploading of the file. First arg is the tmp name, second arg is
                            //where we are putting it
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this -> Flash -> error(__('Image could not be saved. Please, try again.'));
    
                                //return $this->redirect(['action' => 'edit']);
                            } else {                            
                                //$this->Comunidad->save($comunidad);
                                $this->Flash->error(__('Archivo subido'));
                                //return $this->redirect(['action' => 'edit']);
                            }
    
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            //return $this->redirect(['action' => 'edit']);                    
                        }
                    }

                    $this->Flash->success(__('Publicacion actualizada.'));
                    return $this->redirect(['action' => 'view/' . $tipo . "/" . $publicacion->idpublicacion]);
                }
                $this->Flash->error(__('Error al actualizar publicacion.'));
            } else if ($tipo == "evento"){
                $tabla_evento = TableRegistry::get('Evento');
                $evento = $tabla_evento->get($id);          
                $this->set('evento', $evento);       
                
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $evento->imagen = "portada." . $ext;
                }                  
                
                $tabla_evento->patchEntity($evento, $this->request->getData());
                if ($tabla_evento->save($evento)) {

                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use
    
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
    
                        //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {
                            //name image to saved in database
                            //$employee['product_image'] = $file['name'];
    
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'eventos/' . $evento->idevento . '/' . DS; //<!-- app/webroot/img/
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
    
                            //do the actual uploading of the file. First arg is the tmp name, second arg is
                            //where we are putting it
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this -> Flash -> error(__('Image could not be saved. Please, try again.'));
    
                                //return $this->redirect(['action' => 'edit']);
                            } else {                            
                                //$this->Comunidad->save($comunidad);
                                $this->Flash->error(__('Archivo subido'));
                                //return $this->redirect(['action' => 'edit']);
                            }
    
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            //return $this->redirect(['action' => 'edit']);                    
                        }
                    }                    

                    $this->Flash->success(__('Evento actualizado.'));
                    return $this->redirect(['action' => 'view/' . $tipo . "/" . $evento->idevento]);
                }
                $this->Flash->error(__('Error al actualizar evento.'));
            }
        }
    }    

    public function add($tipo)
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navSocial');
        $this->set('tipo', $tipo);
        if ($tipo == "publicacion"){
            $tabla_publicacion = TableRegistry::get('Publicacion');
            $publicacion = $tabla_publicacion->newEntity();
            $this->set('publicacion', $publicacion);            
        } else if ($tipo == "evento"){
            $tabla_evento = TableRegistry::get('Evento');
            $evento = $tabla_evento->newEntity();
            $this->set('evento', $evento);     
        }        

        if ($this->request->is(['post', 'put'])) {            
            if ($tipo == "publicacion"){
                $tabla_publicacion = TableRegistry::get('Publicacion');
                $publicacion = $tabla_publicacion->newEntity();

                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $publicacion->imagen = "portada." . $ext;
                }

                $tabla_publicacion->patchEntity($publicacion, $this->request->getData());
                $publicacion->usuario_comunidad_idcomunidad = "1";
                $publicacion->usuario_idusuario = $this->Auth->user('idusuario');                
                if ($tabla_publicacion->save($publicacion)) {

                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use
    
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
    
                        //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {
                            //name image to saved in database
                            //$employee['product_image'] = $file['name'];
    
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'publicaciones/' . $publicacion->idpublicacion . '/' . DS; //<!-- app/webroot/img/
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
    
                            //do the actual uploading of the file. First arg is the tmp name, second arg is
                            //where we are putting it
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this -> Flash -> error(__('Image could not be saved. Please, try again.'));
    
                                //return $this->redirect(['action' => 'edit']);
                            } else {                            
                                //$this->Comunidad->save($comunidad);
                                $this->Flash->error(__('Archivo subido'));
                                //return $this->redirect(['action' => 'edit']);
                            }
    
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            //return $this->redirect(['action' => 'edit']);                    
                        }
                    }                    

                    $this->Flash->success(__('Publicacion creada.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Error al crear publicacion.'));                
                $this->set('publicacion', $publicacion);            
            } else if ($tipo == "evento"){
                $tabla_evento = TableRegistry::get('Evento');            
                $evento = $tabla_evento->newEntity();

                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $evento->imagen = "portada." . $ext;
                }

                $tabla_evento->patchEntity($evento, $this->request->getData());
                $evento->usuario_comunidad_idcomunidad = "1";
                $evento->usuario_idusuario = $this->Auth->user('idusuario');                  
                if ($tabla_evento->save($evento)) {

                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use
    
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
    
                        //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {
                            //name image to saved in database
                            //$employee['product_image'] = $file['name'];
    
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'social/' . 'eventos/' . $evento->idevento . '/' . DS; //<!-- app/webroot/img/
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
    
                            //do the actual uploading of the file. First arg is the tmp name, second arg is
                            //where we are putting it
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this -> Flash -> error(__('Image could not be saved. Please, try again.'));
    
                                //return $this->redirect(['action' => 'edit']);
                            } else {                            
                                //$this->Comunidad->save($comunidad);
                                $this->Flash->error(__('Archivo subido'));
                                //return $this->redirect(['action' => 'edit']);
                            }
    
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            //return $this->redirect(['action' => 'edit']);                    
                        }
                    }                     

                    $this->Flash->success(__('Evento creado.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Error al crear evento.'));                    
                $this->set('evento', $evento);     
            }             
        }        
    }    

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['listasocial']);
    }     

    public function listasocial(){
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
    }    

    public function medios($tipo = null, $idsocial = null){
        if ($idsocial != null && $tipo != null){
            $tabla_publicacion = TableRegistry::get('Publicacion');
            $tabla_evento = TableRegistry::get('Evento');
            $directorio = '';
            if ($tipo == 'publicacion'){
                $social = $tabla_publicacion->get($idsocial);
                $directorio = 'publicaciones';
            } else if ($tipo == 'evento'){
                $social = $tabla_evento->get($idsocial);
                $directorio = 'eventos';
            }
            if (!empty($social)){
                $medios = array();     
                $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'social/' . $directorio . '/' . $idsocial . '/';
                $temp = new \stdClass();
                $temp->image = array("src" => $dir . $social->imagen, "poster" => $dir . $social->imagen);
                array_push($medios, $temp);           
                $responseResult = json_encode($medios);
                $this->response->type('json');
                $this->response->body($responseResult);
                return $this->response;   
            }                 
        }
    }   
    
    public function agregacomentario(){
        if ($this->request->is(['post', 'put'])) {
            if (!empty($this->request->getData())){
                //echo print_r($this->request->getData());
                $tabla_comentario = TableRegistry::get('Comentario');
                $comentario = $tabla_comentario->newEntity();
                $comentario->publicacion_usuario_comunidad_idcomunidad = "1";
                $tabla_comentario->patchEntity($comentario, $this->request->getData());
                if ($tabla_comentario->save($comentario)) {
                    $this->Flash->success(__('Comentario agregado.'));                                      
                } else {
                    $this->Flash->error(__('Error al agregar comentario.'));                    
                }
                return $this->redirect(['action' => 'view/publicacion/' . $comentario->publicacion_idpublicacion]);                  
            }
            }
        return $this->redirect(['action' => 'index']);                  
    }

    public function isAuthorized($user) {
        // All registered users can add posts
        if ($this->request->action === 'add') {
            return true;
        }
        //$this->log("ID post para editar: " . $this->request->getParam('pass')[1] , 'debug');
        //$this->log("tipo para editar: " . $this->request->getParam('pass')[0] , 'debug');
        //$this->log("Tipo de accion: " . $this->request->action , 'debug');
        //$this->log("ID usuario: " . $user['idusuario'], 'debug');
        // The owner of a post can edit and delete it
        if (in_array($this->request->action, array('edit', 'delete'))) {            
            $postId = (int) $this->request->getParam('pass')[1];
            $tipo = $this->request->getParam('pass')[0];
            if ($tipo == "publicacion"){
                $tabla_publicacion = TableRegistry::get('Publicacion');
                if ($tabla_publicacion->find('propietario', ['usuario' => $user, 'post' => $postId])) {
                    return true;
                } else {
                    return false;
                }
            } else if ($tipo == "evento"){
                $tabla_evento = TableRegistry::get('Evento');
                $this->log("resultado de propietario de evento: " , 'debug');
                if ($tabla_evento->find('propietario', ['usuario' => $user, 'post' => $postId])) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return parent::isAuthorized($user);
    }     

}