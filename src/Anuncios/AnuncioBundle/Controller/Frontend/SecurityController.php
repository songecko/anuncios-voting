<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
						$userid = $result->userID;
						$name = $result->name;
						$surname = $result->surname;
						
						$user = $this->getDoctrine()
							->getRepository('AnunciosAnuncioBundle:User')
							->findOneByUserId($userid);
						
						if(!$user)
						{
							$user = new User();
							
						}
						
						
					}
				}
			}
		}
		return $this->render('AnunciosAnuncioBundle:/Frontend/Security:login.html.twig', array('error' => $error, 'message' => $message));
    }
}
