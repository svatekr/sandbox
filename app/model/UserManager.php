<?php

namespace App\Model;

use Nette;
use Nette\Security\Passwords;
use Dibi\Connection;


/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{
	use Nette\SmartObject;

	const
		TABLE_NAME = 'users',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'username',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_EMAIL = 'email',
		COLUMN_ROLE = 'role';


	/** @var Connection */
	private $db;


	public function __construct(Connection $db) {
		$this->db = $db;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials) {
		list($username, $password) = $credentials;

    $row = $this->db->select('*')
        ->from(self::TABLE_NAME)
        ->where(self::COLUMN_NAME . ' = %s', $username)
        ->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update([
				self::COLUMN_PASSWORD_HASH => Nette\Security\Passwords::hash($password),
			]);
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);
		return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
	}


	/**
	 * Adds new user.
   * @param $username
   * @param $email
   * @param $password
   * @param string $role
	 * @return void
	 * @throws DuplicateNameException
	 */
  public function add($username, $email, $password, $role = 'guest') {
    try {
          $this->db->insert(self::TABLE_NAME, [
              self::COLUMN_NAME => $username,
              self::COLUMN_EMAIL => $email,
              self::COLUMN_PASSWORD_HASH => Nette\Security\Passwords::hash($password),
              self::COLUMN_ROLE => $role,
          ])->execute();
      } catch (DibiDriverException $e) {
          switch ($e->getCode()) {
              case 1062:
                  throw new DuplicateNameException;
          }
      }
  }
}



class DuplicateNameException extends \Exception
{}
