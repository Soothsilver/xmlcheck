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
     * @var \UserType
     * @ORM\ManyToOne(targetEntity="UserType")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
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
    private $lastaccess;

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
     * @var  boolean
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     * */
    private $deleted = false;

    /**
     * @var Group[]
     * @ORM\OneToMany(targetEntity="Group", mappedBy="owner")
     */
    private $groups;
    /**
     * @var Lecture[]
     * @ORM\OneToMany(targetEntity="Lecture", mappedBy="owner")
     */
    private $lectures;
    /**
     * @var Submission[]
     * @ORM\OneToMany(targetEntity="Submission", mappedBy="user")
     */
    private $submissions;


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

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return User
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set type
     *
     * @param \UserType $type
     * @return User
     */
    public function setType(\UserType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \UserType
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lectures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->submissions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lastaccess = new DateTime();
    }

    /**
     * Add groups
     *
     * @param \Group $group
     * @return User
     */
    public function addGroup(\Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Group $group
     */
    public function removeGroup(\Group $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add lecture
     *
     * @param \Lecture $lectures
     * @return User
     */
    public function addLecture(\Lecture $lecture)
    {
        $this->lectures[] = $lectures;

        return $this;
    }

    /**
     * Remove lecture
     *
     * @param \Lecture $lecture
     */
    public function removeLecture(\Lecture $lecture)
    {
        $this->lectures->removeElement($lecture);
    }

    /**
     * Get lectures
     *
     * @return Lecture[]
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * Add submission
     *
     * @param \Submission $submission
     * @return User
     */
    public function addSubmission(\Submission $submission)
    {
        $this->submissions[] = $submission;

        return $this;
    }

    /**
     * Remove submission
     *
     * @param \Submission $submission
     */
    public function removeSubmission(\Submission $submission)
    {
        $this->submissions->removeElement($submission);
    }

    /**
     * Get submissions
     *
     * @return Submission[]
     */
    public function getSubmissions()
    {
        return $this->submissions;
    }
}
