<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsuarioController extends AppController
{    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent           
    }    

    public function index()
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navPerfil');  
        return $this->redirect('/usuario/view');   
    }

    public function view()
    {        
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navPerfil');
        $usuarioauth = $this->Auth->user('idusuario');
        $this->log('id usuario autentificado: ' . $usuarioauth,'debug');
        if ($usuarioauth != null){
            $usuario = $this->Usuario->get($usuarioauth);
            $this->set('usuario', $usuario);
        } else {
            $this->Flash->error(__('Es necesario iniciar sesion'));
            return $this->redirect(['action' => 'login']);
        }
    }   

    public function add()
    {         
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navLog');          
        if ($this->request->is(['post', 'put'])) {
            $usuario = $this->Usuario->newEntity(); 
            $usuario->comunidad_idcomunidad = "1";
            $this->Usuario->patchEntity($usuario, $this->request->getData());
            if ($this->Usuario->save($usuario)) {
                $this->Flash->success(__('Usuario creado.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Error al crear usuario.'));
        }  else {
            $usuario = $this->Usuario->newEntity(); 
            $this->set('usuario', $usuario);
        }        
    }    

    public function edit($idusuario = null)
    {        
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navPerfil');
        $usuario = $this->Usuario->get($idusuario);

        if ($this->request->is(['post', 'put'])) {
            $this->Usuario->patchEntity($usuario, $this->request->getData());
            if ($this->Usuario->save($usuario)) {
                $this->Flash->success(__('Usuario actualizado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error al actualizar usuario.'));
        }        

        $this->set('usuario', $usuario);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'logout']);
    }        

    public function login()
    {      
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navLog');
        if ($this->request->is('post')) {
            $this->log('Inside login is post','debug');
            $user = $this->Auth->identify();
            if ($user) {
                $this->log('Inside user is post','debug');
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        } else {            
            $usuario = $this->Usuario->newEntity(); 
        }
    }

    public function isAuthorized($user) {
        //auth check
        //return boolean
        return true;
    }    

    public function logout()
    {
        $this->set('activo', 'navLog');
        $usuarioauth = $this->Auth->user('idusuario');
        if ($usuarioauth != null){
            $session = $this->request->session();
            $session->destroy();
            $this->Flash->success(__('El usuario cerro session correctamente!'));
            return $this->redirect($this->Auth->logout());
        } else {
            return $this->redirect(['action' => 'login']);
        }
    }  

}