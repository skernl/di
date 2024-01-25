<?php
declare(strict_types=1);

namespace App\Controller;

use Skernl\Di\Annotation\Inject;

class IndexController
{
//    #[Inject]
//    protected Index $index;

    public function __construct(protected Index $index)
    {
    }

    public function getDefaultValue()
    {
        return $this->index->action() * 2;
//        return 200569;
    }
}