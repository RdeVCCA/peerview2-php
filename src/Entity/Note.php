<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Repository\NoteRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

enum NoteYear: int
{
    case Sec1 = 1;
    case Sec2 = 2;
    case Sec3 = 3;
    case Sec4 = 4;
    case JC1 = 5;
    case JC2 = 6;
}

enum NoteStatus: string
{
    case Planned = 'Planned';
    case Ongoing = 'Ongoing';
    case Completed = 'Completed';
}

enum NoteSubject: string
{
    case SecCID = 'SecCID';
    case SecArt = 'SecArt';
    case SecAppreciationOfChineseCulture = 'SecAppreciationOfChineseCulture';
    case SecMusic = 'SecMusic';
    case SecDigitalLiteracy = 'SecDigitalLiteracy';
    case SecConversationalMalay = 'SecConversationalMalay';
    case SecFoodAndConsumerEducation = 'SecFoodAndConsumerEducation';
    case SecPhysicalEducation = 'SecPhysicalEducation';
    case SecMathematics = 'SecMathematics';
    case SecBiology = 'SecBiology';
    case SecBiologyTalent = 'SecBiologyTalent';
    case SecChemistry = 'SecChemistry';
    case SecChemistryTalent = 'SecChemistryTalent';
    case SecPhysics = 'SecPhysics';
    case SecPhysicsTalent = 'SecPhysicsTalent';
    case SecComputing = 'SecComputing';
    case SecEnglishLanguage = 'SecEnglishLanguage';
    case SecEnglishLiterature = 'SecEnglishLiterature';
    case SecHigherChineseLanguage = 'SecHigherChineseLanguage';
    case SecChineseLiterature = 'SecChineseLiterature';
    case SecGeography = 'SecGeography';
    case SecHistory = 'SecHistory';
    case SecSingaporeStudies = 'SecSingaporeStudies';
    case SecBiculturalStudies = 'SecBiculturalStudies';
    case JCChinaStudiesInChineseH2 = 'JCChinaStudiesInChineseH2';
    case JCChineseLanguageAndLiteratureH2 = 'JCChineseLanguageAndLiteratureH2';
    case JCEnglishLiteratureH1 = 'JCEnglishLiteratureH1';
    case JCEnglishLiteratureH2 = 'JCEnglishLiteratureH2';
    case JCEconomicsH1 = 'JCEconomicsH1';
    case JCEconomicsH2 = 'JCEconomicsH2';
    case JCGeographyH2 = 'JCGeographyH2';
    case JCHistoryH2 = 'JCHistoryH2';
    case JCTranslationH2 = 'JCTranslationH2';
    case JCBiologyH2 = 'JCBiologyH2';
    case JCComputingH2 = 'JCComputingH2';
    case JCChemistryH1 = 'JCChemistryH1';
    case JCChemistryH2 = 'JCChemistryH2';
    case JCChemistryH3 = 'JCChemistryH3';
    case JCFurtherMathematicsH2 = 'JCFurtherMathematicsH2';
    case JCPhysicsH2 = 'JCPhysicsH2';
    case JCPhysicsH3 = 'JCPhysicsH3';
    case JCMathematicsH1 = 'JCMathematicsH1';
    case JCMathematicsH2 = 'JCMathematicsH2';
    case JCMathematicsH3 = 'JCMathematicsH3';
    case JCGeneralPaperH1 = 'JCGeneralPaperH1';
    case JCMotherTongueH1 = 'JCMotherTongueH1';
    case JCProjectWorkH1 = 'JCProjectWorkH1';
    case OtherSubject = 'OtherSubject';
    case NonAcademic = 'NonAcademic';
}

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\Table(name: 'notes')]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 512)]
    private ?string $link = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $topics = null;

    #[ORM\Column]
    private ?NoteYear $year = null;

    #[ORM\Column]
    private ?int $term = null;

    #[ORM\Column]
    private ?bool $isFile = null;

    #[ORM\Column(length: 10, enumType: NoteStatus::class)]
    private ?NoteStatus $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $timeCreated = null;

    #[ORM\Column]
    private ?int $visits = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'note', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'createdNotes')]
    private Collection $authors;

    /**
     * @var Collection<int, NoteRating>
     */
    #[ORM\OneToMany(targetEntity: NoteRating::class, mappedBy: 'note', orphanRemoval: true)]
    private Collection $ratings;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: NoteSubject::class)]
    private array $subjects = [];

    /**
     * @var Collection<int, ReadingList>
     */
    #[ORM\ManyToMany(targetEntity: ReadingList::class, mappedBy: 'notes')]
    private Collection $readingLists;

    /**
     * @var Collection<int, Report>
     */
    #[ORM\OneToMany(targetEntity: Report::class, mappedBy: 'note', orphanRemoval: true)]
    private Collection $reports;

    /**
     * @var Collection<int, MessageThread>
     */
    #[ORM\OneToMany(targetEntity: MessageThread::class, mappedBy: 'note', orphanRemoval: true)]
    private Collection $messageThreads;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->creators = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->readingLists = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->messageThreads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getTopics(): ?string
    {
        return $this->topics;
    }

    public function setTopics(string $topics): static
    {
        $this->topics = $topics;

        return $this;
    }

    public function getYear(): ?NoteYear
    {
        return $this->year;
    }

    public function setYear(NoteYear $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getTerm(): ?int
    {
        return $this->term;
    }

    public function setTerm(int $term): static
    {
        $this->term = $term;

        return $this;
    }

    public function isFile(): ?bool
    {
        return $this->isFile;
    }

    public function setIsFile(bool $isFile): static
    {
        $this->isFile = $isFile;

        return $this;
    }

    public function getStatus(): ?NoteStatus
    {
        return $this->status;
    }

    public function setStatus(NoteStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTimeCreated(): ?\DateTimeImmutable
    {
        return $this->timeCreated;
    }

    public function setTimeCreated(\DateTimeImmutable $timeCreated): static
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    public function getVisits(): ?int
    {
        return $this->visits;
    }

    public function setVisits(int $visits): static
    {
        $this->visits = $visits;

        return $this;
    }

    /**
     * @return NoteSubject[]
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    public function setSubjects(array $subjects): static
    {
        $this->subjects = $subjects;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setNote($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getNote() === $this) {
                $comment->setNote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(User $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addCreatedNote($this);
        }

        return $this;
    }

    public function removeCreator(User $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeCreatedNote($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteRating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(NoteRating $rating): static
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setNote($this);
        }

        return $this;
    }

    public function removeRating(NoteRating $rating): static
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getNote() === $this) {
                $rating->setNote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReadingList>
     */
    public function getReadingLists(): Collection
    {
        return $this->readingLists;
    }

    public function addReadingList(ReadingList $readingList): static
    {
        if (!$this->readingLists->contains($readingList)) {
            $this->readingLists->add($readingList);
            $readingList->addNote($this);
        }

        return $this;
    }

    public function removeReadingList(ReadingList $readingList): static
    {
        if ($this->readingLists->removeElement($readingList)) {
            $readingList->removeNote($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setNote($this);
        }

        return $this;
    }

    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getNote() === $this) {
                $report->setNote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessageThread>
     */
    public function getMessageThreads(): Collection
    {
        return $this->messageThreads;
    }

    public function addMessageThread(MessageThread $messageThread): static
    {
        if (!$this->messageThreads->contains($messageThread)) {
            $this->messageThreads->add($messageThread);
            $messageThread->setNote($this);
        }

        return $this;
    }

    public function removeMessageThread(MessageThread $messageThread): static
    {
        if ($this->messageThreads->removeElement($messageThread)) {
            // set the owning side to null (unless already changed)
            if ($messageThread->getNote() === $this) {
                $messageThread->setNote(null);
            }
        }

        return $this;
    }
}
