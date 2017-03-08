<?php
/**
 * Created by PhpStorm.
 * User: jrojo
 * Date: 3/03/17
 * Time: 11:42
 */

namespace AppBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

class User extends BaseUser
{
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
