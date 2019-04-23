<?php

namespace Cherry\Controller;

class HelloController
{
    use ControllerTrait;

    public function hello()
    {
        $this->render('hello/index');
    }
}
