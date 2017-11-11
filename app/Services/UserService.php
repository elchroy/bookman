<?php

namespace App\Services;

use App\Models\V1\User;
use App\Services\MainService;
use App\Repositories\V1\UserRepository;

class UserService extends MainService {

	/**
	 * Subscription was successful
	 */
	const SUBSCRIPTION_SUCCESSFUL = "Subscription successful. Ensure to copy and store the generated token.";

	/**
	 * User profile was successfully updated.
	 */
	const UPDATE_PROFILE_SUCCESSFUL = "Profile updated successful. Ensure to copy and store the generated token.";

	/**
	 * Account with given email address does not exist
	 */
	const UNAVAILABLE_ACCOUNT_WITH_EMAIL = "Account with provided email address does not exist";

	/**
	 * Token provided is invalie, does not match email.
	 */
	const INVALID_TOKEN = "Invalid Token. Please enter your subscription token.";

	/**
	 * Allows users to subscirbe to the service with their email address
	 * @param string $email Email address for subscription.
	 * @return Optional array or null
	 */
	public function Subscribe (string $email) : ?array {
		
		$token = $this->generateHash($email);
		
		return ($user = UserRepository::createUser($email, $token))
		? $this->genEmailTokenResponse($user, $token, self::SUBSCRIPTION_SUCCESSFUL)
		: null;
	}

	/**
	 * Allows users to update their account
	 * @param string $oldEmail Old email to be updated
	 * @param string $newEmail New email as update
	 * @param string $token Token tied to old email address
	 * @return  array.
	 */
	public function UpdateProfile (string $oldEmail, string $newEmail, string $token) {
		if ( $user = UserRepository::findUserByEmail($oldEmail) ) {
			if ( $this->tokenIsValid($user, $token) ) {
				$newToken = $this->generateHash($newEmail);
				$user = UserRepository::updateUser($user, $newEmail, $newToken);
				return $this->genEmailTokenResponse($user, $newToken, self::UPDATE_PROFILE_SUCCESSFUL);
			} else {
				return $this->getInvalidTokenResponse($token);
			}
		} else {
			return $this->getUnavailableAccountWithEmailResponse($oldEmail);
		}
	}

	/**
	 * Checks to see if email hash matches token
	 * @param  User   $user  User with email property
	 * @param  string $token provided token
	 * @return [bool]
	 */
    private function tokenIsValid (User $user, string $token) : bool {
        return $this->generateHash($user->email) == $token;
    }

    /**
     * Response for Invalid token
     * @param  string $token Invalid token
     * @return [array
     */
    private function getInvalidTokenResponse (string $token) : array {
    	return [
    		'token' => $token,
    		'message' => self::INVALID_TOKEN
    	];
    }

    /**
     * Response for Unavailable email address
     * @param  string Email to check
     * @return [array]
     */
    private function getUnavailableAccountWithEmailResponse (string $email) : array {
    	return [
    		'email' => $email,
    		'message' => self::UNAVAILABLE_ACCOUNT_WITH_EMAIL
    	];
    }

    /**
     * Response for email and generated token
     * @param  User   $user  
     * @param  string $token   
     * @param  string $message
     * @return [array]  
     */
    public function genEmailTokenResponse (User $user, string $token, string $message) : array {
		return [
			"email" => $user->email,
			"token" => $token,
			"message" => $message
		];
    }
}