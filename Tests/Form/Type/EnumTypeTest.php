<?php

namespace Yokai\EnumBundle\Tests\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Test\TypeTestCase;
use Yokai\EnumBundle\Form\Type\EnumType;
use Yokai\EnumBundle\Tests\Fixtures\GenderEnum;
use Yokai\EnumBundle\Tests\Form\TestExtension;

/**
 * @author Yann Eugoné <eugone.yann@gmail.com>
 */
class EnumTypeTest extends TypeTestCase
{
    private $enumRegistry;

    protected function setUp()
    {
        $this->enumRegistry = $this->prophesize('Yokai\EnumBundle\Registry\EnumRegistryInterface');
        $this->enumRegistry->has('state')->willReturn(false);
        $this->enumRegistry->has(GenderEnum::class)->willReturn(true);
        $this->enumRegistry->get(GenderEnum::class)->willReturn(new GenderEnum);

        parent::setUp();
    }

    public function testEnumOptionIsRequired()
    {
        $this->expectException('Symfony\Component\OptionsResolver\Exception\MissingOptionsException');
        $this->createForm();
    }

    public function testEnumOptionIsInvalid()
    {
        $this->expectException('Symfony\Component\OptionsResolver\Exception\InvalidOptionsException');
        $this->createForm('state');
    }

    public function testEnumOptionValid()
    {
        $form = $this->createForm(GenderEnum::class);

        $this->assertEquals(['Male' => 'male', 'Female' => 'female'], $form->getConfig()->getOption('choices'));
    }

    protected function getExtensions()
    {
        return [
            new TestExtension($this->enumRegistry->reveal())
        ];
    }

    private function createForm($enum = null)
    {
        $options = [];
        if ($enum) {
            $options['enum'] = $enum;
        }

        if (method_exists(AbstractType::class, 'getBlockPrefix')) {
            $name = EnumType::class; //Symfony 3.x support
        } else {
            $name = 'enum'; //Symfony 2.x support
        }

        return $this->factory->create($name, null, $options);
    }
}
