<?php

namespace Brainapp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BrainappUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
