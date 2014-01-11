<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Controller
{
	public function loginAction()
	{
		date_default_timezone_set('America/Los_Angeles');
		
		$error = false;
		$message = "Se produjo un error al iniciar sesion";
		
		if(isset($_POST['send']))
		{
			$client = new \nusoap_client('http://wspremios.anuncios.com/SingleSingOn.asmx?WSDL', true);
			
			//En el proyecto indicar al usuario que hubo un problema
			$err = $client->getError();
			if ($err) 
			{
				$error = true;
			}
			
			//Configuracion SOAP
			$client->setUseCurl(true);
			$client->setCredentials("wspremios", "v01KxO17my5WgaCiYxpD", 'ntlm');
			//$client->useHTTPPersistentConnection();
			//$client->setCurlOption(CURLOPT_USERPWD, 'wspremios:v01KxO17my5WgaCiYxpD');
			$client->loadWSDL();
			$result = $client->call('JsonDoLogin', array(
					'email' => $_POST['username'],
					'passMD5' => md5($_POST['password']),
					'serviceID' => 'becht34p'
			));
			
			//En el proyecto indicar al usuario que hubo un problema
			if ($client->fault) 
			{
				$error = true;
			} 
			else
			{
				// Check for errors
				$err = $client->getError();
				if ($err) 
				{
					$error = true;
				}
				else
				{
					//En el proyecto, parsear la respuesta e indicar al usuario si es correcto o no
					$result = json_decode($result['JsonDoLoginResult']);
					if($result->result == 'KO')
					{
						$error = true;
						$message = "Usuario o contraseña invalida";
					}
					else
					{
						$userId = $result->userID;
						$name = $result->Name;
						$surname = $result->Surname;
						
						$user = $this->getDoctrine()
							->getRepository('AnunciosAnuncioBundle:User')
							->findOneByUserId($userId);
						
						if(!$user)
						{
							$user = new User();
							$user->setUserId($userId);
							$user->setName($name);
							$user->setSurname($surname);
							$user->setUsername($_POST['username']);
							$user->setEmail($_POST['username']);
							$user->setPlainPassword($_POST['password']);
							$user->setEnabled(true);
							$user->setRoles(array('ROLE_USER'));
							
							$manager = $this->getDoctrine()->getManager();
							$manager->persist($user);
							$manager->flush();
						}
						
						$providerKey = 'main';
						$roles = $user->getRoles();
						$securityContext = $this->get('security.context');
						$token = new UsernamePasswordToken($user, null, $providerKey, $roles);

						$securityContext->setToken($token);
						
						$request = $this->get("request");
						$event = new InteractiveLoginEvent($request, $token);
						$this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
						
						return $this->redirect($this->generateUrl('anuncios_anuncio_index'));
					}
				}
			}
		}
		return $this->render('AnunciosAnuncioBundle:/Frontend/Security:login.html.twig', array('error' => $error, 'message' => $message));
    }
}
