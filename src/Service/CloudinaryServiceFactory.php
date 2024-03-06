<?php

namespace App\Service;

use Cloudinary\Cloudinary;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CloudinaryFactory
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(): Cloudinary
    {
        
     
        return new Cloudinary([
            'cloud_name' => 'dtnhymuza', 
            'api_key' => '841544276497521', 
            'api_secret' => 'Xcv3hd_-wqTsBvpk3yNvBc5fPfw'
        ]);
    }
}