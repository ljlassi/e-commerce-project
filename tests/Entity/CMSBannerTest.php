<?php


namespace App\Tests\Entity;


use App\Entity\CMSBanner;
use PHPUnit\Framework\TestCase;

class CMSBannerTest extends TestCase {
    public function testSetImageUrl() {
        $imageUrl = "test.jpg";
        $cmsBanner = new CMSBanner();
        $cmsBanner->setImageUrl($imageUrl);
        $this->assertEquals($imageUrl, $cmsBanner->getImageUrl());
    }

    public function testSetAlt() {
        $alt = "Alt text...";
        $cmsBanner = new CMSBanner();
        $cmsBanner->setAlt($alt);
        $this->assertEquals($alt, $cmsBanner->getAlt());
    }
}