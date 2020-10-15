<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Sylius\Bundle\ResourceBundle\SyliusResourceBundle::class => ['all' => true],
    BabDev\PagerfantaBundle\BabDevPagerfantaBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class => ['all' => true],
    AppBundle\AppBundle::class => ['all' => true],
    FOS\RestBundle\FOSRestBundle::class => ['test' => true],
    JMS\SerializerBundle\JMSSerializerBundle::class => ['test' => true],
    Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle::class => ['test' => true],
    Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle::class => ['test' => true],
    Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle::class => ['test' => true],
    winzou\Bundle\StateMachineBundle\winzouStateMachineBundle::class => ['test' => true, 'test_without_fosrest' => true]
];
