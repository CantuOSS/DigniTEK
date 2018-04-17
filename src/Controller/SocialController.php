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
            $publicacion = $tabla_publicacion->get($id);
            $this->set('publicacion', $publicacion);
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
                $tabla_publicacion->patchEntity($publicacion, $this->request->getData());
                if ($tabla_publicacion->save($publicacion)) {
                    $this->Flash->success(__('Publicacion actualizada.'));
                    return $this->redirect(['action' => 'view/' . $tipo . "/" . $publicacion->idpublicacion]);
                }
                $this->Flash->error(__('Error al actualizar publicacion.'));
            } else if ($tipo == "evento"){
                $tabla_evento = TableRegistry::get('Evento');
                $evento = $tabla_evento->get($id);          
                $this->set('evento', $evento);                       
                $tabla_evento->patchEntity($evento, $this->request->getData());
                if ($tabla_evento->save($evento)) {
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
                $tabla_publicacion->patchEntity($publicacion, $this->request->getData());
                $publicacion->usuario_comunidad_idcomunidad = "1";
                $publicacion->usuario_idusuario = "1";                
                if ($tabla_publicacion->save($publicacion)) {
                    $this->Flash->success(__('Publicacion creada.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Error al crear publicacion.'));                
                $this->set('publicacion', $publicacion);            
            } else if ($tipo == "evento"){
                $tabla_evento = TableRegistry::get('Evento');            
                $evento = $tabla_evento->newEntity();
                $tabla_evento->patchEntity($evento, $this->request->getData());
                $evento->usuario_comunidad_idcomunidad = "1";
                $evento->usuario_idusuario = "1";                  
                if ($tabla_evento->save($evento)) {
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
        $publicaciones = $tabla_publicacion->find('all');
        $eventos = $tabla_evento->find('all');
        $junto = array();
        foreach ($publicaciones as $row){
            $temp = new \stdClass();
            $temp->titulo = $row->titulo;
            $temp->tipo = 'Publicacion';
            $temp->fecha = $row->alta;
            $temp->comentarios = 0;
            $temp->imagen = array('enlace' => $row->imagen, 'id' => $row->idpublicacion);
            $temp->detalle = array('enlace' => 'social/view/publicacion/' . $row->idpublicacion);
            array_push($junto, $temp);
        }
        foreach ($eventos as $row){
            $temp = new \stdClass();
            $temp->titulo = $row->titulo;
            $temp->tipo = 'Evento';
            $temp->fecha = $row->inicio;
            $temp->comentarios = 0;
            $temp->imagen = array('enlace' => $row->imagen, 'id' => $row->idevento);
            $temp->detalle = array('enlace' => 'social/view/evento/' . $row->idevento);
            array_push($junto, $temp);
        }        
        $responseResult = json_encode($junto);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;        
    }    

    public function isAuthorized($user) {
        //auth check
        //return boolean 
        return true;
    }     

}