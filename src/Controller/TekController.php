<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class TekController extends AppController
{
    public function initialize(){
        parent::initialize();
    }

    public function index()
    {            
        $this->set('activo', 'navTek');
    }

    public function view($idtek = null)
    {
        $this->set('activo', 'navTek');
        $tek = $this->Tek->get($idtek);
        $this->set('tek', $tek);
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        $categoria = $tabla_categorias_tek->get($tek->categoria_tek_idcategoria_tek)->nombre;
        $this->set('categoria', $categoria);
        //recopilar y almacenar medios para mostrar
        $medios = array();     
        $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'tek/' . $idtek . '/';
        $temp = $this->Tek->newEntity();
        $temp->ruta = $dir . $tek->imagen;
        $temp->descripcion = "Imagen de portada para tek: " . $tek->nombre; 
        array_push($medios, $temp);           
        $tabla_multimedia = TableRegistry::get('Multimedia');
        $tabla_tekhasmultimedia = TableRegistry::get('TekHasMultimedia');   
        $relacion_medios = $tabla_tekhasmultimedia->find('all')->where(['tek_idtek = ' => $tek->idtek]);
        foreach ($relacion_medios as $rel){
            $multimedia = $tabla_multimedia->get($rel->multimedia_idmultimedia);
            if (!empty($multimedia)){
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
        $this->Auth->allow(['listatek', 'medios', 'listacategorias']);
    }      

    public function listatek(){
        $tek = $this->Tek->find('all', array('order' => 'modified DESC'));
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek');
        foreach ($tek as $row){
            $ruta = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $row->idtek . '/' . $row->imagen;
            $row->imagen = array('enlace' => $row->imagen, 'id' => $row->idtek, 'existe' => file_exists($ruta));
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
        $this->set('activo', 'navTek');
        $tek = $this->Tek->newEntity(); 
        $tabla_categorias_tek = TableRegistry::get('CategoriaTek'); 
        $categorias = $tabla_categorias_tek->find('list');      
        $this->set('categorias', $categorias);
        if ($this->request->is(['post', 'put'])) {      
            if (!empty($this->request->getData())) {      
                $tek->usuario_comunidad_idcomunidad = "1";
                $tek->usuario_idusuario = $this->Auth->user('idusuario');            
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0];               
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1);                 
                    $tek->imagen = "portada." . $ext;
                }
                $this->Tek->patchEntity($tek, $this->request->getData());
                if ($this->Tek->save($tek)) {
                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0];
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                        if(in_array($ext, $arr_ext))
                        {
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $tek->idtek . '/' . DS;
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this -> Flash -> error(__('Image could not be saved. Please, try again.'));
                            } else {                            
                                $this->Flash->error(__('Archivo subido'));
                            }
                        } else {
                            $this->Flash->error(__('Extension no valida'));                 
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
                    $file = $this->request->getData()['image_path'][0];               
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1);                   
                    $tek->imagen = "portada." . $ext;
                }                
                $this->Tek->patchEntity($tek, $this->request->getData());
                if ($this->Tek->save($tek)) {
                    if(!empty($this->request->getData()['image_path'][0]['name']))
                    {
                        $file = $this->request->getData()['image_path'][0];
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                        if(in_array($ext, $arr_ext))
                        {
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $tek->idtek . '/' . DS;
                            mkdir($dir, 0755, true);
                            array_map('unlink', glob($dir . "portada.*"));                        
                            if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                            {
                                $this->Flash->error(__('Image could not be saved. Please, try again.'));
                            } else {                            
                                $this->Flash->error(__('Archivo subido'));
                                return $this->redirect(['action' => 'view/' . $tek->idtek]);
                            }
                        } else {
                            $this->Flash->error(__('Extension no valida'));
                            return $this->redirect(['action' => 'view/' . $tek->idtek]);                  
                        }
                    } 
                    //cargar medios multimedia xd
                    if(!empty($this->request->getData()['multimedia']) && count($this->request->getData()['multimedia']) > 0){
                        $tabla_multimedia = TableRegistry::get('Multimedia');
                        $tabla_tekhasmultimedia = TableRegistry::get('TekHasMultimedia');
                        foreach ($this->request->getData()['multimedia'] as $adjunto){
                            $multimedia = $tabla_multimedia->newEntity(); 
                            $enlace = $tabla_tekhasmultimedia->newEntity(); 
                            $ext = substr(strtolower(strrchr($adjunto['name'], '.')), 1);
                            $multimedia->enlace = $adjunto['name'];
                            $multimedia->formato = $ext;
                            if ($tabla_multimedia->save($multimedia)){
                                $enlace->tek_idtek = $tek->idtek;
                                $enlace->tek_usuario_idusuario = $tek->usuario_idusuario;
                                $enlace->tek_usuario_comunidad_idcomunidad = 1;
                                $enlace->tek_categoria_tek_idcategoria_tek = $tek->categoria_tek_idcategoria_tek;
                                $enlace->multimedia_idmultimedia = $multimedia->idmultimedia;
                                $tabla_tekhasmultimedia->save($enlace);
                                //copiar archivo temporal
                                $file = $adjunto;
                                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                                if(in_array($ext, $arr_ext))
                                {
                                    $dir = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $tek->idtek . '/' . DS;
                                    mkdir($dir, 0755, true);                       
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
                    $this->Flash->success(__('TEK actualizado.'));
                    return $this->redirect(['action' => 'edit/' . $tek->idtek]);
                } else {
                    $this->Flash->error(__('Error al actualizar TEK.'));
                    return $this->redirect(['action' => 'edit/' . $tek->idtek]);
                }
            }
        }           
        $this->set('tek', $tek);  
        //recopilar y almacenar medios para mostrar
        $medios = array();     
        $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'tek/' . $idtek . '/';         
        $tabla_multimedia = TableRegistry::get('Multimedia');
        $tabla_tekhasmultimedia = TableRegistry::get('TekHasMultimedia');   
        $relacion_medios = $tabla_tekhasmultimedia->find('all')->where(['tek_idtek = ' => $tek->idtek]);
        foreach ($relacion_medios as $rel){
            $multimedia = $tabla_multimedia->get($rel->multimedia_idmultimedia);
            if (!empty($multimedia)){
                $multimedia->ruta = $dir . $multimedia->enlace;
                array_push($medios, $multimedia);
            }
        }
        $this->set('medios', $medios);        
        $this->set('editar', true);            
    } 

    public function editmedios($idmultimedia = null){
        if ($this->request->is(['post', 'put'])) {
            if (!empty($this->request->getData())) {
                $tabla_multimedia = TableRegistry::get('Multimedia');
                $tabla_tekhasmultimedia = TableRegistry::get('TekHasMultimedia');                
                $multimedia = $tabla_multimedia->get($idmultimedia);
                $relacion_medios = $tabla_tekhasmultimedia->find('all')->where(['multimedia_idmultimedia = ' => $idmultimedia]);
                $idtek = '';
                foreach ($relacion_medios as $rel){
                    $idtek = $rel->tek_idtek;
                }
                $tabla_multimedia->patchEntity($multimedia, $this->request->getData());
                if ($tabla_multimedia->save($multimedia)) {
                    $this->Flash->success(__('Multimedia actualizado'));
                } else {
                    $this->Flash->success(__('Error al actualizar multimedia'));
                }
                return $this->redirect(['action' => 'edit/' . $idtek]);
            }
        }
    }
    
    public function medios($idtek = null){
        if ($idtek != null){
            $tek = $this->Tek->get($idtek);
            $medios = array();     
            $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'tek/' . $idtek . '/';
            $temp = new \stdClass();
            $temp->image = array("src" => $dir . $tek->imagen, "poster" => $dir . $tek->imagen);
            array_push($medios, $temp);           
            $tabla_multimedia = TableRegistry::get('Multimedia');
            $tabla_tekhasmultimedia = TableRegistry::get('TekHasMultimedia');   
            $relacion_medios = $tabla_tekhasmultimedia->find('all')->where(['tek_idtek = ' => $tek->idtek]);
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

    public function elimmedios($idmedio = null){
        if ($idmedio != null){
            if ($this->request->is(['post', 'put'])) {
                $tabla_multimedia = TableRegistry::get('Multimedia');
                $tabla_tekhasmultimedia = TableRegistry::get('TekHasMultimedia');   
                $relacion_medios = $tabla_tekhasmultimedia->find('all')->where(['multimedia_idmultimedia = ' => $idmedio]);
                foreach ($relacion_medios as $instancia){
                    $idtek = $instancia->tek_idtek;
                    $result = $tabla_tekhasmultimedia->delete($instancia);
                    if ($result){
                        $multimedia = $tabla_multimedia->get($idmedio);
                        $archivo = $multimedia->enlace;
                        $resultmult = $tabla_multimedia->delete($multimedia);
                        if ($resultmult){
                            $dir = WWW_ROOT . 'uploads/' . 'files/' . 'tek/' . $idtek . '/' . DS;
                            array_map('unlink', glob($dir . $archivo)); 
                            $this->Flash->success(__('Multimedia eliminado: ' . $archivo));
                        } else {
                            $this->Flash->error(__('Error al eliminar instancia multimedia'));
                        }
                    } else {
                        $this->Flash->error(__('Error al eliminar referencia multimedia'));
                    }
                }         
                return $this->redirect(['action' => 'edit/' . $idtek]);   
            }
        } else {
            return $this->redirect(['action' => 'index']);   
        }        
    }

    public function isAuthorized($user) {
        if ($this->request->action === 'add') {
            return true;
        }
        $this->log("ID post para editar TEK: " . $this->request->getParam('pass')[0] , 'debug');
        $this->log("Tipo de accion: " . $this->request->action , 'debug');
        $this->log("ID usuario: " . $user['idusuario'], 'debug');
        if (in_array($this->request->action, array('edit', 'delete'))) {            
            $postId = (int) $this->request->getParam('pass')[0];
            if ($this->Tek->find('propietario', ['usuario' => $user, 'post' => $this->request->getParam('pass')[0]])) {
                return true;
            } else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }     
}
?>