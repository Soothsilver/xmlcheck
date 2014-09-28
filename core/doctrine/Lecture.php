<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Lecture
 *
 * @ORM\Table(name="lectures", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="ownerId", columns={"ownerId"})})
 * @ORM\Entity
 */
class Lecture
{
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="id")
     */
    private $owner;
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
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ownerId", type="integer", nullable=false)
     */
    private $ownerid;

    /**
     * @var boolean
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @var Group[]
     * @ORM\OneToMany(targetEntity="Group", mappedBy="lecture")
     */
    private $groups;


    /**
     * @var Problem[]
     * @ORM\OneToMany(targetEntity="Problem", mappedBy="lecture")
     */
    private $problems;


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
     * @return Lectures
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
     * Set description
     *
     * @param string $description
     * @return Lectures
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ownerid
     *
     * @param integer $ownerid
     * @return Lectures
     */
    public function setOwnerid($ownerid)
    {
        $this->ownerid = $ownerid;

        return $this;
    }

    /**
     * Get ownerid
     *
     * @return integer 
     */
    public function getOwnerid()
    {
        return $this->ownerid;
    }

    /**
     * Set owner
     *
     * @param \User $owner
     * @return Lecture
     */
    public function setOwner(\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Lecture
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
     * Constructor
     */
    public function __construct()
    {
        $this->problems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add problems
     *
     * @param \Problem $problems
     * @return Lecture
     */
    public function addProblem(\Problem $problems)
    {
        $this->problems[] = $problems;

        return $this;
    }

    /**
     * Remove problems
     *
     * @param \Problem $problems
     */
    public function removeProblem(\Problem $problems)
    {
        $this->problems->removeElement($problems);
    }

    /**
     * Get problems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProblems()
    {
        return $this->problems;
    }

    /**
     * Add groups
     *
     * @param \Group $groups
     * @return Lecture
     */
    public function addGroup(\Group $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Group $groups
     */
    public function removeGroup(\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
