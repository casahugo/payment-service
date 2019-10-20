<?php

declare(strict_types=1);

namespace App\Gateway\Contract;

use App\ArrayableInterface;
use App\Gateway\UserInterface;

interface ResponseUserInterface extends ArrayableInterface, UserInterface
{

}
