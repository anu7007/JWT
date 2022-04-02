<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AdduserController extends Controller
{
    // public function indexAction()
    // {
    // }
    public function indexAction()
    {
        if ($this->request->ispost()) {

            $postdata = $this->request->getPost();

            $adduser = new Adduser();
            $this->view->adduser = Adduser::find();

            $postdata = $this->request->getPost();
            $adduser->assign(
                $postdata,
                [
                    'username',
                    'email',
                    'password',
                    'role'
                ]
            );

            if (
                empty($postdata['username']) || empty($postdata['email']) ||
                empty($postdata['password']) || $postdata['role'] == "0"
            ) {
                $this->view->adderror = $this->locale->_('*Please fill all fields!!') . '<br>';
                // $this->response->redirect('/adduser');
            } else {
                $key = "example_key";
                $payload = array(
                    "iss" => "http://example.org",
                    "aud" => "http://example.com",
                    "iat" => 1356999524,
                    "nbf" => 1357000000,
                    "role" => $postdata['role']
                );
                $jwt = JWT::encode($payload, $key, 'HS256');
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
               
                // $signer  = new Hmac();

                // // Builder object
                // $builder = new Builder($signer);

                // $now        = new DateTimeImmutable();
                // $issued     = $now->getTimestamp();
                // $notBefore  = $now->modify('-1 minute')->getTimestamp();
                // $expires    = $now->modify('+1 day')->getTimestamp();
                // $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';
                // $id = 1;
                // // Setup
                // $builder
                //     ->setAudience('https://target.phalcon.io')  // aud
                //     ->setContentType('application/json')        // cty - header
                //     ->setExpirationTime($expires)               // exp 
                //     ->setId($id++)                    // JTI id 
                //     ->setIssuedAt($issued)                      // iat 
                //     ->setIssuer('https://phalcon.io')           // iss 
                //     ->setNotBefore($notBefore)                  // nbf
                //     ->setSubject($postdata['role'])   // sub
                //     ->setPassphrase($passphrase)                // password 
                // ;

                // // Phalcon\Security\JWT\Token\Token object
                // $tokenObject = $builder->getToken();

                // // The token
                // echo $token = $tokenObject->getToken();
                $adduser->token = $jwt;
                
                $success = $adduser->save();
                if ($success) {
                    $this->view->success = $success;
                    $this->view->adderror = $this->locale->_('*User Added Successfully!!') . '<br>';
                    // $this->view->token = $token;
                }
            }
        }
    }
}
