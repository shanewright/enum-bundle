<?php

namespace Acme\Bundle\AppBundle\Enum\Customer;

use Yokai\EnumBundle\Enum\AbstractTranslatedEnum;

/**
 * @author Yann Eugoné <eugone.yann@gmail.com>
 */
class StateEnum extends AbstractTranslatedEnum
{
    protected function getValues()
    {
        return ['new', 'validated', 'disabled'];
    }

    public function getName()
    {
        return 'state';
    }
}
