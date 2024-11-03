<?php

namespace App\Request\User;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UpdateRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    protected int $id;

    #[Type('string')]
    #[NotBlank()]
    #[Length(max: 8)]
    protected string $login;
    
    #[Type('string')]
    #[NotBlank()]
    #[Length(max: 8)]
    protected string $phone;

    #[Type('string')]
    #[NotBlank()]
    #[Length(max: 8)]
    protected string $pass;
}