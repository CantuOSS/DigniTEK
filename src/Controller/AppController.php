<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
ob_start();
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'Pages', // @todo Mi Controller segun PROYECTO a modo de demo
                'action' => 'display',
                'home'
            ],
            'logoutRedirect' => [
                'controller' => 'Usuario', // @todo Mi Controller segun PROYECTO
                'action' => 'login'
            ],
            'loginAction' => [
                'controller' => 'Usuario', // @todo Mi Controller segun PROYECTO
                'action' => 'login'
            ],
            'authenticate' => [
                'Form' => [
                    //'passwordHasher' => 'Blowfish',
                    'userModel' => 'Usuario'
                                              // @todo Filtro para bloquiar ingresos de usuarios activos segun DB
                ]
            ],
            'authError' => 'Por favor inicie sesion para continuar',
            'storage' => 'Session'
        ]);

        $usuarioauth = $this->Auth->user('idusuario');
        $nombreusuarioauth = $this->Auth->user('nombre');
        //$this->log('id usuario autentificado: ' . $usuarioauth,'debug');   
        $this->set('idusuario_nav', $usuarioauth);     
        $this->set('nombreusuario_nav', $nombreusuarioauth);           

        $tabla_comunidad = TableRegistry::get('Comunidad');
        $comunidad = $tabla_comunidad->get(1);
        $this->set('titulo', $comunidad->nombre);   
        $this->set('descripcion_comunidad', $comunidad->descripcion);  

    }

    public function beforeFilter(Event $event)
    {            
        $this->Auth->allow(['index', 'display']);
    }    

    public function isAuthorized($user) {
        // Admin can access every action
        if (in_array($this->request->action, array('edit', 'delete', 'add'))) {
            if (isset($user['rol']) && in_array($user['rol'], array('coordinador', 'contribuidor'))) {
                return true;
            }
        
            // Default deny
            return false;
        } else {
            return true;
        }
    }    
}
