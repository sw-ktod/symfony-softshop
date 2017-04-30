<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements AdvancedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     */
    private $password_raw;

    /**
     * @var string
     */
    private $password_current;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     * @ORM\Column(name="date_of_birth", type="date")
     */
    private $date_of_birth;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var bool
     * @ORM\Column(name="is_banned", type="boolean")
     */
    private $is_banned;

    /**
     * @var int
     */
    private $customer_account_id;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role", inversedBy="users")
     * @JoinTable("user_role")
     *
     */
    private $roles;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }

    public function addRole($role) {
        array_push($this->roles, $role);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function getPasswordRaw()
    {
        return $this->password_raw;
    }

    /**
     * @param string $password_raw
     */
    public function setPasswordRaw($password_raw)
    {
        $this->password_raw = $password_raw;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param string $date_of_birth
     * @return $this
     */
    public function setDateOfBirth($date_of_birth)
    {
        $this->date_of_birth = $date_of_birth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsBanned()
    {
        return $this->is_banned;
    }

    /**
     * @param $is_banned
     * @return $this
     */
    public function setIsBanned($is_banned)
    {
        $this->is_banned = $is_banned;

        return $this;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerAccountId()
    {
        return $this->customer_account_id;
    }

    /**
     * @param $customer_account_id
     * @return $this
     */
    public function setCustomerAccountId($customer_account_id)
    {
        $this->customer_account_id = $customer_account_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordCurrent()
    {
        return $this->password_current;
    }

    /**
     * @param string $password_current
     * @return $this
     */
    public function setPasswordCurrent($password_current)
    {
        $this->password_current = $password_current;

        return $this;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
}

