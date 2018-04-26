<?php
namespace App\Controller;
use Cake\Event\Event;

class ComunidadController extends AppController
{
    public function initialize(){
        parent::initialize();        
    }

    public function index()
    {        
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
                if(!empty($this->request->getData()['image_path'][0]['name']))
                {
                    $file = $this->request->getData()['image_path'][0];
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($ext, $arr_ext))
                    {
                        $dir = WWW_ROOT . 'uploads/' . 'files/' . 'comunidad/' . DS; //<!-- app/webroot/img/
                        mkdir($dir, 0755, true);
                        array_map('unlink', glob($dir . "portada.*"));                        
                        if(!move_uploaded_file($file['tmp_name'], $dir . "portada." . $ext)) 
                        {
                            $this->Flash->error(__('Image could not be saved. Please, try again.'));
                        } else {
                            $comunidad->imagen = "portada." . $ext;
                            $this->Flash->error(__('Archivo subido'));
                        }

                    } else {
                        $this->Flash->error(__('Extension no valida'));                   
                    }
                }                

                $this->Comunidad->patchEntity($comunidad, $this->request->getData());
                if ($this->Comunidad->save($comunidad)) {
                    $this->Flash->success(__('Datos de la comunidad actualizados.'));   
                    return $this->redirect(['action' => 'index']);                 
                }
                else {

                }
            }
        } else {            
            $this->set('comunidad', $comunidad);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['medios']);
    }     

    public function medios(){
        $comunidad = $this->Comunidad->get(1);
        $medios = array();     
        $dir = '/DigniTEK/' . 'uploads/' . 'files/' . 'comunidad/';
        $temp = new \stdClass();
        $temp->image = array("src" => $dir . $comunidad->imagen, "poster" => $dir . $comunidad->imagen);
        array_push($medios, $temp);                   
        $responseResult = json_encode($medios);
        $this->response->type('json');
        $this->response->body($responseResult);
        return $this->response;        
    }    

    public function isAuthorized($user) {
        return true;
    }       
}
?>