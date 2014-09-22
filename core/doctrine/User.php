<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="type", columns={"type"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=255, nullable=false)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="realName", type="string", length=30, nullable=false)
     */
    private $realname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastAccess", type="datetime", nullable=false)
     */
    private $lastaccess = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="activationCode", type="string", length=32, nullable=false)
     */
    private $activationcode;

    /**
     * @var string
     *
     * @ORM\Column(name="encryptionType", type="string", length=255, nullable=false)
     */
    private $encryptiontype = 'md5';

    /**
     * @var string
     *
     * @ORM\Column(name="resetLink", type="string", length=255, nullable=true)
     */
    private $resetlink;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="resetLinkExpiry", type="datetime", nullable=true)
     */
    private $resetlinkexpiry;
    /**
     * @var boolean
     *
     * @ORM\Column(name="send_email_on_submission_rated", type="boolean", nullable=false)
     */
    private $sendEmailOnSubmissionRated = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="send_email_on_new_assignment", type="boolean", nullable=false)
     */
    private $sendEmailOnNewAssignment = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="send_email_on_new_submission", type="boolean", nullable=false)
     */
    private $sendEmailOnNewSubmission = '1';


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Users
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return Users
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return Users
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
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
     * Set lastaccess
     *
     * @param \DateTime $lastaccess
     * @return Users
     */
    public function setLastaccess($lastaccess)
    {
        $this->lastaccess = $lastaccess;

        return $this;
    }

    /**
     * Get lastaccess
     *
     * @return \DateTime 
     */
    public function getLastaccess()
    {
        return $this->lastaccess;
    }

    /**
     * Set activationcode
     *
     * @param string $activationcode
     * @return Users
     */
    public function setActivationcode($activationcode)
    {
        $this->activationcode = $activationcode;

        return $this;
    }

    /**
     * Get activationcode
     *
     * @return string 
     */
    public function getActivationcode()
    {
        return $this->activationcode;
    }

    /**
     * Set encryptiontype
     *
     * @param string $encryptiontype
     * @return Users
     */
    public function setEncryptiontype($encryptiontype)
    {
        $this->encryptiontype = $encryptiontype;

        return $this;
    }

    /**
     * Get encryptiontype
     *
     * @return string 
     */
    public function getEncryptiontype()
    {
        return $this->encryptiontype;
    }

    /**
     * Set resetlink
     *
     * @param string $resetlink
     * @return Users
     */
    public function setResetlink($resetlink)
    {
        $this->resetlink = $resetlink;

        return $this;
    }

    /**
     * Get resetlink
     *
     * @return string 
     */
    public function getResetlink()
    {
        return $this->resetlink;
    }

    /**
     * Set resetlinkexpiry
     *
     * @param \DateTime $resetlinkexpiry
     * @return Users
     */
    public function setResetlinkexpiry($resetlinkexpiry)
    {
        $this->resetlinkexpiry = $resetlinkexpiry;

        return $this;
    }

    /**
     * Get resetlinkexpiry
     *
     * @return \DateTime 
     */
    public function getResetlinkexpiry()
    {
        return $this->resetlinkexpiry;
    }

    /**
     * Set sendEmailOnSubmissionRated
     *
     * @param boolean $sendEmailOnSubmissionRated
     * @return User
     */
    public function setSendEmailOnSubmissionRated($sendEmailOnSubmissionRated)
    {
        $this->sendEmailOnSubmissionRated = $sendEmailOnSubmissionRated;

        return $this;
    }

    /**
     * Get sendEmailOnSubmissionRated
     *
     * @return boolean 
     */
    public function getSendEmailOnSubmissionRated()
    {
        return $this->sendEmailOnSubmissionRated;
    }

    /**
     * Set sendEmailOnNewAssignment
     *
     * @param boolean $sendEmailOnNewAssignment
     * @return User
     */
    public function setSendEmailOnNewAssignment($sendEmailOnNewAssignment)
    {
        $this->sendEmailOnNewAssignment = $sendEmailOnNewAssignment;

        return $this;
    }

    /**
     * Get sendEmailOnNewAssignment
     *
     * @return boolean 
     */
    public function getSendEmailOnNewAssignment()
    {
        return $this->sendEmailOnNewAssignment;
    }

    /**
     * Set sendEmailOnNewSubmission
     *
     * @param boolean $sendEmailOnNewSubmission
     * @return User
     */
    public function setSendEmailOnNewSubmission($sendEmailOnNewSubmission)
    {
        $this->sendEmailOnNewSubmission = $sendEmailOnNewSubmission;

        return $this;
    }

    /**
     * Get sendEmailOnNewSubmission
     *
     * @return boolean 
     */
    public function getSendEmailOnNewSubmission()
    {
        return $this->sendEmailOnNewSubmission;
    }
}