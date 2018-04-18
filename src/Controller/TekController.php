<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        $categoria = $tabla_categorias_tek->get($tek->categoria_tek_idcategoria_tek)->nombre;
        $this->set('categoria', $categoria);
    }    

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['listatek', 'medios', 'listacategorias']);
    }      

    public function listatek(){
        $tek = $this->Tek->find('all');
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        foreach ($tek as $row){
            $row->imagen = array('enlace' => $row->imagen, 'id' => $row->idtek);
            $row->detalle = array('enlace' => 'tek/view/' . $row->idtek);
            $row->categoria = $tabla_categorias_tek->get($row->categoria_tek_idcategoria_tek)->nombre;
        }
        $responseResult = json_encode($tek);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;        
    }

    public function listacategorias(){
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        $categorias = $tabla_categorias_tek->find('all');
        $cat_ret = array();
        foreach ($categorias as $row){
            array_push($cat_ret, $row->nombre);
        }        
        $responseResult = json_encode($cat_ret);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;          
    }

    public function add()
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navTek');
        $tek = $this->Tek->newEntity(); 
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        //$categorias = $tabla_categorias_tek->find('all');  
        $categorias = $tabla_categorias_tek->find('list');      
        //$tek->categorias = $categorias;
        $this->set('categorias', $categorias);
        if ($this->request->is(['post', 'put'])) {      
            if (!empty($this->request->getData())) {      
                $tek->usuario_comunidad_idcomunidad = "1";
                $tek->usuario_idusuario = $this->Auth->user('idusuario');;
                //$tek->categoria_tek_idcategoria_tek = $this->request->getData()['idcategoria_tek'];                 
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $tek->imagen = "portada." . $ext;
                }

                $this->Tek->patchEntity($tek, $this->request->getData());
                if ($this->Tek->save($tek)) {


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
    
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $tek->idtek . '/' . DS; //<!-- app/webroot/img/
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

                    $this->Flash->success(__('Tek creado.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Error al crear TEK.'));
                }
            }
        } else {            
            $this->set('tek', $tek); 
        }

    }    

    public function edit($idtek = null)
    {
        $this->set('activo', 'navTek');
        $tek = $this->Tek->get($idtek);
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        $categorias = $tabla_categorias_tek->find('list');      
        $this->set('categorias', $categorias);
        if ($this->request->is(['post', 'put'])) {
            if (!empty($this->request->getData())) {

                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $tek->imagen = "portada." . $ext;
                }                

                $this->Tek->patchEntity($tek, $this->request->getData());
                if ($this->Tek->save($tek)) {
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
    
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $tek->idtek . '/' . DS; //<!-- app/webroot/img/
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
                    $this->Flash->success(__('TEK actualizado.'));
                    return $this->redirect(['action' => 'view/' . $tek->idtek]);
                }
                $this->Flash->error(__('Error al actualizar TEK.'));
            }
        }               

        $this->set('tek', $tek);        
    } 
    
    public function medios($idtek = null){
        if ($idtek != null){
            $tek = $this->Tek->get($idtek);
            $medios = array();     
            $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'tek/' . $idtek . '/';
            $temp = new \stdClass();
            $temp->image = array("src" => $dir . $tek->imagen, "poster" => $dir . $tek->imagen);
            array_push($medios, $temp);                   
            /*foreach ($comunidad as $row){
                $temp = new \stdClass();
                $temp->image = array("src" => $row->imagen, "poster" => $row->imagen);
                array_push($medios, $temp);
            }*/
            $responseResult = json_encode($medios);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response;        
        }
    }    

    public function isAuthorized($user) {
        //auth check
        //return boolean
        return true;
    }     
}
?>