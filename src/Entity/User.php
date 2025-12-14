<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(length: 255)]
    private ?string $pfpLink = null;

    #[ORM\Column]
    private ?int $notesVisited = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\ManyToMany(targetEntity: Note::class, inversedBy: 'creators')]
    private Collection $createdNotes;

    /**
     * @var Collection<int, NoteRating>
     */
    #[ORM\OneToMany(targetEntity: NoteRating::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $noteRatings;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastUploadTime = null;

    /**
     * @var Collection<int, ReadingList>
     */
    #[ORM\OneToMany(targetEntity: ReadingList::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $readingLists;

    /**
     * @var Collection<int, CanvasPixel>
     */
    #[ORM\OneToMany(targetEntity: CanvasPixel::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $canvasPixels;

    /**
     * @var Collection<int, Report>
     */
    #[ORM\OneToMany(targetEntity: Report::class, mappedBy: 'reporter', orphanRemoval: true)]
    private Collection $reports;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'sender', orphanRemoval: true)]
    private Collection $sentMessages;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'receiver', orphanRemoval: true)]
    private Collection $receivedMessages;

    /**
     * @var Collection<int, UserTag>
     */
    #[ORM\OneToMany(targetEntity: UserTag::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $tags;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->createdNotes = new ArrayCollection();
        $this->noteRatings = new ArrayCollection();
        $this->readingLists = new ArrayCollection();
        $this->canvasPixels = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->sentMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getPfpLink(): ?string
    {
        return $this->pfpLink;
    }

    public function setPfpLink(string $pfpLink): static
    {
        $this->pfpLink = $pfpLink;

        return $this;
    }

    public function getNotesVisited(): ?int
    {
        return $this->notesVisited;
    }

    public function setNotesVisited(int $notesVisited): static
    {
        $this->notesVisited = $notesVisited;

        return $this;
    }

    public function getLastUploadTime(): ?\DateTimeImmutable
    {
        return $this->lastUploadTime;
    }

    public function setLastUploadTime(\DateTimeImmutable $lastUploadTime): static
    {
        $this->lastUploadTime = $lastUploadTime;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getCreatedNotes(): Collection
    {
        return $this->createdNotes;
    }

    public function addCreatedNote(Note $createdNote): static
    {
        if (!$this->createdNotes->contains($createdNote)) {
            $this->createdNotes->add($createdNote);
        }

        return $this;
    }

    public function removeCreatedNote(Note $createdNote): static
    {
        $this->createdNotes->removeElement($createdNote);

        return $this;
    }

    /**
     * @return Collection<int, NoteRating>
     */
    public function getNoteRatings(): Collection
    {
        return $this->noteRatings;
    }

    public function addNoteRating(NoteRating $noteRating): static
    {
        if (!$this->noteRatings->contains($noteRating)) {
            $this->noteRatings->add($noteRating);
            $noteRating->setUser($this);
        }

        return $this;
    }

    public function removeNoteRating(NoteRating $noteRating): static
    {
        if ($this->noteRatings->removeElement($noteRating)) {
            // set the owning side to null (unless already changed)
            if ($noteRating->getUser() === $this) {
                $noteRating->setUser(null);
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
            $readingList->setUser($this);
        }

        return $this;
    }

    public function removeReadingList(ReadingList $readingList): static
    {
        if ($this->readingLists->removeElement($readingList)) {
            // set the owning side to null (unless already changed)
            if ($readingList->getUser() === $this) {
                $readingList->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CanvasPixel>
     */
    public function getCanvasPixels(): Collection
    {
        return $this->canvasPixels;
    }

    public function addCanvasPixel(CanvasPixel $canvasPixel): static
    {
        if (!$this->canvasPixels->contains($canvasPixel)) {
            $this->canvasPixels->add($canvasPixel);
            $canvasPixel->setUser($this);
        }

        return $this;
    }

    public function removeCanvasPixel(CanvasPixel $canvasPixel): static
    {
        if ($this->canvasPixels->removeElement($canvasPixel)) {
            // set the owning side to null (unless already changed)
            if ($canvasPixel->getUser() === $this) {
                $canvasPixel->setUser(null);
            }
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
            $report->setReporter($this);
        }

        return $this;
    }

    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getReporter() === $this) {
                $report->setReporter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSentMessages(): Collection
    {
        return $this->sentMessages;
    }

    public function addSentMessage(Message $sentMessage): static
    {
        if (!$this->sentMessages->contains($sentMessage)) {
            $this->sentMessages->add($sentMessage);
            $sentMessage->setSender($this);
        }

        return $this;
    }

    public function removeSentMessage(Message $sentMessage): static
    {
        if ($this->sentMessages->removeElement($sentMessage)) {
            // set the owning side to null (unless already changed)
            if ($sentMessage->getSender() === $this) {
                $sentMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getReceivedMessages(): Collection
    {
        return $this->receivedMessages;
    }

    public function addReceivedMessage(Message $receivedMessage): static
    {
        if (!$this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages->add($receivedMessage);
            $receivedMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $receivedMessage): static
    {
        if ($this->receivedMessages->removeElement($receivedMessage)) {
            // set the owning side to null (unless already changed)
            if ($receivedMessage->getReceiver() === $this) {
                $receivedMessage->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(UserTag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->setUser($this);
        }

        return $this;
    }

    public function removeTag(UserTag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getUser() === $this) {
                $tag->setUser(null);
            }
        }

        return $this;
    }
}
