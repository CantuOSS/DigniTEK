<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ProductoController extends AppController
{
    public function initialize(){
        parent::initialize();
    }    

    public function index()
    {
        $this->set('activo', 'navProductos');
    }

    public function view($idproducto = null)
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navProductos');
        $producto = $this->Producto->get($idproducto);
        $this->set('producto', $producto);
        $this->set('modulo', 'producto');   

        //recopilar y almacenar medios para mostrar
        $medios = array();     
        $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'producto/' . $idproducto . '/';
        $temp = $this->Producto->newEntity();
        $temp->ruta = $dir . $producto->imagen;
        $temp->descripcion = "Imagen de portada para producto: " . $producto->nombre; 
        array_push($medios, $temp);           
        $tabla_multimedia = TableRegistry::get('Multimedia');
        $tabla_productohasmultimedia = TableRegistry::get('ProductoHasMultimedia');   
        $relacion_medios = $tabla_productohasmultimedia->find('all')->where(['producto_idproducto = ' => $producto->idproducto]);
        foreach ($relacion_medios as $rel){
            $multimedia = $tabla_multimedia->get($rel->multimedia_idmultimedia);
            if (!empty($multimedia)){
                //$temp = new \stdClass();
                //$temp->image = array("src" => $dir . $multimedia->enlace, "poster" => $dir . $multimedia->enlace, "idmedio" => $multimedia->idmultimedia, "descripcion" => $multimedia->descripcion);
                //array_push($medios, $temp);
                $multimedia->ruta = $dir . $multimedia->enlace;
                array_push($medios, $multimedia);
            }
        }
        $this->set('medios', $medios);   
        $this->set('editar', false);        
    }    

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['listaproductos']);
    }          

    public function listaproductos(){
        $producto = $this->Producto->find('all');
        foreach ($producto as $row){
            $row->imagen = array('enlace' => $row->imagen, 'id' => $row->idproducto);
            $row->detalle = array('enlace' => 'producto/view/' . $row->idproducto);
        }
        $responseResult = json_encode($producto);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;        
    }    

    public function add()
    {
        //$this->set('titulo', 'Nombre de la comunidad');
        $this->set('activo', 'navProductos');
        $producto = $this->Producto->newEntity(); 
        if ($this->request->is(['post', 'put'])) {  
            if (!empty($this->request->getData())) {        
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $producto->imagen = "portada." . $ext;
                }                
                
                $producto->usuario_comunidad_idcomunidad = "1";
                $producto->usuario_idusuario = $this->Auth->user('idusuario');            
                $this->Producto->patchEntity($producto, $this->request->getData());
                if ($this->Producto->save($producto)) {
                    //guardar imagen de portada
                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                        if(in_array($ext, $arr_ext))
                        {
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'producto/' . $producto->idproducto . '/' . DS; //<!-- app/webroot/img/
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this->Flash->error(__('Image could not be saved. Please, try again.'));
                            } else {                            
                                $this->Flash->error(__('Archivo subido'));
                                //return $this->redirect(['action' => 'view/' . $producto->idproducto]);
                            }
    
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            //return $this->redirect(['action' => 'view/' . $producto->idproducto]);                  
                        }
                    }

                    $this->Flash->success(__('Producto creado.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('Error al crear producto.'));
            }            
        } else {            
            $this->set('producto', $producto); 
        }

    }    

    public function edit($idproducto = null)
    {
        $this->set('activo', 'navProductos');
        $producto = $this->Producto->get($idproducto);

        if ($this->request->is(['post', 'put'])) {
            if (!empty($this->request->getData())) {
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use                
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension                    
                    $producto->imagen = "portada." . $ext;
                }

                $this->Producto->patchEntity($producto, $this->request->getData());
                if ($this->Producto->save($producto)) {
                    //guardar imagen de portada
                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0]; //put the data into a var for easy use
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                        if(in_array($ext, $arr_ext))
                        {
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'producto/' . $producto->idproducto . '/' . DS; //<!-- app/webroot/img/
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this->Flash->error(__('Image could not be saved. Please, try again.'));
                            } else {                            
                                $this->Flash->error(__('Archivo subido'));
                                //return $this->redirect(['action' => 'view/' . $producto->idproducto]);
                            }
    
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            //return $this->redirect(['action' => 'view/' . $producto->idproducto]);                  
                        }
                    }

                    //cargar medios multimedia xd
                    if(!empty($this->request->getData()['multimedia']) && count($this->request->getData()['multimedia']) > 0){
                        $tabla_multimedia = TableRegistry::get('Multimedia');
                        $tabla_productohasmultimedia = TableRegistry::get('ProductoHasMultimedia');
                        foreach ($this->request->getData()['multimedia'] as $adjunto){
                            $multimedia = $tabla_multimedia->newEntity(); 
                            $enlace = $tabla_productohasmultimedia->newEntity(); 
                            $ext = substr(strtolower(strrchr($adjunto['name'], '.')), 1); //get the extension
                            $multimedia->enlace = $adjunto['name'];
                            $multimedia->formato = $ext;
                            if ($tabla_multimedia->save($multimedia)){
                                $enlace->producto_idproducto = $producto->idproducto;
                                $enlace->producto_usuario_idusuario = $producto->usuario_idusuario;
                                $enlace->producto_usuario_comunidad_idcomunidad = 1;                                
                                $enlace->multimedia_idmultimedia = $multimedia->idmultimedia;
                                $tabla_productohasmultimedia->save($enlace);

                                //copiar archivo temporal
                                $file = $adjunto; //put the data into a var for easy use
                                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                                if(in_array($ext, $arr_ext))
                                {
                                    $dir = WWW_ROOT . 'uploads/' . 'files/' . 'producto/' . $producto->idproducto . '/' . DS; //<!-- app/webroot/img/
                                    mkdir($dir, 0755, true);
                                    //array_map('unlink', glob($dir . "portada.*"));                        
                                    if(!move_uploaded_file($file['tmp_name'], $dir . $file['name'])) 
                                    {
                                        $this->Flash->error(__('Image could not be saved. Please, try again: ' . $file['name']));
                                    } else {                            
                                        $this->Flash->success(__('Archivo subido: ' . $file['name']));                                        
                                    }
            
                                } else {
                                    $this->Flash->error(__('Extension no valida para archivo: ' . $file['name']));                                    
                                }                                
                            }
                        }                        
                    }                    

                    $this->Flash->success(__('Producto actualizado.'));
                    return $this->redirect(['action' => 'view/' . $producto->idproducto]);
                }
            } else {
                $this->Flash->error(__('Error al actualizar producto.'));
            }
        }               

        $this->set('producto', $producto); 

        //recopilar y almacenar medios para mostrar
        $medios = array();     
        $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'producto/' . $idproducto . '/';         
        $tabla_multimedia = TableRegistry::get('Multimedia');
        $tabla_productohasmultimedia = TableRegistry::get('ProductoHasMultimedia');   
        $relacion_medios = $tabla_productohasmultimedia->find('all')->where(['producto_idproducto = ' => $producto->idproducto]);
        foreach ($relacion_medios as $rel){
            $multimedia = $tabla_multimedia->get($rel->multimedia_idmultimedia);
            if (!empty($multimedia)){
                //$temp = new \stdClass();
                //$temp->image = array("src" => $dir . $multimedia->enlace, "poster" => $dir . $multimedia->enlace, "idmedio" => $multimedia->idmultimedia, "descripcion" => $multimedia->descripcion);
                //array_push($medios, $temp);
                $multimedia->ruta = $dir . $multimedia->enlace;
                array_push($medios, $multimedia);
            }
        }
        $this->set('medios', $medios);           

        $this->set('editar', true);                   
    } 

    public function medios($idproducto = null){
        if ($idproducto != null){
            $producto = $this->Producto->get($idproducto);
            $medios = array();     
            $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'producto/' . $idproducto . '/';
            $temp = new \stdClass();
            $temp->image = array("src" => $dir . $producto->imagen, "poster" => $dir . $producto->imagen);
            array_push($medios, $temp);           
            $tabla_multimedia = TableRegistry::get('Multimedia');
            $tabla_productohasmultimedia = TableRegistry::get('ProductoHasMultimedia');   
            $relacion_medios = $tabla_productohasmultimedia->find('all')->where(['producto_idproducto = ' => $producto->idproducto]);
            foreach ($relacion_medios as $rel){
                $multimedia = $tabla_multimedia->get($rel->multimedia_idmultimedia);
                if (!empty($multimedia)){
                    $temp = new \stdClass();
                    $temp->image = array("src" => $dir . $multimedia->enlace, "poster" => $dir . $multimedia->enlace, "idmedio" => $multimedia->idmultimedia, "descripcion" => $multimedia->descripcion);
                    array_push($medios, $temp);
                }
            }
            $responseResult = json_encode($medios);
            $this->response->type('json');
            $this->response->body($responseResult);
            return $this->response;        
        }
    }    

    public function editmedios($idmultimedia = null){
        if ($this->request->is(['post', 'put'])) {
            if (!empty($this->request->getData())) {
                $tabla_multimedia = TableRegistry::get('Multimedia');
                $tabla_productohasmultimedia = TableRegistry::get('ProductoHasMultimedia');                
                $multimedia = $tabla_multimedia->get($idmultimedia);
                $relacion_medios = $tabla_productohasmultimedia->find('all')->where(['multimedia_idmultimedia = ' => $idmultimedia]);
                $idproducto = '';
                foreach ($relacion_medios as $rel){
                    $idproducto = $rel->producto_idproducto;
                }
                $tabla_multimedia->patchEntity($multimedia, $this->request->getData());
                if ($tabla_multimedia->save($multimedia)) {
                    $this->Flash->success(__('Multimedia actualizado'));
                } else {
                    $this->Flash->success(__('Error al actualizar multimedia'));
                }
                return $this->redirect(['action' => 'edit/' . $idproducto]);
            }
        }
    }    

    public function elimmedios($idmedio = null){
        if ($idmedio != null){
            if ($this->request->is(['post', 'put'])) {
                $tabla_multimedia = TableRegistry::get('Multimedia');
                $tabla_productohasmultimedia = TableRegistry::get('ProductoHasMultimedia');   
                $relacion_medios = $tabla_productohasmultimedia->find('all')->where(['multimedia_idmultimedia = ' => $idmedio]);
                foreach ($relacion_medios as $instancia){
                    $idproducto = $instancia->producto_idproducto;
                    $result = $tabla_productohasmultimedia->delete($instancia);
                    if ($result){
                        $multimedia = $tabla_multimedia->get($idmedio);
                        $archivo = $multimedia->enlace;
                        $resultmult = $tabla_multimedia->delete($multimedia);
                        if ($resultmult){
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'producto/' . $idproducto . '/' . DS; //<!-- app/webroot/img/
                            array_map('unlink', glob($dir . $archivo)); 
                            $this->Flash->success(__('Multimedia eliminado: ' . $archivo));
                        } else {
                            $this->Flash->error(__('Error al eliminar instancia multimedia'));
                        }
                    } else {
                        $this->Flash->error(__('Error al eliminar referencia multimedia'));
                    }
                }         
                return $this->redirect(['action' => 'edit/' . $idproducto]);   
            }
        } else {
            return $this->redirect(['action' => 'index']);   
        }        
    }    

    public function isAuthorized($user) {
        // All registered users can add posts
        if ($this->request->action === 'add') {
            return true;
        }
        //$this->log("ID post para editar producto: " . $this->request->getParam('pass')[0] , 'debug');
        //$this->log("Tipo de accion: " . $this->request->action , 'debug');
        //$this->log("ID usuario: " . $user['idusuario'], 'debug');
        // The owner of a post can edit and delete it
        if (in_array($this->request->action, array('edit', 'delete'))) {            
            $postId = (int) $this->request->getParam('pass')[0];
            if ($this->Producto->find('propietario', ['usuario' => $user, 'post' => $this->request->getParam('pass')[0]])) {
                return true;
            } else {
                return false;
            }
        }

        return parent::isAuthorized($user);
    }    

}