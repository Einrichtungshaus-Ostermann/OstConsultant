<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

namespace OstConsultant\Models;

use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;

/**
 * @ORM\Entity(repositoryClass="Repository")
 * @ORM\Table(name="ost_consultant_discounts",uniqueConstraints={@ORM\UniqueConstraint(name="unique_numbers", columns={"number", "company"})})
 */
class Discount extends ModelEntity
{
    /**
     * ...
     */
    const TYPE_ABSOLUTE = "A";
    const TYPE_PERCENTAGE = "P";

    /**
     * ...
     */
    const TARGET_HEAD = "K";
    const TARGET_POSITION = "P";

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * ...
     *
     * @var int
     *
     * @ORM\Column(name="company", type="integer", nullable=false)
     */
    private $company = 1;

    /**
     * ...
     *
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number =  140;

    /**
     * ...
     *
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false, length=8)
     */
    private $type;

    /**
     * ...
     *
     * @var string
     *
     * @ORM\Column(name="target", type="string", nullable=false, length=8)
     */
    private $target;

    /**
     * ...
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false, length=64)
     */
    private $name = "Personal- Mitarbeiternachlass";

    /**
     * ...
     *
     * @var float
     *
     * @ORM\Column(name="value", type="float", nullable=false)
     */
    private $value;

    /**
     * ...
     *
     * @var boolean
     *
     * @ORM\Column(name="fixed", type="boolean", nullable=false)
     */
    private $fixed = true;

    /**
     * Getter method for the property.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter method for the property.
     *
     * @return int
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Setter method for the property.
     *
     * @param int $company
     *
     * @return void
     */
    public function setCompany(int $company)
    {
        $this->company = $company;
    }

    /**
     * Getter method for the property.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Setter method for the property.
     *
     * @param int $number
     *
     * @return void
     */
    public function setNumber(int $number)
    {
        $this->number = $number;
    }

    /**
     * Getter method for the property.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter method for the property.
     *
     * @param string $type
     *
     * @return void
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Getter method for the property.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Setter method for the property.
     *
     * @param string $target
     *
     * @return void
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * Getter method for the property.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter method for the property.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Getter method for the property.
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Setter method for the property.
     *
     * @param float $value
     *
     * @return void
     */
    public function setValue(float $value)
    {
        $this->value = $value;
    }

    /**
     * Getter method for the property.
     *
     * @return bool
     */
    public function getFixed()
    {
        return $this->fixed;
    }

    /**
     * Setter method for the property.
     *
     * @param bool $fixed
     *
     * @return void
     */
    public function setFixed(bool $fixed)
    {
        $this->fixed = $fixed;
    }

}
