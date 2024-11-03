<?php

namespace App\Request\User;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShowRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    protected int $id;
}