<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $chassisNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $manufactureDate = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column]
    private ?int $power = null;

    #[ORM\Column(nullable: true)]
    private ?int $doorNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $seatNumber = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $interior = null;

    #[ORM\Column(length: 255)]
    private ?string $transmissionType = null;

    #[ORM\Column]
    private ?int $gears = null;

    #[ORM\Column(length: 255)]
    private ?string $gearbox = null;

    #[ORM\Column(nullable: true)]
    private ?int $cylinderCapacity = null;

    #[ORM\Column(nullable: true)]
    private ?int $cylinderNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $consumption = null;

    #[ORM\Column(nullable: true)]
    private ?int $tareWeight = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255)]
    private ?string $fuelType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;

    #[ORM\ManyToMany(targetEntity: Order::class, inversedBy: 'cars')]
    private Collection $orders;

    #[ORM\ManyToMany(targetEntity: Color::class, inversedBy: 'cars')]
    private Collection $colors;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->colors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChassisNumber(): ?string
    {
        return $this->chassisNumber;
    }

    public function setChassisNumber(string $chassisNumber): self
    {
        $this->chassisNumber = $chassisNumber;

        return $this;
    }

    public function getManufactureDate(): ?\DateTimeInterface
    {
        return $this->manufactureDate;
    }

    public function setManufactureDate(\DateTimeInterface $manufactureDate): self
    {
        $this->manufactureDate = $manufactureDate;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getDoorNumber(): ?int
    {
        return $this->doorNumber;
    }

    public function setDoorNumber(?int $doorNumber): self
    {
        $this->doorNumber = $doorNumber;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(?int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getInterior(): ?string
    {
        return $this->interior;
    }

    public function setInterior(?string $interior): self
    {
        $this->interior = $interior;

        return $this;
    }

    public function getTransmissionType(): ?string
    {
        return $this->transmissionType;
    }

    public function setTransmissionType(string $transmissionType): self
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    public function getGears(): ?int
    {
        return $this->gears;
    }

    public function setGears(int $gears): self
    {
        $this->gears = $gears;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): self
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getCylinderCapacity(): ?int
    {
        return $this->cylinderCapacity;
    }

    public function setCylinderCapacity(?int $cylinderCapacity): self
    {
        $this->cylinderCapacity = $cylinderCapacity;

        return $this;
    }

    public function getCylinderNumber(): ?int
    {
        return $this->cylinderNumber;
    }

    public function setCylinderNumber(?int $cylinderNumber): self
    {
        $this->cylinderNumber = $cylinderNumber;

        return $this;
    }

    public function getConsumption(): ?string
    {
        return $this->consumption;
    }

    public function setConsumption(?string $consumption): self
    {
        $this->consumption = $consumption;

        return $this;
    }

    public function getTareWeight(): ?int
    {
        return $this->tareWeight;
    }

    public function setTareWeight(?int $tareWeight): self
    {
        $this->tareWeight = $tareWeight;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * @return Collection<int, Color>
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Color $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors->add($color);
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        $this->colors->removeElement($color);

        return $this;
    }
}
