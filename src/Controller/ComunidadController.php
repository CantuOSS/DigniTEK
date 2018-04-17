<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use Cake\Event\Event;

class ComunidadController extends AppController
{
    public function initialize(){
        parent::initialize();        
    }

    public function index()
    {        
        //$this->set('titulo', 'Comunidad');
        $this->set('activo', 'navComunidad');
        $this->set('modulo', 'comunidad');   
        $comunidad = $this->Comunidad->get(1);
        $this->set('comunidad', $comunidad);
    }

    public function edit(){
        ob_start();
        $this->set('activo', 'navComunidad');
        $this->set('modulo', 'comunidad');   
        $comunidad = $this->Comunidad->get(1);

        if ($this->request->is(['post', 'put'])) { 
            if (!empty($this->request->getData())) {
                //$this -> Flash -> error(__('Submit error: ' . print_r($this->request->getData()['image_path'])));

                //Check if image has been uploaded
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

                        $dir = WWW_ROOT . 'uploads/' . 'files/' . 'comunidad/' . DS; //<!-- app/webroot/img/
                        mkdir($dir, 0755, true);
                        array_map('unlink', glob($dir . "portada.*"));                        

                        //do the actual uploading of the file. First arg is the tmp name, second arg is
                        //where we are putting it
                        if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                        {
                            $this -> Flash -> error(__('Image could not be saved. Please, try again.'));

                            //return $this->redirect(['action' => 'edit']);
                        } else {
                            $comunidad->imagen = "portada." . $ext;
                            //$this->Comunidad->save($comunidad);
                            $this->Flash->error(__('Archivo subido'));
                            //return $this->redirect(['action' => 'edit']);
                        }

                    } else {
                        $this->Flash->error(__('Extension no valida'));
                        //return $this->redirect(['action' => 'edit']);                    
                    }
                }                

                $this->Comunidad->patchEntity($comunidad, $this->request->getData());
                if ($this->Comunidad->save($comunidad)) {
                    $this->Flash->success(__('Datos de la comunidad actualizados.'));   
                    return $this->redirect(['action' => 'index']);                 
                }
                else {
                    //$this->Flash->error(__('Error al actualizar comunidad.'));
                }
            }
            //return $this->redirect(['action' => 'edit']);
        } else {            

            $this->set('comunidad', $comunidad);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['medios']);
    }     

    public function medios(){
        $comunidad = $this->Comunidad->get(1);
        $medios = array();     
        $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'comunidad/';
        $temp = new \stdClass();
        $temp->image = array("src" => $dir . $comunidad->imagen, "poster" => $dir . $comunidad->imagen);
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

    public function isAuthorized($user) {
        //auth check
        //return boolean
        return true;
    }       
}
?>