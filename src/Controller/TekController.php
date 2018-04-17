<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class TekController extends AppController
{
    public function initialize(){
        parent::initialize();
        //$this->set('titulo', 'Nombre de la comunidad');
    }

    public function index()
    {            
        $this->set('activo', 'navTek');
    }

    public function view($idtek = null)
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navTek');
        $tek = $this->Tek->get($idtek);
        $this->set('tek', $tek);
    }    

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['listatek']);
    }      

    public function listatek(){
        $tek = $this->Tek->find('all');
        foreach ($tek as $row){
            $row->imagen = array('enlace' => $row->imagen, 'id' => $row->idtek);
            $row->detalle = array('enlace' => 'tek/view/' . $row->idtek);
        }
        $responseResult = json_encode($tek);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;        
    }

    public function add()
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navTek');
        $tek = $this->Tek->newEntity(); 
        if ($this->request->is(['post', 'put'])) {            
            $tek->usuario_comunidad_idcomunidad = "1";
            $tek->usuario_idusuario = "1";
            $tek->categoria_tek_idcategoria_tek = "1";
            $this->Tek->patchEntity($tek, $this->request->getData());
            if ($this->Tek->save($tek)) {
                $this->Flash->success(__('Tek creado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error al crear TEK.'));
        } else {            
            $this->set('tek', $tek); 
        }

    }    

    public function edit($idtek = null)
    {
        $this->set('activo', 'navTek');
        $tek = $this->Tek->get($idtek);

        if ($this->request->is(['post', 'put'])) {
            $this->Tek->patchEntity($tek, $this->request->getData());
            if ($this->Tek->save($tek)) {
                $this->Flash->success(__('TEK actualizado.'));
                return $this->redirect(['action' => 'view/' . $tek->idtek]);
            }
            $this->Flash->error(__('Error al actualizar TEK.'));
        }               

        $this->set('tek', $tek);        
    }    

    public function isAuthorized($user) {
        //auth check
        //return boolean
        return true;
    }     
}
?>