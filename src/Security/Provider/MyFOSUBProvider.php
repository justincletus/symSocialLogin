<?php

namespace App\Security\Provider;

use Doctrine\Bundle\DoctrineBundle\Registry;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use App\Entity\User;

/**
 * MyFOSUBProviders
 */
class MyFOSUBProvider extends FOSUBUserProvider
{
	
	private $doctrine;


	/***
	* @param UserManagerInterface $userManager
	* @param array $properties
	* @param Registry $doctrine
	*/
	function __construct(UserManagerInterface $userManager, array $properties, $doctrine)
	{
		parent::__construct($userManager, $properties);
		$this->doctrine = $doctrine;

	}


	/**
	* {@inheritdoc}
	*
	*/
	public function loadUserByOAuthUserResponse(UserResponseInterface $response)
	{
		$username = $response->getUsername();
		$property = $this->getProperty($response);

		$user = $this->userManager->findUserBy(array($thi->getProperty($response) => $username));
		$email = $response->getEmail();

		$existing = $this->userManager->findUserBy(array('email' => $email));

		if ($existing instanceof User) {
			if ($property == "facebookId") {
				$existing->setFacebookId($username);
			}
			if($property == "googleId"){
				$existing->setGoogleId($username);
			}
			$this->userManager->updateUser($existing);

			return $existing;
		}

		if (null === $user || null === $username) {
			$user = $this->userManager->createUser();
			$nick = "Justin bai";
			$user->setLastLogin(new \DateTime());
			$user->setEnabled(true);

			$user->setUsername($nick);
			$user->setUsernameCanonical($nick);
			$user->setPassword(sha1(uniqid()));
			$user->addRole('ROLE_USER');

			if ($property == "facebookId") {
				$user->setFacebookId($username);
			}
			if ($property == "googleId") {
				$user->setGoogleId($username);
			}
		}

		$user->setEmail($response->getEmail());
		$user->setFirstname($response->getFirstName());
		$user->setLastname($response->getLastName());
		$this->userManager->updateUser($user);

		return $user;


	}
}