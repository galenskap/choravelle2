<?php
namespace App\Enum;

enum BlockTemplatesEnum: string
{
    case Editor = 'editor';
    case Banner = 'banner';
    case Cards = 'cards';
    case Illustration = 'illustration';
    case Icons = 'icons';
    case ContactForm = 'contact-form';
}