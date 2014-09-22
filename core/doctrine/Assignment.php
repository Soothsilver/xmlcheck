<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Assignment
 * @ORM\Table(name="assignments", indexes={@ORM\Index(name="groupId", columns={"groupId"}), @ORM\Index(name="problemId", columns={"problemId"})})
 * @ORM\Entity
 */
class Assignment
{
    /**
     * @var Problem
     * @ORM\ManyToOne(targetEntity="Problem")
     * @ORM\JoinColumn(name="problemId", referencedColumnName="id")
     */
    private $problem;
    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="groupId", referencedColumnName="id")
     */
    private $group;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime", nullable=false)
     */
    private $deadline = 'CURRENT_TIMESTAMP';
    /**
     * @var integer
     *
     * @ORM\Column(name="reward", type="integer", nullable=false)
     */
    private $reward;
    /**
     * @var integer
     *
     * @ORM\Column(name="groupId", type="integer", nullable=false)
     */
    private $groupid;
    /**
     * @var integer
     *
     * @ORM\Column(name="problemId", type="integer", nullable=false)
     */
    private $problemid;
    /**
     * @var boolean
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;
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
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Assignments
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }
    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set reward
     *
     * @param integer $reward
     * @return Assignments
     */
    public function setReward($reward)
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * Get reward
     *
     * @return integer 
     */
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * Set groupid
     *
     * @param integer $groupid
     * @return Assignments
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;

        return $this;
    }

    /**
     * Get groupid
     *
     * @return integer 
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * Set problemid
     *
     * @param integer $problemid
     * @return Assignments
     */
    public function setProblemid($problemid)
    {
        $this->problemid = $problemid;

        return $this;
    }

    /**
     * Get problemid
     *
     * @return integer 
     */
    public function getProblemid()
    {
        return $this->problemid;
    }

    /**
     * Set problem
     *
     * @param \Problem $problem
     * @return Assignment
     */
    public function setProblem(\Problem $problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem
     *
     * @return \Problem 
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * Set group
     *
     * @param \Group $problem
     * @return Assignment
     */
    public function setGroup(\Group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Assignment
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
}
