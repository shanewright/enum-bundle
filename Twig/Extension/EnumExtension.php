<?php

namespace Yokai\EnumBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig_Extension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Yokai\EnumBundle\Registry\EnumRegistryInterface;

/**
 * @author Yann Eugoné <eugone.yann@gmail.com>
 */
class EnumExtension extends AbstractExtension
{
    /**
     * @var EnumRegistryInterface
     */
    private $registry;

    /**
     * @param EnumRegistryInterface $registry
     */
    public function __construct(EnumRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('enum_label', [$this, 'getLabel']),
            new TwigFunction('enum_choices', [$this, 'getChoices']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new TwigFilter('enum_label', [$this, 'getLabel']),
        ];
    }

    /**
     * @param string $value
     * @param string $enum
     *
     * @return string
     */
    public function getLabel($value, $enum)
    {
        $choices = $this->getChoices($enum);

        if (isset($choices[$value])) {
            return $choices[$value];
        }

        return $value;
    }

    /**
     * @param string $enum
     *
     * @return array
     */
    public function getChoices($enum)
    {
        return $this->registry->get($enum)->getChoices();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'enum';
    }
}
