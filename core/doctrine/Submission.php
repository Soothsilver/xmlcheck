<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Submission
 *
 * @ORM\Table(name="submissions", indexes={@ORM\Index(name="assignmentId", columns={"assignmentId"}), @ORM\Index(name="userId", columns={"userId"})})
 * @ORM\Entity
 */
class Submission
{
    const STATUS_BEING_EVALUATED = "new";
    const STATUS_NORMAL = "normal";
    const STATUS_LATEST = "latest";
    const STATUS_REQUESTING_GRADING = "handsoff";
    const STATUS_GRADED = "graded";
    const STATUS_DELETED = "deleted";

    /**
     * @return Assignment
     */
    public function getAssignment()
    {
        return $this->assignment;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Assignment")
     * @ORM\JoinColumn(name="assignmentId", referencedColumnName="id")
     */
    private $assignment;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="assignmentId", type="integer", nullable=false)
     */
    private $assignmentid;

    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="submissionFile", type="string", length=100, nullable=false)
     */
    private $submissionfile = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status = self::STATUS_BEING_EVALUATED;

    /**
     * @var integer
     *
     * @ORM\Column(name="success", type="integer", nullable=false)
     */
    private $success = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=false)
     */
    private $info = '';

    /**
     * @var string
     *
     * @ORM\Column(name="outputFile", type="string", length=100, nullable=false)
     */
    private $outputfile = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="explanation", type="text", nullable=false)
     */
    private $explanation = '';



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
     * Set assignmentid
     *
     * @param integer $assignmentid
     * @return Submissions
     */
    public function setAssignmentid($assignmentid)
    {
        $this->assignmentid = $assignmentid;

        return $this;
    }

    /**
     * Get assignmentid
     *
     * @return integer 
     */
    public function getAssignmentid()
    {
        return $this->assignmentid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Submissions
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set submissionfile
     *
     * @param string $submissionfile
     * @return Submissions
     */
    public function setSubmissionfile($submissionfile)
    {
        $this->submissionfile = $submissionfile;

        return $this;
    }

    /**
     * Get submissionfile
     *
     * @return string 
     */
    public function getSubmissionfile()
    {
        return $this->submissionfile;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Submissions
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Submissions
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set success
     *
     * @param integer $success
     * @return Submissions
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get success
     *
     * @return integer
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return Submissions
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set outputfile
     *
     * @param string $outputfile
     * @return Submissions
     */
    public function setOutputfile($outputfile)
    {
        $this->outputfile = $outputfile;

        return $this;
    }

    /**
     * Get outputfile
     *
     * @return string 
     */
    public function getOutputfile()
    {
        return $this->outputfile;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Submissions
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set explanation
     *
     * @param string $explanation
     * @return Submissions
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * Get explanation
     *
     * @return string 
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * Set assignment
     *
     * @param \Assignment $assignment
     * @return Submissions
     */
    public function setAssignment(\Assignment $assignment = null)
    {
        $this->assignment = $assignment;

        return $this;
    }

    /**
     * Set user
     *
     * @param \User $user
     * @return Submission
     */
    public function setUser(\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
