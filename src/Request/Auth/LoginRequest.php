<?php

namespace App\Request\Auth;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class LoginRequest extends BaseRequest
{
    #[Type('string')]
    #[NotBlank()]
    #[Length(max: 8)]
    protected string $login;

    #[Type('string')]
    #[NotBlank()]
    #[Length(max: 8)]
    protected string $pass;
}